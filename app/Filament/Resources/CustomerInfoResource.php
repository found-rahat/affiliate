<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerInfo;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\HasTabs;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerInfoResource\Pages;
use App\Filament\Resources\CustomerInfoResource\RelationManagers;

class CustomerInfoResource extends Resource
{
    use HasTabs;
    protected static ?string $model = CustomerInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $modelLabel = 'Order List';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Pending')->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('orderProducts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Info')
                    ->schema([
                        TextInput::make('order_number')->columnSpan(2), 
                        TextInput::make('name')->columnSpan(2), 
                        TextInput::make('address')->columnSpan(2), 
                        TextInput::make('phone')->columnSpan(2), 
                        TextInput::make('order_create_time')->disabled(), 
                        TextInput::make('status')->disabled(), 
                        TextInput::make('user.name')->label('User')->disabled()
                            ->formatStateUsing(fn($state, $record) => $record->user->name), 
                        TextInput::make('shipped_time')->disabled()
                        ])->collapsible()->columnSpan(2),
                Section::make('Payment Information')
                    ->schema([
                        TextInput::make('total_paid')->readOnly()->columnSpan(2),
                        TextInput::make('shipping_fee'),
                        TextInput::make('shipping_provider'),
                        TextInput::make('discount')
                            ->numeric()
                            ->columnSpan(2)
                            ->formatStateUsing(fn ($state) => $state ?? 0),
                        TextInput::make('pre_payment')->columnSpan(2),
                        TextInput::make('user.id')->label('Grand Amount')->readOnly()
                            ->formatStateUsing(function ($state, $record) {
                                $total = $record->total_paid + $record->shipping_fee - (($record->pre_payment ?? 0) + ($record->discount ?? 0));
                                return "{$total}";
                            })->columnSpan(2),
                    ])->columnSpan(2)->collapsible(),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->label('Customer Info')->searchable()->sortable()->toggleable()
                    ->html()->limit(40)
                    ->getStateUsing(
                        fn($record) => "{$record->name}<br> {$record->address}<br>{$record->phone}"
                    ),
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('phone')
                    ->label('Amount')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Amount')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $total = $record->total_paid + $record->shipping_fee - (($record->pre_payment ?? 0) + ($record->discount ?? 0));
                        return "T: {$record->total_paid}<br>" . "C: {$record->shipping_fee}<br>" . '<strong>P: </strong>' . ($record->pre_payment ?? 0) . '<br>' . 'D: ' . ($record->discount ?? 0) . '<br>' . "<strong>Total:</strong> {$total}";
                    }),
                TextColumn::make('address')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Product Images')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $products = $record->orderProducts ?? [];

                        // সব ইমেজ অ্যারে তৈরি করবো
                        $allImages = collect($products)->flatMap(function ($product) {
                            // যদি images ফিল্ড ইতিমধ্যে অ্যারে হয়
                            if (is_array($product->image)) {
                                return $product->image;
                            }

                            // যদি string হয় তাহলে decode করবো
                            if (is_string($product->image)) {
                                return json_decode($product->image, true) ?? [];
                            }

                            return [];
                        });

                        // HTML বানিয়ে রিটার্ন
                        return $allImages
                            ->map(function ($img) {
                                $url = asset('storage/' . ltrim($img, '/'));
                                return "<img src='{$url}' style='width:80px; height:80px; margin:5px; border-radius:4px;' />";
                            })
                            ->implode('');
                    }),

                TextColumn::make('order_create_time')->label('Order Date')->date('d M y')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->formatStateUsing(fn(string $state) => ucfirst($state))
                    ->icon(
                        fn(string $state) => match ($state) {
                            'Pending' => 'heroicon-o-clock',
                            'Processing' => 'heroicon-o-pencil',
                            'Hold' => 'heroicon-o-check-badge',
                            'Packing' => 'heroicon-o-presentation-chart-line',
                            'Shipped' => 'heroicon-o-shield-exclamation',
                            'Delivered' => 'heroicon-o-heart',
                            'Delivery_Failed' => 'heroicon-o-x-circle',
                            'Canceled' => 'heroicon-o-exclamation-circle',
                            default => null,
                        },
                    )
                    ->color(
                        fn(string $state) => match ($state) {
                            'Pending' => 'warning',
                            'Processing' => '',
                            'Hold' => 'danger',
                            'Packing' => 'secondary',
                            'Shipped' => 'info',
                            'Delivered' => 'success',
                            'Delivery_Failed' => 'danger',
                            'Canceled' => 'danger',
                            'Unpaid' => 'info',
                            default => 'secondary',
                        },
                    ),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn(CustomerInfo $record) => in_array($record->status, ['Pending', 'Hold', 'Processing']))
                ])

            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),

                BulkAction::make('print_invoices')
                    ->label('Print Invoices')
                    ->color('success')
                    ->icon('heroicon-o-printer')
                    ->action(function (Collection $records) {
                        $barcodes = [];
                        $generator = new BarcodeGeneratorPNG();

                        foreach ($records as $record) {
                            $barcodeData = $generator->getBarcode($record->order_number, $generator::TYPE_CODE_128);
                            $barcodes[$record->order_number] = base64_encode($barcodeData);
                        }

                        $pdf = Pdf::loadView('bulk-invoices', [
                            'customers' => $records,
                            'barcodes' => $barcodes, // ✅ Correct here
                        ]);
                        $pdf_name = \Carbon\Carbon::now()->format('Y-m-d H-i-s');
                        return response()->streamDownload(
                            fn() => print $pdf->output(), 
                            $pdf_name . '.pdf'
                        );
                    }),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerInfos::route('/'),
            'create' => Pages\CreateCustomerInfo::route('/create'),
            'view' => Pages\ViewCustomerInfo::route('/{record}'),
            'edit' => Pages\EditCustomerInfo::route('/{record}/edit'),
        ];
    }
}

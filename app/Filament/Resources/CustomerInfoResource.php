<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerInfo;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerInfoResource\Pages;
use App\Filament\Resources\CustomerInfoResource\RelationManagers;
use Filament\Resources\Concerns\HasTabs;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->label('Customer Info')->searchable()->sortable()->toggleable()
                    ->html()
                    ->getStateUsing(fn ($record) => "{$record->name}<br> {$record->address}<br>{$record->phone}"),
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('phone')->label('Amount')->searchable()->sortable()->toggleable()
                    ->label('Amount')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $total = ($record->total_paid + $record->shipping_fee) - (($record->pre_payment ?? 0) + ($record->discount ?? 0));
                        return "T: {$record->total_paid}<br>" .
                            "C: {$record->shipping_fee}<br>" .
                            "<strong>P: </strong>" . ($record->pre_payment ?? 0) . "<br>" .
                            "D: " . ($record->discount ?? 0) . "<br>" .
                            "<strong>Total:</strong> {$total}";
                    }),
                TextColumn::make('address')->searchable()->sortable()->toggleable()
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
                        return $allImages->map(function ($img) {
                            $url = asset('storage/' . ltrim($img, '/'));
                            return "<img src='{$url}' style='width:80px; height:80px; margin:5px; border-radius:4px;' />";
                        })->implode('');
                    }),



                
                    TextColumn::make('order_create_time')->label('Order Date')->date('d M y')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->label('Status')->searchable()->sortable()->toggleable()
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->icon(fn (string $state) => match ($state) {
                        'Pending' => 'heroicon-o-clock',
                        'Processing' => 'heroicon-o-pencil',
                        'Hold' => 'heroicon-o-check-badge',
                        'Packing' => 'heroicon-o-presentation-chart-line',
                        'Shipped' => 'heroicon-o-shield-exclamation',
                        'Delivered' => 'heroicon-o-heart',
                        'Delivery_Failed' => 'heroicon-o-x-circle',
                        'Canceled' => 'heroicon-o-exclamation-circle',
                        default => null,
                    })
                    ->color(fn (string $state) => match ($state) {
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
                    }),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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

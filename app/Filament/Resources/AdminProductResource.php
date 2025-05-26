<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AdminProduct;
use Filament\Resources\Resource;
use App\Models\CollectionUserInfo;
use App\Models\CollectProductStock;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use App\Models\CollectProductStockList;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdminProductResource\Pages;
use App\Filament\Resources\AdminProductResource\RelationManagers;
use App\Filament\Resources\AdminProductResource\Pages\EditAdminProduct;
use App\Filament\Resources\AdminProductResource\Pages\ViewAdminProduct;
use App\Filament\Resources\AdminProductResource\Pages\ListAdminProducts;
use App\Filament\Resources\AdminProductResource\Pages\CreateAdminProduct;

class AdminProductResource extends Resource
{
    protected static ?string $model = AdminProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Product Management';

    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information')
                    ->schema([
                        TextInput::make('product_name'),
                        TextInput::make('sku')
                            ->default('pro-' . rand())
                            ->readOnly(),
                        Select::make('categories_id')->relationship('Categories', 'name')->label('Catagories'),
                        TextInput::make('brand'),
                        RichEditor::make('description')->columnSpan(2),
                    ])->collapsible()->columnspan(4),

                Section::make('Marking')
                    ->schema([
                        Section::make('Pricing')
                            ->schema([ 
                                TextInput::make('sell_price')])
                            ->collapsible(),
                        Section::make('Files')
                            ->schema([
                                FileUpload::make('image')->disk('public')->directory('images')->multiple(), 
                                TagsInput::make('tags'), Checkbox::make('status')])
                            ->collapsible(),
                    ])
                    ->columnspan(3),
            ])
            ->columns(7);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('SL')->sortable()->searchable()->toggleable(), 
                ImageColumn::make('image'), 
                TextColumn::make('product_name')->limit(25)->sortable()->searchable()->toggleable(), 
                TextColumn::make('sku')->sortable()->searchable()->toggleable(), 
                TextColumn::make('Categories.name')->sortable()->searchable()->toggleable(),
                TextColumn::make('collectProductStock.paid_price')
                    ->label('Buy Price')
                    ->formatStateUsing(function ($record) {
                        $prices = CollectProductStock::where('admin_product_id', $record->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $price = number_format($prices->paid_price);
                        return $price;
                    })->sortable()->searchable()->toggleable(),


                TextColumn::make('collectProductStock.stock')
                    ->label('Stock Status')
                    ->formatStateUsing(function ($record) {
                        $stocks = number_format($record->collectProductStockList()->where('stock_status', 'Instock')->where('admin_product_id', $record->id)->count());
                        return $stocks;
                    })->sortable()->searchable()->toggleable(),


                TextColumn::make('sell_price')
                    ->label('Total')
                    ->formatStateUsing(function ($record) {
                        $price = CollectProductStock::where('admin_product_id', $record->id)
                            ->orderBy('id', 'desc')
                            ->value('paid_price') ?? 0;

                        $stocks = $record->collectProductStockList()
                            ->where('stock_status', 'Instock')
                            ->where('admin_product_id', $record->id)
                            ->count();

                        return number_format($price * $stocks);
                    })->sortable()->searchable()->toggleable(),

                TextColumn::make('brand')->sortable()->searchable()->toggleable(), 
                TextColumn::make('tags')->sortable()->searchable()->toggleable(), 
                CheckboxColumn::make('status')->sortable()->searchable()->toggleable(),
                ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Add Collect Stock')
                    ->label('Stock')
                    ->icon('heroicon-m-plus-circle')
                    ->modalHeading('Add Stock')
                    ->form([
                        Section::make('Info')->schema([
                            TextInput::make('collection_number')->default(Carbon::now()->format('dmY'))->label('Collection Id')->required()->readOnly(),
                            TextInput::make('admin_product_id')->label('Product Id')->default(fn($record) => $record->id)->readOnly(),
                            TextInput::make('quantity')->label('Add Quantity')->numeric()->required(),
                            TextInput::make('collection_user')
                                ->default(fn() => Auth::user()->id)
                                ->label('Collection User')
                                ->required()
                                ->readOnly(),
                            TextInput::make('paid_price')->label('Buy Price')->default(fn($record) => $record->buy_price)->numeric()->required(),
                        ])->columns(2),
                    ])
                    ->action(function (array $data) {
// -----------------------------------------Insert collect product stock start--------------------------------
                        CollectProductStock::insert([
                            'collection_number' => $data['collection_number'],
                            'admin_product_id' => $data['admin_product_id'],
                            'quantity' => $data['quantity'],
                            'paid_price' => $data['paid_price'],
                            'collection_user' => $data['collection_user'],
                            'created_at' => now()->timezone('Asia/Dhaka'),
                            'updated_at' => now()->timezone('Asia/Dhaka'),
                        ]);
                        Notification::make()
                        ->title('Stock added successfully!')
                        ->success()
                        ->send();

// ----------------------------------------Insert collect product stock end---------------------------------------
// -------------------------------------Insert collect product stock list start-----------------------------------
                        for ($i = 0; $i < $data['quantity']; $i++) {

                            $StockId = CollectProductStock::orderBy('id', 'desc')->first();
                            $collect_product_stock_id = $StockId->id;

                            CollectProductStockList::insert([
                                'collection_number' => $data['collection_number'],
                                'collect_product_stock_id'=>$collect_product_stock_id,
                                'admin_product_id' => $data['admin_product_id'],
                                'buy_price' => $data['paid_price'],
                                'collection_user' => $data['collection_user'],
                                'created_at' => now()->timezone('Asia/Dhaka'),
                                'updated_at' => now()->timezone('Asia/Dhaka'),
                            ]);
                        }
                        Notification::make()
                            ->title('Stock list added successfully!')
                            ->success()
                            ->send();

// -----------------------------------Insert collect product stock list end------------------------------

// ---------------------------------------Update admin product start-------------------------------------
                        $stocks =collectProductStockList::where('stock_status', 'Instock')
                            ->where('admin_product_id', $data['admin_product_id'])
                            ->count();
                        AdminProduct::where('id', $data['admin_product_id'])->update([
                            'buy_price' => $data['paid_price'],
                            'stock' => $stocks,
                            ]);

// -----------------------------------Update admin product end--------------------------------------

// ---------------------------------total Value Update balance Start--------------------------------

                        $price = CollectProductStock::where('collection_number', $data['collection_number'])
                            ->selectRaw('SUM(quantity * paid_price) as total_value')
                            ->value('total_value') ?? 0;

                        $quantity = CollectProductStock::where('collection_number', $data['collection_number'])
                            ->selectRaw('SUM(quantity) as total_quantity')
                            ->value('total_quantity') ?? 0;

                        CollectionUserInfo::where('collection_number',$data['collection_number'])->update([
                            'total_value' => number_format($price, 2),
                            'quantity' => $quantity,
                        ]);
                        Notification::make()
                            ->title('Update Total added successfully!')
                            ->success()
                            ->send();
// -----------------------------------total Value Update balance End---------------------------------


                    })->color('success'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                ])
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
            'index' => Pages\ListAdminProducts::route('/'),
            'create' => Pages\CreateAdminProduct::route('/create'),
            'view' => Pages\ViewAdminProduct::route('/{record}'),
            'edit' => Pages\EditAdminProduct::route('/{record}/edit'),
        ];
    }
}

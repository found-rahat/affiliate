<?php

namespace App\Filament\Resources;


use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AdminProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use App\Models\CollectionUserInfo;
use App\Models\CollectProductStock;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use App\Models\CollectProductStockList;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollectProductStockResource\Pages;
use App\Filament\Resources\CollectProductStockResource\RelationManagers;
use App\Filament\Resources\CollectProductStockResource\RelationManagers\CollectproductstocklistRelationManager;

class CollectProductStockResource extends Resource
{
    protected static ?string $model = CollectProductStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Product Management';
    protected static function getNavigationGroupCollapsible(): bool
    {
        return false;
    }
        
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->label('Collect product stock id')->visibleOn('edit')->readOnly(),
                TextInput::make('admin_product_id')->label('Admin Product Id')->readOnly()->visibleOn('edit'),
                TextInput::make('collection_number')->label('Collection Id')->readOnly()->visibleOn('edit'),
                TextInput::make('collection_user')->label('Collection User')->readOnly()->visibleOn('edit'),
                Select::make('product_name')->disabledOn('edit')->visibleOn('edit')
                        ->relationship('AdminProduct','product_name')
                        ->label('Product Name'),
                Select::make('sku')->disabledOn('edit')->visibleOn('edit')
                        ->relationship('AdminProduct','sku')
                        ->label('SKU'),
                TextInput::make('quantity')->visibleOn('edit')
                ->afterStateUpdated(function ($state, callable $get) {
                        $collectProductStockId = $get('id');
                        $newQuantity = $state;
// ----------------------------Extra Increase stocks list insert start------------------------------------
                        // Get the current stock list count
                        $listCount = CollectProductStockList::where('collect_product_stock_id', $collectProductStockId)->count();

                        // If new quantity is higher, add the difference
                        if ($newQuantity > $listCount) {
                            $rowsToAdd = $newQuantity - $listCount;

                            for ($i = 0; $i < $rowsToAdd; $i++) {
                                CollectProductStockList::create([
                                    'collect_product_stock_id' => $collectProductStockId,
                                    'collection_number' => $get('collection_number'),
                                    'admin_product_id' => $get('admin_product_id'),
                                    'collection_user' => $get('collection_user'),
                                    'buy_price' => $get('paid_price'),
                                ]);
                            }
                            Notification::make()
                                ->title('Stock list updated successfully!')
                                ->success()
                                ->send();
                        }
// ------------------------------Extra Increase stocks list insert End-------------------------------------

// ----------------------------admin product stock and buy price updated start -------------------------
                        $stocks =collectProductStockList::where('stock_status', 'Instock')
                            ->where('admin_product_id', $get('admin_product_id'))
                            ->count();

                        AdminProduct::where('id', $get('admin_product_id'))->update([
                            'buy_price' => $get('paid_price'),
                            'stock' => $stocks,
                            ]);

                        Notification::make()
                            ->title('Buy price and Stock updated successfully!')
                            ->success()
                            ->send();

// ----------------------------admin product stock and buy price updated end -----------------------------


                    }),
                
// -------------------------Update Buy Price in collection product stock list start-----------------------
                    TextInput::make('paid_price')->visibleOn('edit')
                    ->afterStateUpdated(function ($state, callable $get) {
                        CollectProductStockList::where('collect_product_stock_id',$get('id'))->update([
                            'buy_price' => $get('paid_price'),
                    ]);
                }),
// -------------------------Update Buy Price in collection product stock list End-------------------------


            ]);


    }
    public static function table(Table $table): Table
    {
        $latestCollectionNumber = CollectProductStock::orderBy('collection_number', 'desc')->first()?->collection_number;
        return $table
            ->columns([
                TextColumn::make('index')->rowIndex()->label('SL')->sortable()->searchable()->toggleable(), 
                TextColumn::make('collection_number')->label('Collection id')->sortable()->searchable()->toggleable(),
                TextColumn::make('admin_product_id')->label('Product id')->sortable()->searchable()->toggleable(),
                ImageColumn::make('AdminProduct.image')->label('Images'), 
                TextColumn::make('AdminProduct.product_name')->label('Product Name')->limit(25)->sortable()->searchable()->toggleable(), 
                TextColumn::make('AdminProduct.sku')->label('SKU')->sortable()->searchable()->toggleable(), 
                TextColumn::make('paid_price')->sortable()->searchable()->toggleable(), 
                TextColumn::make('quantity')->sortable()->searchable()->toggleable(), 
                TextColumn::make('user.name')->label('Collection User')->limit(25)->sortable()->searchable()->toggleable(),
                TextColumn::make('created_at')->datetime('d M y')
            ])
            ->filters([
                Filter::make('latest_collection')
                    ->label('Latest Collection')
                    ->default(true)
                    ->query(fn ($query) => $latestCollectionNumber
                        ? $query->where('collection_number', $latestCollectionNumber)
                        : $query),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('printBarcodes')
                    ->label('Print Barcodes')
                    ->action(function (Collection $orders) {
                        $barcodes = [];
                        $generator = new BarcodeGeneratorPNG();
// -----------------------------barcode print start----------------------------------
                        foreach ($orders as $order) {
                                // Get all the product stock lists for the current order
                                $productStockLists = CollectProductStockList::where('collect_product_stock_id', $order->id)->get();

                                // Generate barcodes for each product in the list
                                foreach ($productStockLists as $item) {
                                    $barcodeData = $generator->getBarcode($item->id, $generator::TYPE_CODE_128);
                                    $barcodes[] = [
                                        'id' => $item->id,
                                        'Product_id' => $order->admin_product_id,
                                        'barcode' => base64_encode($barcodeData),
                                    ];
                                }
                            }

                        // Generate the PDF
                        $pdf = Pdf::loadView('barcodes', compact('barcodes'));
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'barcodes.pdf'
                        );
                        // return view('barcodes', compact('barcodes'));
                    })

// -----------------------------barcode print End----------------------------------

                    ->color('success')
                    ->icon('heroicon-o-printer')
                    // ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CollectproductstocklistRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollectProductStocks::route('/'),
            'create' => Pages\CreateCollectProductStock::route('/create'),
            'view' => Pages\ViewCollectProductStock::route('/{record}'),
            'edit' => Pages\EditCollectProductStock::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\AdminProduct;
use App\Models\CollectProductStock;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Widgets\TableWidget as BaseWidget;


class NeedProduct extends BaseWidget
{
    protected static ?int $sort = 10;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                AdminProduct::withCount([
                    'collectProductStockList as instock_count' => function ($query) {
                        $query->where('stock_status', 'Instock');
                    }
                ])->whereRaw('(select count(*)
                    from collect_product_stock_lists
                    where collect_product_stock_lists.admin_product_id = admin_products.id
                    and stock_status = "Instock"
                ) <= 200
            ')
            )
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('product_name')->limit(25)->sortable()->searchable()->toggleable(),
                TextColumn::make('collectProductStock.paid_price')
                    ->label('Buy Price')
                    ->formatStateUsing(function ($record) {
                        $prices = CollectProductStock::where('admin_product_id', $record->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $price = number_format($prices->paid_price);
                        return $price;
                    })->sortable()->searchable()->toggleable(),
                TextColumn::make('instock_count')
                    ->label('In-stock')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->emptyStateHeading('No products found')
            ->emptyStateDescription('There are no products available with 5 or fewer in-stock items.');;
    }
}

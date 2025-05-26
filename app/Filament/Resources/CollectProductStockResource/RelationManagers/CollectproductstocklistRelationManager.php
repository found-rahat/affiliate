<?php

namespace App\Filament\Resources\CollectProductStockResource\RelationManagers;

use App\Models\CollectProductStock;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CollectproductstocklistRelationManager extends RelationManager
{
    protected static string $relationship = 'collectproductstocklist';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('unique_number')->default('')->readOnly(),
                TextInput::make('collect_product_stock_id')->readOnly(),
                TextInput::make('admin_product_id')->readOnly(),
                TextInput::make('buy_price')->default('')->readOnly(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('admin_product_id')
            ->columns([
                // TextColumn::make('admin_product_id'),
                ImageColumn::make('AdminProduct.image'),
                TextColumn::make('AdminProduct.product_name'),
                TextColumn::make('buy_price'),
                TextColumn::make('user.name'),
                TextColumn::make('stock_status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

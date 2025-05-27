<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AddCartResource\Pages;
use App\Filament\Resources\AddCartResource\RelationManagers;
use App\Models\AddCart;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddCartResource extends Resource
{
    protected static ?string $model = AddCart::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $modelLabel = 'User Add Cart';
    protected static ?string $navigationGroup = 'User Panal';
    protected static ?int $navigationSort = 20;

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
                TextColumn::make('user_name'),
                TextColumn::make('product.product_name')->limit(20),
                ImageColumn::make('product.image'),
                TextColumn::make('sell_price'),
                TextColumn::make('quentity'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAddCarts::route('/'),
            'create' => Pages\CreateAddCart::route('/create'),
            'view' => Pages\ViewAddCart::route('/{record}'),
            'edit' => Pages\EditAddCart::route('/{record}/edit'),
        ];
    }
}

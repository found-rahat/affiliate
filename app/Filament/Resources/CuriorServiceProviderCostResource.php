<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CuriorServiceProviderCostResource\Pages;
use App\Filament\Resources\CuriorServiceProviderCostResource\RelationManagers;
use App\Models\CuriorServiceProviderCost;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CuriorServiceProviderCostResource extends Resource
{
    protected static ?string $model = CuriorServiceProviderCost::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $modelLabel = 'Curior Cost';
    protected static ?string $navigationGroup = 'User Panal';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('amount'),
                TextInput::make('title'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->label('Sl')->rowIndex(),
                TextColumn::make('name'),
                TextColumn::make('amount'),
                TextColumn::make('title'),
                CheckboxColumn::make('status'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCuriorServiceProviderCosts::route('/'),
            'create' => Pages\CreateCuriorServiceProviderCost::route('/create'),
            'view' => Pages\ViewCuriorServiceProviderCost::route('/{record}'),
            'edit' => Pages\EditCuriorServiceProviderCost::route('/{record}/edit'),
        ];
    }
}

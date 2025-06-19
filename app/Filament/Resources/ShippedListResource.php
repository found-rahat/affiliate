<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ShippedList;
use App\Models\ShippingProvider;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShippedListResource\Pages;
use App\Filament\Resources\ShippedListResource\RelationManagers;

class ShippedListResource extends Resource
{
    protected static ?string $model = ShippingProvider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Shipping list';
    protected static ?int $navigationSort = 7;

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('Shipped List View');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!Auth::user()->can('view all shipped lists')) {
            $query->where('user_name', Auth::user()->name);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'), 
                TextColumn::make('provider_name')->searchable()->sortable()->toggleable(), 
                TextColumn::make('total_product')->searchable()->sortable()->toggleable(), 
                TextColumn::make('user_name')->searchable()->sortable()->toggleable(), 
                TextColumn::make('status')->searchable()->sortable()->toggleable(), 
                TextColumn::make('created_at')->date('d-M-y')
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(), 
                Tables\Actions\DeleteAction::make()->visible(fn($record) => $record->status === 'Pending')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make()
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
            'index' => Pages\ListShippedLists::route('/'),
            'create' => Pages\CreateShippedList::route('/create'),
            'view' => Pages\ViewShippedList::route('/{record}'),
            'edit' => Pages\EditShippedList::route('/{record}/edit'),
        ];
    }
}

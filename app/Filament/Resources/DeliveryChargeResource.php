<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryChargeResource\Pages;
use App\Filament\Resources\DeliveryChargeResource\RelationManagers;
use App\Models\DeliveryCharge;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryChargeResource extends Resource
{
    protected static ?string $model = DeliveryCharge::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'User Panal';
    protected static ?int $navigationSort = 15 ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Welcome Message')->schema([
                    TextInput::make('title'),
                RichEditor::make('description'),
                ])->columnSpan(1),
                Section::make('Charge')->schema([
                    RichEditor::make('inside'),
                    RichEditor::make('sub_area'),
                    RichEditor::make('outside'),
                    Checkbox::make('status'),
                ])->columnSpan(1),
                
               
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                CheckboxColumn::make('status'),
                TextColumn::make('created_at')->date('d M y')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDeliveryCharges::route('/'),
            'create' => Pages\CreateDeliveryCharge::route('/create'),
            'view' => Pages\ViewDeliveryCharge::route('/{record}'),
            'edit' => Pages\EditDeliveryCharge::route('/{record}/edit'),
        ];
    }
}

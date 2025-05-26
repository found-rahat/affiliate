<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use App\Models\CollectionUserInfo;
use Illuminate\Support\Facades\DB;
use App\Models\CollectProductStock;

use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollectionUserInfoResource\Pages;
use App\Filament\Resources\CollectionUserInfoResource\RelationManagers;
use App\Filament\Resources\CollectionUserInfoResource\Pages\ViewCollectedProducts;

class CollectionUserInfoResource extends Resource
{
    protected static ?string $model = CollectionUserInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-bangladeshi';
    protected static ?string $navigationGroup = 'Product Management';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('collection_number')
                    ->default(Carbon::now()->format('dmY'))
                    ->readOnly()
                    ->formatStateUsing(function ($record) {
                        
                        if ($record) {
                            // Use the current record's collection_number
                            return $record->collection_number;
                        }
                        
                        // Generate a default collection number if no record exists
                        $userId = Auth::id();
                        $collectionNumber = Carbon::now()->format('dmY');

                        // Check if this collection number already exists for the user
                        $existing = CollectionUserInfo::where('collection_user', $userId)
                            ->where('collection_number', $collectionNumber)
                            ->exists();

                        // Add a suffix if a conflict is found
                        if ($existing) {
                                session()->flash('notification', [
                                    'message' => 'This collection number already exists.',
                                    'status' => 'danger',
                                ]);
                            Notification::make()
                                ->title('This collection number already exists.')
                                ->danger()
                                ->send();

                                return redirect(CollectionUserInfoResource::getUrl('index'));
                                exit;
                            }
                        return $collectionNumber;
                            
                        
                    }),
                TextInput::make('collection_user')
                    ->default(fn() => Auth::user()->id)
                    ->label('Collection Name')
                    ->required()
                    ->readOnly(),
                TextInput::make('total_value')->default(0)->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('SL.')
                    ->rowIndex()
                    ->searchable()->sortable()->toggleable(),
                TextColumn::make('collection_number')->searchable()->sortable()->toggleable(),
                TextColumn::make('user.name')->label('Collection User')->searchable()->sortable()->toggleable(),
                TextColumn::make('quantity')
                    ->label('Quantity')->searchable()->sortable()->toggleable()
                    ->formatStateUsing(function ($record) {

                        $quantity = CollectProductStock::where('collection_number', $record->collection_number)->where('collection_user',$record->collection_user)
                            ->selectRaw('SUM(quantity) as total_quantity')
                            ->value('total_quantity') ?? 0;

                        return $quantity;
                    }),

                TextColumn::make('total_value')
                    ->label('Total')->searchable()->sortable()->toggleable()
                    ->formatStateUsing(function ($record) {
                        $price = CollectProductStock::where('collection_number', $record->collection_number)->where('collection_user',$record->collection_user)
                            ->selectRaw('SUM(quantity * paid_price) as total_value')
                            ->value('total_value');
                        return number_format($price, 2);
                    }),
                    
                TextColumn::make('created_at')->dateTime('d M y'),
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
            'index' => Pages\ListCollectionUserInfos::route('/'),
            'create' => Pages\CreateCollectionUserInfo::route('/create'),
            'view' => Pages\ViewCollectionUserInfo::route('/{record}'),
            'edit' => Pages\EditCollectionUserInfo::route('/{record}/edit'),
            'view-collected-products' => ViewCollectedProducts::route('/{recordId}/view-collected-products'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use DateTime;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Reportus;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use function Laravel\Prompts\text;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;

use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ReportusResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReportusResource\RelationManagers;

class ReportusResource extends Resource
{
    protected static ?string $model = Reportus::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';
    protected static ?string $navigationGroup = 'User Panal';
    protected static ?int $navigationSort = 10;
    protected static ?string $modelLabel = 'User Reports';

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::where('status', 'Pending')->count();
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Section::make('User Form')->schema([
                    TextInput::make('type')->readOnly(),
                    TextInput::make('subject')->readOnly(),
                    RichEditor::make('description')->disabled(),
                ])->columnSpan(3)->collapsible(),
                Section::make('Admin Form')->schema([
                    Section::make('Image Record')->schema([
                        FileUpload::make('attachment')->multiple(),
                    ])->collapsible(),
                    Hidden::make('admin_user')
                        ->default(fn () => Auth::user()?->name) // Set default to logged-in admin name
                        ->dehydrated() // Ensures value is saved
                        ->visibleOn('edit') // Only show during edit, optional
                        ->afterStateHydrated(function (Hidden $component, $state) {
                            // When editing, update the field to currently logged-in admin
                            $component->state(Auth::user()?->name);
                        }),
                    RichEditor::make('admin_note'),
                    
                    Select::make('status')->options([
                        'Pending' => 'Pending',
                        'InReview' => 'InReview',
                        'Resolved' => 'Resolved',
                        'Rejected' => 'Rejected',
                    ]),
                ])->columnSpan(3),
                
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Sl')
                    ->state(fn ($record) => '#' . $record->id)
                    ->searchable()->sortable()->toggleable(true),
                TextColumn::make('user_name')->label('Create User')->searchable()->sortable()->toggleable(),
                TextColumn::make('type')->searchable()->sortable()->toggleable(),
                TextColumn::make('subject')->searchable()->sortable()->toggleable(),
                TextColumn::make('description')->searchable()->sortable()->toggleable(),
                ImageColumn::make('attachment')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->icon(fn (string $state) => match ($state) {
                        'Pending' => 'heroicon-o-clock',
                        'InReview' => 'heroicon-o-pencil',
                        'Resolved' => 'heroicon-o-check-badge',
                        'Rejected' => 'heroicon-o-shield-exclamation',
                        default => null,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'Pending' => 'warning',
                        'InReview' => 'secondary',
                        'Resolved' => 'success',
                        'Rejected' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('admin_user')->label('Solve Admin')->searchable()->sortable()->toggleable(),
                TextColumn::make('created_at')->dateTime('d M y')->searchable()->sortable()->toggleable(),
            ])
            ->filters([
                Filter::make('Pending')
                    ->label('Pending')
                    ->default('Pending')
                    ->query(fn ($query) => $query->where('status', 'Pending')),

                Filter::make('InReview')
                    ->label('InReview')
                    ->query(fn ($query) => $query->orwhere('status', 'InReview')),
                
                Filter::make('Resolved')
                    ->label('Resolved')
                    ->query(fn ($query) => $query->orwhere('status', 'Resolved')),

                Filter::make('Rejected')
                    ->label('Rejected')
                    ->query(fn ($query) => $query->orwhere('status', 'Rejected')),
                ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListReportuses::route('/'),
            'create' => Pages\CreateReportus::route('/create'),
            'view' => Pages\ViewReportus::route('/{record}'),
            'edit' => Pages\EditReportus::route('/{record}/edit'),
        ];
    }
}

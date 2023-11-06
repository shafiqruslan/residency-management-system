<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Widgets;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('email')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('password')
                                        ->password()
                                        ->maxLength(255)
                                        ->dehydrated(fn ($state) => filled($state))
                                        ->required(fn (string $context): bool => $context === 'create'),
                                ])->columns(2),
                            Forms\Components\Section::make('Profile')
                                ->relationship('userProfile')
                                ->schema([
                                    Forms\Components\FileUpload::make('image')
                                        ->required()
                                        ->directory('user-images')
                                        ->visibility('private')
                                        ->image()
                                        ->imageEditor()
                                        ->columnSpan('full'),
                                    Forms\Components\Radio::make('gender')->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])->required(),
                                    Forms\Components\Radio::make('status')->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])->required(),
                                    Forms\Components\TextInput::make('identification_number')
                                        ->required(),
                                    Forms\Components\DatePicker::make('date_of_birth')
                                        ->required(),
                                    Forms\Components\TextInput::make('contact_number')
                                        ->required(),
                                    Forms\Components\TextInput::make('street_address')
                                        ->required(),
                                ])->columns(2),
                        ])->columnSpan(['lg' => 2]),
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Placeholder::make('created_at')
                                        ->content(fn (User $record): string => $record->created_at->toFormattedDateString()),
                                    Forms\Components\Placeholder::make('updated_at')
                                        ->content(fn (User $record): string => $record->updated_at->diffForHumans(now()))
                                ])->hidden(fn (?User $record) => $record === null),
                            Forms\Components\Section::make('Roles')
                                ->schema([
                                    Forms\Components\Select::make('roles')
                                        // ->preload()
                                        // ->multiple()
                                        ->searchable()
                                        ->relationship('roles', 'name')
                                ]),
                            ])->columnSpan(['lg' => 1])
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('userProfile.image')
                    ->label('Image')
                    ->circular()
                    ->visibility('private'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            Tables\Columns\TextColumn::make('userProfile.identification_number')
                    ->label('Identification Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('userProfile.status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                ->trueLabel('Active users')
                ->falseLabel('Inactive users')
                ->queries(
                    true: fn (Builder $query) => $query->whereHas('userProfile', function (Builder $query) {
                        $query->where('status', 'active');
                    }),
                    false: fn (Builder $query) => $query->whereHas('userProfile', function (Builder $query) {
                        $query->where('status', 'inactive');
                    }),
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\UserOverview::class,
        ];
    }
}

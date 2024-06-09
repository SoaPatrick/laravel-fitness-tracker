<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages;
use App\Filament\Resources\ExerciseResource\RelationManagers;
use App\Models\Exercise;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Support\Enums\FontWeight;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Exercise Information')
                ->description('Enter the information for the exercise.')
                ->schema([
                    Forms\Components\TextInput::make('number')
                        ->label('ID')
                        ->required()
                        ->numeric()
                        ->columnSpan([
                                'md' => 1,
                            ]),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->columnSpan([
                                'md' => 5,
                            ]),
                    Forms\Components\TextInput::make('height')
                        ->numeric(),
                    Forms\Components\TextInput::make('url')
                        ->rules('url:https')
                        ->columnSpan([
                                'md' => 3,
                            ])
                        ->prefixAction(
                            Action::make('openUrl')
                                ->icon('heroicon-m-globe-alt')
                                ->url(fn (Exercise $exercise) => $exercise->url)
                                ->openUrlInNewTab()
                                ->hidden(fn (Exercise $exercise) => !$exercise->url),
                        ),
                    Forms\Components\ToggleButtons::make('uses_cable')
                        ->required()
                        ->grouped()
                        ->boolean()
                        ->default(false)
                        ->columnSpan([
                                'md' => 2,
                            ]),
                ])
                ->columns([
                                'md' => 6,
                            ]),
                Forms\Components\Section::make('Muscle Information')
                ->description('Chose which muscle groups this exercise targets.')
                ->schema([
                    Forms\Components\Select::make('muscles')
                        ->multiple()
                        ->relationship('muscles', 'name')
                        ->preload()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                Tables\Columns\TextColumn::make('muscles.name')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('height')
                    ->numeric()
                    ->sortable()
                    ->suffix('cm'),
                Tables\Columns\IconColumn::make('uses_cable')
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('number', 'asc')
            ->filters([
                //
            ])
            ->actions([
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
            RelationManagers\DiaryentriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExercises::route('/'),
            'create' => Pages\CreateExercise::route('/create'),
            'edit' => Pages\EditExercise::route('/{record}/edit'),
        ];
    }
}

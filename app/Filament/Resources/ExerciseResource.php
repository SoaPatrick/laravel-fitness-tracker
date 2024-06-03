<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages;
use App\Filament\Resources\ExerciseResource\RelationManagers;
use App\Models\Exercise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->columnSpan(5),
                    Forms\Components\TextInput::make('height')
                        ->numeric(),
                    Forms\Components\TextInput::make('url')
                        ->rules('url:https')
                        ->prefixIcon('heroicon-m-globe-alt')
                        ->columnSpan(3),
                    Forms\Components\ToggleButtons::make('uses_cable')
                        ->required()
                        ->grouped()
                        ->boolean()
                        ->default(false)
                        ->columnSpan(2),
                ])
                ->columns('6'),
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
                    ->sortable()
                    ->description(function(Exercise $record) {
                        return Str::of($record->url)->limit(40);
                    }),
                Tables\Columns\TextColumn::make('muscles.name')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('height')
                    ->numeric()
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListExercises::route('/'),
            'create' => Pages\CreateExercise::route('/create'),
            'edit' => Pages\EditExercise::route('/{record}/edit'),
        ];
    }
}

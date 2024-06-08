<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiaryEntryResource\Pages;
use App\Filament\Resources\DiaryEntryResource\RelationManagers;
use App\Models\DiaryEntry;
use App\Models\Exercise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;

class DiaryEntryResource extends Resource
{
    protected static ?string $model = DiaryEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now()->toDateString()),
                Forms\Components\Select::make('exercise_id')
                    ->relationship('exercise', 'title', modifyQueryUsing: fn (Builder $query) => $query->orderBy('number'),)
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->number}. {$record->title}")
                    ->required(),
                Forms\Components\ToggleButtons::make('weight')
                    ->grouped()
                    ->required()
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        'max' => 'Max',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('date')
                    ->date(),
                'exercise.title',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exercise.title')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->prefix(fn (DiaryEntry $record) => $record->exercise->number . '. ')
                    ->url(fn (DiaryEntry $record): string => ExerciseResource::getUrl('edit', ['record' => $record])),
                Tables\Columns\TextColumn::make('exercise.muscles.name')
                    ->badge()
                    ->numeric()
                    ->searchable(),
                Tables\Columns\TextColumn::make('exercise.height')
                    ->numeric()
                    ->suffix('cm'),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'desc')
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
            'index' => Pages\ListDiaryEntries::route('/'),
            'create' => Pages\CreateDiaryEntry::route('/create'),
            'edit' => Pages\EditDiaryEntry::route('/{record}/edit'),
        ];
    }
}

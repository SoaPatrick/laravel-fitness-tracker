<?php

namespace App\Filament\Resources\ExerciseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\DiaryEntryResource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiaryentriesRelationManager extends RelationManager
{
    protected static string $relationship = 'diaryentries';
    protected static ?string $title = 'Diary Entries';

    public function form(Form $form): Form
    {
        return DiaryEntryResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle("Diary Entry")
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('weight')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

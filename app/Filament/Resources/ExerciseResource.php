<?php

namespace App\Filament\Resources;

use App\Enums\Orientation;
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
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Exercise Details')
                        ->description('Enter the information for the exercise.')
                        ->schema([
                            Forms\Components\TextInput::make('number')
                                ->label('ID')
                                ->required()
                                ->columnSpanFull()
                                ->numeric(),
                            Forms\Components\TextInput::make('title')
                                ->columnSpanFull()
                                ->required(),
                            Forms\Components\TextInput::make('height')
                                ->columnSpanFull()
                                ->numeric(),
                            Forms\Components\ToggleButtons::make('uses_cable')
                                ->required()
                                ->grouped()
                                ->boolean()
                                ->default(false),
                            Forms\Components\ToggleButtons::make('orientation')
                                ->required()
                                ->grouped()
                                ->options(Orientation::class)
                                ->default('up'),
                            Forms\Components\Select::make('muscles')
                                ->multiple()
                                ->columnSpanFull()
                                ->relationship('muscles', 'name')
                                ->preload()
                                ->required(),
                        ])
                    ->grow(true),
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\FileUpload::make('preview_image')
                                ->directory('exercises-preview-images')
                                ->image()
                                ->openable()
                                ->panelAspectRatio('1')
                                ->panelLayout('integrated')
                                ->removeUploadedFileButtonPosition('right')
                                ->previewable(true)
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('url')
                                ->columnSpanFull()
                                ->rules('url:https')
                                ->columnSpanFull()
                                ->prefixAction(
                                    Action::make('openUrl')
                                        ->icon('heroicon-m-globe-alt')
                                        ->url(fn (Exercise $exercise) => $exercise->url)
                                        ->openUrlInNewTab()
                                        ->hidden(fn (Exercise $exercise) => !$exercise->url),
                                ),
                            Forms\Components\TextInput::make('video_url')
                                ->columnSpanFull()
                                ->rules('url:https')
                                ->columnSpanFull()
                                ->prefixAction(
                                    Action::make('openUrl')
                                        ->icon('heroicon-m-video-camera')
                                        ->url(fn (Exercise $exercise) => $exercise->video_url)
                                        ->openUrlInNewTab()
                                        ->hidden(fn (Exercise $exercise) => !$exercise->video_url),
                                ),
                        ])
                        ->columns([
                            'md' => 2,
                        ])
                    ->grow(true),
                ])
                ->from('xl')
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('preview_image'),
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
                Tables\Columns\IconColumn::make('orientation')
                    ->sortable(),
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
            ->defaultPaginationPageOption(25)
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
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

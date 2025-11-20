<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mydnic\VoletFeatureBoard\Models\Comment;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource\Pages;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('feature_id')
                    ->relationship('feature', 'title')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('feature.title')
                    ->label('Feature')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->limit(50)
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
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
//                    Action::make('Mark As Read')
//                        ->action(fn (FeedbackMessage $record) => $record->markAsRead())
//                        ->icon('heroicon-m-eye'),
//                    Action::make('Mark As Resolved')
//                        ->action(fn (FeedbackMessage $record) => $record->markAsResolved())
//                        ->icon('heroicon-m-check'),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}

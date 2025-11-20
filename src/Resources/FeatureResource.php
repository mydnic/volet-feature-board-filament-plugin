<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Mydnic\Volet\Features\FeatureManager;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource\Pages;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource\RelationManagers\CommentsRelationManager;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $modelLabel = 'Feature Requests';

    protected static string|null|\UnitEnum $navigationGroup = 'Volet';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category')
                    ->options(
                        collect(
                            app(FeatureManager::class)->getFeature('feedback-messages')
                                ->getCategories()
                        )
                            ->mapWithKeys(fn ($category) => [$category['slug'] => $category['name']])
                    )
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(FeatureStatus::class)
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('author_id')
                    ->label('Author')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        $userModel = config('auth.providers.users.model');

                        return $userModel::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $userModel = config('auth.providers.users.model');

                        return $userModel::find($value)?->name ?? $value;
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Author'),
                Tables\Columns\TextColumn::make('votes_count')
                    ->counts('votes')
                    ->label('Votes')
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
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}

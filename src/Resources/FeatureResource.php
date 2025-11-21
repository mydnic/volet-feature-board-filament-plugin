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

    public static function getNavigationBadge(): ?string
    {
        $count = (int) static::getModel()::where('status', FeatureStatus::PENDING)->count();
        return $count > 0 ? (string) $count : null;
    }

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
                            app(FeatureManager::class)->getFeature('volet-feature-board')
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
                    ->badge()
                    ->color(fn ($state) => match ($state instanceof FeatureStatus ? $state : (is_string($state) ? FeatureStatus::tryFrom($state) : null)) {
                        FeatureStatus::APPROVED => 'success',
                        FeatureStatus::PENDING => 'warning',
                        FeatureStatus::REJECTED => 'danger',
                        FeatureStatus::COMPLETED => 'gray',
                        default => 'gray',
                    }),
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
                Tables\Filters\SelectFilter::make('category')
                    ->options(
                        collect(
                            app(FeatureManager::class)->getFeature('volet-feature-board')
                                ->getCategories()
                        )
                            ->mapWithKeys(fn ($category) => [$category['slug'] => $category['name']])
                    ),
                Tables\Filters\SelectFilter::make('status')
                    ->options(FeatureStatus::class),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('Mark as Pending')
                        ->action(function (Feature $record) {
                            $record->update(['status' => FeatureStatus::PENDING]);
                        })
                        ->visible(fn (Feature $record) => $record->status !== FeatureStatus::PENDING),
                    Action::make('Mark as Approved')
                        ->action(function (Feature $record) {
                            $record->update(['status' => FeatureStatus::APPROVED]);
                        })
                        ->visible(fn (Feature $record) => $record->status !== FeatureStatus::APPROVED),
                    Action::make('Mark as Rejected')
                        ->action(function (Feature $record) {
                            $record->update(['status' => FeatureStatus::REJECTED]);
                        })
                        ->visible(fn (Feature $record) => $record->status !== FeatureStatus::REJECTED),
                    Action::make('Mark as Completed')
                        ->action(function (Feature $record) {
                            $record->update(['status' => FeatureStatus::COMPLETED]);
                        })
                        ->visible(fn (Feature $record) => $record->status !== FeatureStatus::COMPLETED),
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

<?php

use Filament\Facades\Filament;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource;
use Mydnic\VoletFeatureBoardFilamentPlugin\VoletFeatureBoardFilamentPlugin;

it('registers the plugin', function () {
    $panel = Filament::getPanel('default');

    $plugin = $panel->getPlugin('volet-feature-board');

    expect($plugin)->toBeInstanceOf(VoletFeatureBoardFilamentPlugin::class);
});

it('registers the resources', function () {
    $panel = Filament::getPanel('default');

    $resources = $panel->getResources();

    expect($resources)->toContain(FeatureResource::class);
    expect($resources)->toContain(CommentResource::class);
});

it('registers the relation manager', function () {
    $relations = FeatureResource::getRelations();

    expect($relations)->toContain(\Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource\RelationManagers\CommentsRelationManager::class);
});

it('hides comment resource from navigation', function () {
    expect(CommentResource::shouldRegisterNavigation())->toBeFalse();
});

<?php

use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource;
use Mydnic\VoletFeatureBoardFilamentPlugin\VoletFeatureBoardFilamentPlugin;
use Filament\Facades\Filament;

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

<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource;

class VoletFeatureBoardFilamentPlugin implements Plugin
{
    public function getId(): string
    {
        return 'volet-feature-board';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                FeatureResource::class,
                CommentResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

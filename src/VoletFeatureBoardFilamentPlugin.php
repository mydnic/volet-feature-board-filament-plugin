<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mydnic\VoletFeedbackMessagesFilamentPlugin\Resources\VoletFeedbackMessagesResource;

class VoletFeatureBoardFilamentPlugin implements Plugin
{
    public function getId(): string
    {
        return 'volet-feedback-messages';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                VoletFeedbackMessagesResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

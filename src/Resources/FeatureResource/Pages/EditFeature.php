<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\FeatureResource;

class EditFeature extends EditRecord
{
    protected static string $resource = FeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

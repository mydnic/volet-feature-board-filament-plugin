<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource;

class EditComment extends EditRecord
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

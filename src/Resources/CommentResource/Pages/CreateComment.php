<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mydnic\VoletFeatureBoardFilamentPlugin\Resources\CommentResource;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;
}

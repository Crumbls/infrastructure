<?php

namespace Crumbls\Infrastructure\Filament\Resources\Pages;

use Crumbls\Infrastructure\Filament\Resources\NodeResource;
use Filament\Resources\Pages\ListRecords;

class ListNodes extends ListRecords
{
    protected static string $resource = NodeResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }
}

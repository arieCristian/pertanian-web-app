<?php

namespace App\Filament\Resources\BibitResource\Pages;

use App\Filament\Resources\BibitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBibits extends ListRecords
{
    protected static string $resource = BibitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

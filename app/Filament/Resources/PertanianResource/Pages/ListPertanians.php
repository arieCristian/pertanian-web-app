<?php

namespace App\Filament\Resources\PertanianResource\Pages;

use App\Filament\Resources\PertanianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPertanians extends ListRecords
{
    protected static string $resource = PertanianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

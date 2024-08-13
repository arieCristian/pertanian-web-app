<?php

namespace App\Filament\Resources\SaprodiResource\Pages;

use App\Filament\Resources\SaprodiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaprodis extends ListRecords
{
    protected static string $resource = SaprodiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

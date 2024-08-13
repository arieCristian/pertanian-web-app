<?php

namespace App\Filament\Resources\KorlapResource\Pages;

use App\Filament\Resources\KorlapResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKorlaps extends ListRecords
{
    protected static string $resource = KorlapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\LahanResource\Pages;

use App\Filament\Resources\LahanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLahans extends ListRecords
{
    protected static string $resource = LahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

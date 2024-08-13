<?php

namespace App\Filament\Resources\KorlapResource\Pages;

use App\Filament\Resources\KorlapResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKorlap extends EditRecord
{
    protected static string $resource = KorlapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

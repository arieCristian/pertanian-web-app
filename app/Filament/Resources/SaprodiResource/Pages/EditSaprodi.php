<?php

namespace App\Filament\Resources\SaprodiResource\Pages;

use App\Filament\Resources\SaprodiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaprodi extends EditRecord
{
    protected static string $resource = SaprodiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

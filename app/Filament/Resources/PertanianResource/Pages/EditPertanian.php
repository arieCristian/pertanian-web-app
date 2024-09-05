<?php

namespace App\Filament\Resources\PertanianResource\Pages;

use App\Filament\Resources\PertanianResource;
use App\Models\Pertanian;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPertanian extends EditRecord
{
    protected static string $resource = PertanianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

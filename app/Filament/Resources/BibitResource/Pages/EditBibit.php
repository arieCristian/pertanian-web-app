<?php

namespace App\Filament\Resources\BibitResource\Pages;

use App\Filament\Resources\BibitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBibit extends EditRecord
{
    protected static string $resource = BibitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

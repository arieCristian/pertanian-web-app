<?php

namespace App\Filament\Resources\PertanianResource\Pages;

use App\Filament\Resources\PertanianResource;
use App\Models\JumTanaman;
use App\Models\Pertanian;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePertanian extends CreateRecord
{
    protected static string $resource = PertanianResource::class;
}

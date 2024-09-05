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

    protected function handleRecordCreation(array $data): Pertanian
    {
        $list_tanaman = $data['list_tanaman'];
        unset($data['list_tanaman']);
        $record = Pertanian::create($data);
        foreach ($list_tanaman as $tanaman) {
            $tanaman['pertanian_id'] = $record->id;
            JumTanaman::create($tanaman);
        }
        return $record;
    }
}

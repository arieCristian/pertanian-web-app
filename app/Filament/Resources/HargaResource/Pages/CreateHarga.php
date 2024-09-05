<?php

namespace App\Filament\Resources\HargaResource\Pages;

use App\Filament\Resources\HargaResource;
use App\Models\Harga;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHarga extends CreateRecord
{
    protected static string $resource = HargaResource::class;

    protected function handleRecordCreation(array $data): Harga
    {
        dd($data);
        $data['harga'] = $this->setAmountAttribute($data['harga']);
        return Harga::create($data);
    }

    public function setAmountAttribute($value)
    {
        return (int) preg_replace('/[^\d]/', '', $value);
    }
}

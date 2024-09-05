<?php

namespace App\Filament\Resources\HargaResource\Pages;

use App\Filament\Resources\HargaResource;
use App\Models\Harga;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditHarga extends EditRecord
{
    protected static string $resource = HargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Harga
    {
        $data['harga'] = $this->setAmountAttribute($data['harga']);
        $record->update($data);
        return $record;
    }

    public function setAmountAttribute($value)
    {
        return (int) preg_replace('/[^\d]/', '', $value);
    }
}

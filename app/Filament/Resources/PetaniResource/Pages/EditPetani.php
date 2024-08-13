<?php

namespace App\Filament\Resources\PetaniResource\Pages;

use App\Filament\Resources\PetaniResource;
use App\Models\Anggota;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPetani extends EditRecord
{
    protected static string $resource = PetaniResource::class;
    protected $anggota_id = '';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['anggota_id'])) {
            $this->anggota_id = $data['anggota_id'];
            $anggota = Anggota::find($data['anggota_id']);
            $data['nama'] = $anggota->nama;
            $data['phone'] = $anggota->phone;
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Menyimpan data ke tabel anggota
        if (isset($data['anggota_id'])) {
            $anggota = Anggota::find($data['anggota_id']);
            $anggota->nama = $data['nama'];
            $anggota->phone = $data['phone'];
            $anggota->save();
        }
        $data = [];

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

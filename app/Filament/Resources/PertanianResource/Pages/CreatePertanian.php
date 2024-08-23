<?php

namespace App\Filament\Resources\PertanianResource\Pages;

use App\Filament\Resources\PertanianResource;
use App\Models\Bibit;
use App\Models\JumTanaman;
use App\Models\Korlap;
use App\Models\Lahan;
use App\Models\Pertanian;
use App\Models\Petani;
use App\Models\Saprodi;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePertanian extends CreateRecord
{
    protected static string $resource = PertanianResource::class;

    protected function handleRecordCreation(array $data): Pertanian
    {
        $list_tanaman = $data['list_tanaman'];
        unset($data['list_tanaman']);
        if (! Lahan::where('anggota_id', $data['lahan_id'])->exists()) {
            $lahan = Lahan::create([
                'anggota_id' => $data['lahan_id']
            ]);
            $data['lahan_id'] = $lahan->id;
        } else {
            $data['lahan_id'] = Lahan::where('anggota_id', $data['lahan_id'])->pluck('id')->first();
        }


        if (! Petani::where('anggota_id', $data['petani_id'])->exists()) {
            $petani = Petani::create([
                'anggota_id' => $data['petani_id']
            ]);
            $data['petani_id'] = $petani->id;
        } else {
            $data['petani_id'] = Petani::where('anggota_id', $data['petani_id'])->pluck('id')->first();
        }


        if (! Bibit::where('anggota_id', $data['bibit_id'])->exists()) {
            $bibit = Bibit::create([
                'anggota_id' => $data['bibit_id']
            ]);
            $data['bibit_id'] = $bibit->id;
        } else {
            $data['bibit_id'] = Bibit::where('anggota_id', $data['bibit_id'])->pluck('id')->first();
        }


        if (! Saprodi::where('anggota_id', $data['saprodi_id'])->exists()) {
            $saprodi = Saprodi::create([
                'anggota_id' => $data['saprodi_id']
            ]);
            $data['saprodi_id'] = $saprodi->id;
        } else {
            $data['saprodi_id'] = Saprodi::where('anggota_id', $data['saprodi_id'])->pluck('id')->first();
        }

        if (! Korlap::where('anggota_id', $data['korlap_id'])->exists()) {
            $korlap = Korlap::create([
                'anggota_id' => $data['korlap_id']
            ]);
            $data['korlap_id'] = $korlap->id;
        } else {
            $data['korlap_id'] = Korlap::where('anggota_id', $data['korlap_id'])->pluck('id')->first();
        }

        $record = Pertanian::create($data);
        foreach ($list_tanaman as $tanaman) {
            $tanaman['pertanian_id'] = $record->id;
            JumTanaman::create($tanaman);
        }
        return $record;
    }
}

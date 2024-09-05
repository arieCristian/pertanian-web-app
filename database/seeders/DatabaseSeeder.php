<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Bibit;
use App\Models\Desa;
use App\Models\Harga;
use App\Models\Korlap;
use App\Models\Lahan;
use App\Models\Petani;
use App\Models\Saprodi;
use App\Models\Tanaman;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('asdasd'),
        ]);

        Anggota::create([
            'nama' => 'Arie Cristian',
            'saldo' => 1000000,
            'phone' => '08224892379',
        ]);
        Anggota::create([
            'nama' => 'Komang Adi',
            'saldo' => 2000000,
            'phone' => '08224892379',
        ]);
        Anggota::create([
            'nama' => 'Kadek Rama',
            'saldo' => 1500000,
            'phone' => '08224892379',
        ]);
        Anggota::create([
            'nama' => 'Gede Darma',
            'saldo' => 1500000,
            'phone' => '08224892379',
        ]);
        Anggota::create([
            'nama' => 'Gede Angga Santika',
            'saldo' => 1500000,
            'phone' => '08224892379',
        ]);

        Petani::create([
            'anggota_id' => 1,
        ]);
        Petani::create([
            'anggota_id' => 2,
        ]);
        Petani::create([
            'anggota_id' => 3,
        ]);

        Lahan::create([
            'anggota_id' => 1,
        ]);
        Lahan::create([
            'anggota_id' => 2,
        ]);
        Lahan::create([
            'anggota_id' => 3,
        ]);

        Saprodi::create([
            'anggota_id' => 1,
        ]);
        Saprodi::create([
            'anggota_id' => 2,
        ]);
        Saprodi::create([
            'anggota_id' => 3,
        ]);

        Bibit::create([
            'anggota_id' => 4,
        ]);

        // Korlap::create([
        //     'anggota_id' => 4,
        // ]);

        Korlap::create([
            'anggota_id' => 5,
        ]);

        Tanaman::create([
            'nama' => 'Alpukat',
        ]);
        Tanaman::create([
            'nama' => 'Nanas',
        ]);
        Tanaman::create([
            'nama' => 'Durian',
        ]);

        Desa::create([
            'nama' => 'Batur Selatan',
        ]);
        Desa::create([
            'nama' => 'Batur Utara',
        ]);
        Desa::create([
            'nama' => 'Abang Batu Dinding',
        ]);

        Harga::create([
            'tanaman_id' => 1,
            'grade' => 'B',
            'harga' => 50000,
        ]);
        Harga::create([
            'tanaman_id' => 1,
            'grade' => 'C',
            'harga' => 40000,
        ]);
        Harga::create([
            'tanaman_id' => 1,
            'grade' => 'A',
            'harga' => 5700,
        ]);
    }
}

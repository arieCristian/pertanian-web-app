<?php

use App\Models\Bibit;
use App\Models\Desa;
use App\Models\JumTanaman;
use App\Models\Korlap;
use App\Models\Lahan;
use App\Models\Petani;
use App\Models\Saprodi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pertanian', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Desa::class, 'desa_id');
            $table->foreignIdFor(Lahan::class, 'lahan_id');
            $table->foreignIdFor(Petani::class, 'petani_id');
            $table->foreignIdFor(Saprodi::class, 'saprodi_id');
            $table->foreignIdFor(Bibit::class, 'bibit_id');
            $table->foreignIdFor(Korlap::class, 'korlap_id');
            $table->string('lokasi');
            $table->integer('luas_area');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanian');
    }
};

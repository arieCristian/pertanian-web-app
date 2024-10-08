<?php

use App\Models\Harga;
use App\Models\Pertanian;
use App\Models\Tanaman;
use App\Models\Transaksi;
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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tanaman::class, 'tanaman_id');
            $table->foreignIdFor(Harga::class, 'harga_id');
            $table->foreignIdFor(Transaksi::class, 'transaksi_id');
            $table->integer('harga');
            $table->integer('qty');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};

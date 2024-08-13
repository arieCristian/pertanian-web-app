<?php

use App\Models\Pertanian;
use App\Models\Tanaman;
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
        Schema::create('jum_tanaman', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tanaman::class, 'tanaman_id');
            $table->foreignIdFor(Pertanian::class, 'pertanian_id');
            $table->bigInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jum_tanaman');
    }
};

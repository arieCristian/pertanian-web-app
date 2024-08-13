<?php

use App\Models\Anggota;
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
        Schema::create('saprodi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Anggota::class, 'anggota_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saprodi');
    }
};

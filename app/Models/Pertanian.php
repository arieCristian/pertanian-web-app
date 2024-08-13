<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertanian extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pertanian';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    public function lahan(): HasManyThrough
    {
        return $this->HasManyThrough(Anggota::class, Lahan::class, 'id', 'id', 'lahan_id', 'anggota_id');
    }
    public function petani(): HasManyThrough
    {
        return $this->HasManyThrough(Anggota::class, Petani::class, 'id', 'id', 'petani_id', 'anggota_id');
    }
    public function saprodi(): HasManyThrough
    {
        return $this->HasManyThrough(Anggota::class, Saprodi::class, 'id', 'id', 'saprodi_id', 'anggota_id');
    }
    public function bibit(): HasManyThrough
    {
        return $this->HasManyThrough(Anggota::class, Bibit::class, 'id', 'id', 'bibit_id', 'anggota_id');
    }
    public function korlap(): HasManyThrough
    {
        return $this->HasManyThrough(Anggota::class, Korlap::class, 'id', 'id', 'korlap_id', 'anggota_id');
    }

    public function jumTanaman(): HasMany
    {
        return $this->hasMany(JumTanaman::class);
    }
}

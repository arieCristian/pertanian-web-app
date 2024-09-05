<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Anggota extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anggota';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function lahan(): HasMany
    {
        return $this->hasMany(Lahan::class);
    }

    public function petani(): HasMany
    {
        return $this->hasMany(Petani::class);
    }
    public function saprodi(): HasMany
    {
        return $this->hasMany(Saprodi::class);
    }
    public function korlap(): HasMany
    {
        return $this->hasMany(Korlap::class);
    }
    public function bibit(): HasOne
    {
        return $this->hasOne(Bibit::class);
    }
}

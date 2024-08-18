<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Babyspa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'baby_spas';

    protected static function boot()
    {
        parent::boot();
        self::created(function ($model) {
        });
    }

    protected $fillable = [
        'manfaat',
        'jenis',
        'spa_type',
        'price',
        'image',
    ];



    public static function isAnak()
    {
        return self::where('jenis', 'Anak')->get();
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}

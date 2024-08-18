<?php

namespace App\Models;

use App\Events\Student\StudentCreated;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    // Gender
    const PRIA_GENDER = 'pria';
    const WANITA_GENDER = 'wanita';

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // $model->created_by = Auth::id();
        });
    }
    protected $fillable = [
        'users_id',
        'fullname',
        'address',
        'gender',
        'phone_number',
    ];

    public static function customerCount($gender)
    {
        return self::where('gender', $gender)->count();
    }

    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}

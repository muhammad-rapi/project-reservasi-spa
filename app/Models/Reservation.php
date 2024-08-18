<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $customer_id = Customer::where('users_id', Auth::user()->id)->first();
            if ($customer_id) {
                $model->customer_id = $customer_id->id;
            }
        });
    }

    protected $fillable = [
        'baby_name',
        'baby_weight',
        'baby_age',
        'customer_id',
        'baby_spa_id',
        'reservasi_date',
        'paid',
    ];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function baby_spa(): BelongsTo
    {
        return $this->belongsTo(Babyspa::class, 'baby_spa_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    // Payment Status
    const UNPAID = 'unpaid';
    const PAID = 'Lunas';
    const PENDING = 'Pending';

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->status = self::PENDING;
            $customer_id = Customer::where('users_id', Auth::user()->id)->first();
            $model->customer_id = $customer_id->id;
        });
    }

    protected $fillable = [
        'customer_id',
        'reservation_id',
        'name',
        'amount_of_payments',
        'date_of_payment',
        'rekening_number',
        'bukti_pembayaran',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}

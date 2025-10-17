<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'amount',
        'payment_type',
        'payment_note',
        'status',
        'extra_payment',
        'total',
        'start_date',
        'due_date',
        'paid_date',
        'credit_id',
        'processed_by',
    ];

    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}

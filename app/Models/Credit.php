<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $table = 'credits';

    protected $fillable = [
        'amount',
        'interest_rate',
        'term_months',
        'start_date',
        'end_date',
        'status',
        'paid_balance',
        'product_id',
        'client_id',
        'approved_by',
    ];

    public function product()
    {
        return $this->belongsTo(FinancialProduct::class, 'product_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'credit_id');
    }

    public function reports()
    {
        return $this->hasOne(Report::class, 'credit_id');
    }
}

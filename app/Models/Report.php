<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'report_date',
        'total_paid',
        'pending_balance',
        'months_paid',
        'months_pending',
        'interest_accrued',
        'credit_id',
        'client_id',
    ];

    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}

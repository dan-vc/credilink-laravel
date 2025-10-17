<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialProduct extends Model
{
    protected $table = 'financial_products';

    protected $fillable = [
        'name',
        'description',
        'interest_rate',
        'max_term_months',
        'min_amount',
        'max_amount',
        'status',
    ];

    public function credits()
    {
        return $this->hasMany(Credit::class, 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'type',
        'name',
        'phone',
        'email',
        'status',
        'created_by'
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function credits()
    {
        return $this->hasMany(Credit::class, 'client_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'client_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_id',
        'name',
        'amount',
        'installments',
        'guarantee',
        'start_date',
        'end_date',
        'description',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'guarantee' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

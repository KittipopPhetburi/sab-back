<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'date',
        'customer',
        'description',
        'amount',
        'status',
        'valid_until',
    ];

    protected $casts = [
        'date' => 'date',
        'valid_until' => 'date',
        'amount' => 'decimal:2',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_no',
        'date',
        'payer',
        'description',
        'amount',
        'status',
        'receive_method',
        'withholding_tax_no',
        'withholding_tax_amount',
        'receive_date',
    ];

    protected $casts = [
        'date' => 'date',
        'receive_date' => 'date',
        'amount' => 'decimal:2',
        'withholding_tax_amount' => 'decimal:2',
    ];
}

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
        'payer_id',
        'description',
        'amount',
        'status',
        'receive_method',
        'payment_method',
        'payment_date',
        'withholding_tax_no',
        'withholding_tax_amount',
        'receive_date',
        'tax_type',
        'salesperson',
        'items',
        'notes',
        'discount',
        'vat_rate',
        'subtotal',
        'discount_amount',
        'after_discount',
        'vat',
        'grand_total',
    ];

    protected $casts = [
        'date' => 'date',
        'receive_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'withholding_tax_amount' => 'decimal:2',
        'items' => 'array',
        'discount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'after_discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];
}

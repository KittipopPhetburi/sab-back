<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'payee',
        'description',
        'amount',
        'status',
        'payment_method',
        'withholding_tax_no',
        'withholding_tax_amount',
        'payment_date',
    ];
}

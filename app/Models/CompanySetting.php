<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'branch_name',
        'tax_id',
        'address',
        'phone',
        'email',
        'logo',
        'enable_email',
        'enable_sms',
        'auto_backup',
        'vat_rate',
    ];

    protected $casts = [
        'enable_email' => 'boolean',
        'enable_sms' => 'boolean',
        'auto_backup' => 'boolean',
        'vat_rate' => 'decimal:2',
    ];
}

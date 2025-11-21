<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithholdingTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_number',
        'doc_date',
        'sequence_number',
        'payer_tax_id',
        'payer_name',
        'payer_address',
        'recipient_tax_id',
        'recipient_name',
        'recipient_address',
        'recipient_type',
        'company_type',
        'representative_tax_id',
        'representative_name',
        'representative_address',
        'deduction_mode',
        'deduction_other',
        'deduction_format',
        'deduction_order',
        'total_amount',
        'total_tax',
        'status',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'doc_date' => 'date',
        'total_amount' => 'decimal:2',
        'total_tax' => 'decimal:2',
    ];

    // Relationship with items
    public function items()
    {
        return $this->hasMany(WithholdingTaxItem::class);
    }
}

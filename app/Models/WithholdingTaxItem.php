<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithholdingTaxItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'withholding_tax_id',
        'type',
        'description',
        'date',
        'tax_rate',
        'amount',
        'tax_amount',
    ];

    protected $casts = [
        'date' => 'date',
        'tax_rate' => 'decimal:2',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    // Relationship with parent
    public function withholdingTax()
    {
        return $this->belongsTo(WithholdingTax::class);
    }
}

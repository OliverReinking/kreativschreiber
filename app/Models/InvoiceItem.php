<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $casts = [
        'service_date' => 'date',
    ];

    public function getServiceDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format('Y-m-d');
    }

    // Ein Rechnungsposten (invoice_items) gehört zu genau einer Rechnung (invoices)
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id')->with('invoice_status', 'currency');
    }
}

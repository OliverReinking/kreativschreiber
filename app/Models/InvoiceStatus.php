<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    use HasFactory;

    const INVOICE_STATUS_CREATED = 1;
    const INVOICE_STATUS_IN_REMINDER = 2;
    const INVOICE_STATUS_PAID = 3;
    const INVOICE_STATUS_UNPAID_AGAIN = 4;
    const INVOICE_STATUS_CANCELLED = 5;

    protected $guarded = [];

    protected $primaryKey = 'id';
}

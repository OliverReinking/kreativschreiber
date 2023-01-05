<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceType extends Model
{
    use HasFactory;

    const INVOICE_TYPE_INVOICE = 1;
    const INVOICE_TYPE_REIMBURSEMENT = 2;
    const INVOICE_TYPE_CORRECTION_INVOICE = 3;

    protected $guarded = [];

    protected $primaryKey = 'id';
}

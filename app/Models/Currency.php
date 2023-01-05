<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    const CURRENCY_EURO = 1;

    protected $guarded = [];

    protected $primaryKey = 'id';
}

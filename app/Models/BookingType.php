<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    use HasFactory;

    const BOOKING_TYPE_TEXTERSTELLUNG = 1;
    const BOOKING_TYPE_PUNKTEAUFFÜLLUNG = 2;
    const BOOKING_TYPE_PUNKTEGUTSCHRIFT = 3;
    const BOOKING_TYPE_PUNKTESTORNO = 4;

    const CREDITPOINTS_FOR_REGISTRATION = 2000;

    protected $guarded = [];

    protected $primaryKey = 'id';
}

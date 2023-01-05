<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    use HasFactory;

    const CONTENT_TYPE_WERBETEXT = 1;
    const CONTENT_TYPE_BLOGTEXT = 2;

    protected $guarded = [];

    protected $primaryKey = 'id';
}

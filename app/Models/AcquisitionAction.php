<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcquisitionAction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $casts = [
        'action_date' => 'datetime',
    ];

    public function getActionDateAttribute($value)
    {
        if ($value == null) {
            return Carbon::now()->format('Y-m-d H:i');
            //return null;
        }
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    // Eine Akquisitionaktion (acquisition_actions) gehört zu genau einer Akquisition (acquisitions)
    public function acquisition()
    {
        return $this->belongsTo('App\Models\Acquisition', 'iacquisition_id', 'id');
    }
}

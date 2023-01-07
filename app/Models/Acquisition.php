<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acquisition extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $casts = [
        'last_action_date' => 'datetime',
    ];

    public function getLastActionDateAttribute($value)
    {
        if ($value == null) {
            return Carbon::now()->format('Y-m-d H:i');
            //return null;
        }
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    // Eine Akquisition (acquisitions) kann mehrere Akquisitionaktionen (acquisition_actions) besitzen
    public function acquisition_actions()
    {
        return $this->hasMany('App\Models\AcquisitionAction', 'acquisition_id', 'id');
    }

    public function scopeFilterAcquisition($query, array $filters)
    {
        if (isset($filters['search']) && trim($filters['search'] !== '')) {
            $search = $filters['search'];
            $query->where('acquisitions.email', 'like', '%' . $search . '%')
            ->orWhere('acquisitions.branch', 'like', '%' . $search . '%')
                ->orWhere('acquisitions.last_action_name', 'like', '%' . $search . '%');
        }
        //
        return $query;
    }
}

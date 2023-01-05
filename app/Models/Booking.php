<?php

namespace App\Models;

use App\Models\PersonCompany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    public function getBookingDateAttribute($value)
    {
        if ($value == null) {
            return Carbon::now()->format('Y-m-d H:i');
            //return null;
        }
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    // Eine Buchung (bookings) gehört zu genau einer Person / einem Unternehmen (person_companies)
    public function person_company()
    {
        return $this->belongsTo(
            'App\Models\PersonCompany',
            'person_company_id',
            'id'
        );
    }

    // Eine Buchung (bookings) gehört zu genau einem Buchungstyp (booking_types)
    public function booking_type()
    {
        return $this->belongsTo(
            'App\Models\BookingType',
            'booking_type_id',
            'id'
        );
    }

    // Eine Buchung (bookings) kann zu genau einem Text (contents) gehören
    public function content()
    {
        return $this->belongsTo('App\Models\Content', 'content_id', 'id');
    }

    // Eine Buchung (bookings) kann zu genau einer Rechnung (invoices) gehören
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');
    }

    public function scopeFilterCustomer($query, array $filters)
    {
        if (isset($filters['search']) && trim($filters['search'] !== '')) {
            $search = $filters['search'];
            $query
                ->where('booking_types.name', 'like', '%' . $search . '%')
                ->orWhere('bookings.points', 'like', '%' . $search . '%');
        }
        //
        return $query;
    }

    public static function createNewBooking(
        int $person_company_id,
        int $booking_type_id,
        int $points,
        int $content_id,
        int $invoice_id,
        $notes
    )
    {
        $booking_type = BookingType::Find($booking_type_id);
        //
        $sign = -1;
        if ($booking_type) {
            $sign = $booking_type->sign;
        }
        //
        Log::info('createNewBooking', [
            'sign' => $sign,
            'booking_type' => $booking_type,
        ]);
        //
        $output_points = $points * $sign;
        //
        $booking = Booking::create([
            'person_company_id' => $person_company_id,
            'booking_type_id' => $booking_type_id,
            'content_id' => $content_id,
            'invoice_id' => $invoice_id,
            'booking_date' =>  Carbon::now(),
            'points' => $output_points,
            'notes' => $notes,
        ]);
        //
        return $booking;
    }

    public static function checkPoints(
        int $points,
        int $person_company_id
    ) {
        $result = collect();
        //
        $result->errorOn = false;
        $result->errorMessage = null;
        //
        $person_company = PersonCompany::Find($person_company_id);
        //
        if (!$person_company) {
            $result->errorOn = true;
            $result->errorMessage = "Die vorgegebene Id für die Person bzw. das Unternehmen existiert nicht.";
        }
        //
        $ksPoints = Booking::where('person_company_id', '=', $person_company->id
        )->sum('points');
        //
        Log::info('checkPoints', [
            'ksPoints' => $ksPoints,
        ]);
        //
        if ($points > $ksPoints) {
            $result->errorOn = true;
            $result->errorMessage = "Der Text kann nicht erstellt werden, da dein Punktestand " . formatNumber($ksPoints) . " beträgt.<br />";
            $result->errorMessage .= "Du benötigst jedoch für die Erstellung des Textes " . formatNumber($points) . " KreativSchreiber-Punkte.";
        }
        //
        return $result;
    }
}

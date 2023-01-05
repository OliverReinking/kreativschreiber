<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function customer_crud_booking(User $user, Booking $booking)
    {
        //
        //Log::info('customer_crud_booking', [
        //    'user->is_customer' => $user->is_customer,
        //    'user->customer_id' => $user->customer_id,
        //    'booking->person_company_id' => $booking->person_company_id,
        //]);
        //
        return ($user->is_customer && $user->customer_id > 0 && $user->customer_id === $booking->person_company_id);
    }
}

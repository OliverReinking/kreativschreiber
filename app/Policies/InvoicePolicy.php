<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function customer_crud_invoice(User $user, Invoice $invoice)
    {
        //
        //Log::info('customer_crud_invoice', [
        //    'user->is_customer' => $user->is_customer,
        //    'user->customer_id' => $user->customer_id,
        //]);
        //
        return ($user->is_customer && $user->customer_id > 0 && $user->customer_id === $invoice->person_company_id);
    }
}

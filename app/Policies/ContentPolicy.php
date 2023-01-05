<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Content;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    public function customer_crud_content(User $user, Content $content)
    {
        //
        //Log::info('customer_crud_content', [
        //    'user->is_customer' => $user->is_customer,
        //    'user->customer_id' => $user->customer_id,
        //    'content->person_company_id' => $content->person_company_id,
        //]);
        //
        return ($user->is_customer && $user->customer_id > 0 && $user->customer_id === $content->person_company_id);
    }
}

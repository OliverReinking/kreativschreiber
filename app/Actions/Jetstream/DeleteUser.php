<?php

namespace App\Actions\Jetstream;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use App\Models\Content;
use App\Models\Country;
use App\Models\Salutation;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * The team deleter implementation.
     *
     * @var \Laravel\Jetstream\Contracts\DeletesTeams
     */
    protected $deletesTeams;

    /**
     * Create a new action instance.
     *
     * @param  \Laravel\Jetstream\Contracts\DeletesTeams  $deletesTeams
     * @return void
     */
    public function __construct(DeletesTeams $deletesTeams)
    {
        $this->deletesTeams = $deletesTeams;
    }

    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        DB::transaction(function () use ($user) {
            $delete_on = true;
            //
            if ($user->is_admin) {
                $delete_on = false;
            }
            //
            if ($delete_on && $user->is_customer) {
                // prüfe, ob User der letzte Anwender des Kunden ist
                $customer = $user->customer;
                //
                $count_user = User::where('customer_id', '=', $customer->customer_id)
                    ->count();
                //
                //Log::info('delete', [
                //    'count_user' => $count_user,
                //]);
                //
                if ($count_user == 1) {
                    // lösche alle Datensätze in contents
                    $contents = Content::where('person_company_id', '=', $customer->customer_id)->get();
                    foreach ($contents as $content) {
                        $content->delete();
                    }
                    // lösche alle Datensätze in chats
                    $chats = Chat::where('sender_person_company_id', '=', $customer->customer_id)
                        ->orWhere('receiver_person_company_id', '=', $customer->customer_id)
                        ->get();
                    foreach ($chats as $chat) {
                        $chat->delete();
                    }
                    //
                    $person_company = $customer->person_company;
                    // Passe Attribute in person_companies an
                    $person_company->name = null;
                    $person_company->street = null;
                    $person_company->country_id = Country::COUNTRY_GERMANY;
                    $person_company->postcode = null;
                    $person_company->city = null;
                    $person_company->contactperson_salutation_id = Salutation::SALUTATION_DIVERS;
                    $person_company->contactperson_first_name = null;
                    $person_company->contactperson_last_name = null;
                    $person_company->contactperson_phone = null;
                    $person_company->contactperson_email = null;
                    $person_company->billing_address = null;
                    $person_company->billing_address_line_2 = null;
                    $person_company->billing_street = null;
                    $person_company->billing_country_id = Country::COUNTRY_GERMANY;
                    $person_company->billing_postcode = null;
                    $person_company->billing_city = null;
                    //
                    $Zeitpunkt = Carbon::now();
                    $person_company->is_deleted = true;
                    $delete_history = 'Der Anwender ' . $user->last_name . ' (Anwender-Nr ' . $user->id . ') hat am ' . formatDateTimeLocale($Zeitpunkt) . ' diese Person bzw. dieses Unternehmen gelöscht.';
                    $person_company->delete_history = $delete_history;
                    $person_company->save();
                    // lösche den Datensatz in customers
                    $customer->delete();

                }
            }
            //
            if ($delete_on == true) {
                //$this->deleteTeams($user);
                $user->deleteProfilePhoto();
                $user->tokens->each->delete();
                $user->delete();
            }
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function deleteTeams($user)
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function ($team) {
            $this->deletesTeams->delete($team);
        });
    }
}

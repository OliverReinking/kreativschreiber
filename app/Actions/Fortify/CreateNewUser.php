<?php

namespace App\Actions\Fortify;

use App\Models\Chat;
use App\Models\Team;
use App\Models\User;
use App\Models\Booking;
use App\Models\Country;
use App\Models\ChatType;
use App\Models\Customer;
use App\Models\Salutation;
use App\Models\BookingType;
use App\Models\ChatUserType;
use App\Models\PersonCompany;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'company_name' => ['required', 'string', 'max:100'],
            'company_street' => ['required', 'string', 'max:100'],
            'company_postcode' => ['required', 'string', 'max:20'],
            'company_city' => ['required', 'string', 'max:100'],
        ], [
            'company_name.required' => 'Bitte gebe den Unternehmensnamen ein.',
            'company_name.max' => 'Bitte gebe für den Unternehmensnamen maximal 100 Zeichen ein.',
            'company_street.required' => 'Bitte gebe die Straße de Unternehmens ein.',
            'company_street.max' => 'Bitte gebe für die Straße des Unternehmens maximal 100 Zeichen ein.',
            'company_postcode.required' => 'Bitte gebe die Postleiztahl des Unternehmens ein.',
            'company_postcode.max' => 'Bitte gebe für die Postleitzahl des Unternehmens maximal 20 Zeichen ein.',
            'company_city.required' => 'Bitte gebe die Stadt des Unternehmens ein.',
            'company_city.max' => 'Bitte gebe für die Stadt des Unternehmens maximal 100 Zeichen ein.',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'is_customer' => true,
            ]), function (User $user) use ($input) {
                // create person_companies
                $person_company = PersonCompany::create([
                    'name' => $input['company_name'],
                    'street' => $input['company_street'],
                    'country_id' => Country::COUNTRY_GERMANY,
                    'postcode' => $input['company_postcode'],
                    'city' => $input['company_city'],
                    'contactperson_salutation_id' => Salutation::SALUTATION_DIVERS,
                    'contactperson_last_name' => $user->first_name,
                    'contactperson_first_name' => $user->last_name,
                    'contactperson_email' => $user->email,
                    'billing_address' => $input['company_name'],
                    'billing_street' => $input['company_street'],
                    'billing_country_id' => Country::COUNTRY_GERMANY,
                    'billing_postcode' => $input['company_postcode'],
                    'billing_city' => $input['company_city'],
                ]);
                // create customers
                Customer::create([
                    'customer_id' => $person_company->id,
                ]);
                // create Punktegutschrift
                Booking::createNewBooking(
                    $person_company->id,
                    BookingType::BOOKING_TYPE_PUNKTEGUTSCHRIFT,
                    BookingType::CREDITPOINTS_FOR_REGISTRATION,
                    0,
                    0,
                    "Für deine Registrierugn habe ich deinem Punktekonto " . formatNumber(BookingType::CREDITPOINTS_FOR_REGISTRATION, 0) . " KreativSchreiber-Punkte gutgeschrieben"
                );
                // update data in users
                $user->is_customer = true;
                $user->customer_id = $person_company->id;
                $user->save();
                // erstelle eine digitale Nachricht (Begrüßung des neuen Kunden)
                $chat_message = "<b>Willkommen bei KreativSchreiber!</b><br />";
                $chat_message .= "<br />";
                $chat_message .= "Vielen Dank, dass du dich für unsere Plattform entschieden hast. ";
                $chat_message .= "Als professioneller Softwareentwickler und Mathematiker setze ich mich dafür ein, Unternehmen dabei zu helfen, ";
                $chat_message .= "ihre Online-Präsenz zu stärken und ihre Marketingkampagnen zu verbessern.<br />";
                $chat_message .= "<br />";
                $chat_message .= "Du hast mit der Registrierung 2.000 KreativSchreiber-Punkte erhalten. Damit kannst du jetzt in aller Ruhe die Anwendung ausprobieren.<br />";
                $chat_message .= "Möchtest du später dein Punktekonto auffüllen, dann kann ich dir drei unterschiedliche Pakete anbieten.<br />";
                $chat_message .= "Auf der Startseite der Anwendung findest du alle notwendigen Informationen.<br />";
                $chat_message .= "<br />";
                $chat_message .= "Ich freue mich darauf, dich bei der Erreichung deiner Geschäftsziele zu unterstützen und bin immer auf der ";
                $chat_message .= "Suche nach neuen Herausforderungen. Herzliche Grüße, Oliver Reinking und das KreativSchreiber-Team<br />";
                //
                Chat::createChat(
                    ChatType::ChatType_normaleNachricht,
                    0,
                    config('kreativschreiber.platform.admin_person_company_id'),
                    ChatUserType::ChatUserType_Administrator,
                    0,
                    $person_company->id,
                    ChatUserType::ChatUserType_Customer,
                    $chat_message,
                    null,
                    null,
                    Chat::Chat_ohne_Mailbenachrichtung
                );
            });
        });
    }

    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->last_name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }
}

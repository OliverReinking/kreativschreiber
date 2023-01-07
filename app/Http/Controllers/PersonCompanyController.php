<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUpdatePersonCompany;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Chat;
use App\Models\ChatType;
use App\Models\ChatUserType;
use App\Models\Country;
use App\Models\PersonCompany;
use App\Models\Salutation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PersonCompanyController extends Controller
{
    // =================
    // APPLICATION ADMIN
    // =================
    public function admin_person_company_index()
    {
        $person_companies = PersonCompany::select(
            'person_companies.id as id',
            'person_companies.person_company_number as person_company_number',
            'person_companies.name as name',
            'person_companies.postcode as postcode',
            'person_companies.name as country_name',
            'person_companies.contactperson_first_name as contactperson_first_name',
            'person_companies.contactperson_last_name as contactperson_last_name',
            'person_companies.contactperson_email as contactperson_email',
        )
            ->leftJoin('countries', 'countries.id', '=', 'person_companies.country_id')
            ->orderBy('person_companies.name')
            ->filterPersonCompany(Request::only('search'))
            ->paginate(10)
            ->withQueryString();
        //
        return Inertia::render('Application/Admin/PersonCompanyList', [
            'filters' => Request::all('search'),
            'person_companies' => $person_companies,
        ]);
    }
    //
    public function admin_person_company_show(PersonCompany $person_company)
    {
        $person_company->country;
        $person_company->billingcountry;
        $person_company->salutation;
        $person_company->company;
        $person_company->admin;
        $person_company->customer;
        //
        return Inertia::render('Application/Admin/PersonCompanyShow', [
            'person_company' => $person_company,
        ]);
    }
    //
    public function admin_person_company_edit(PersonCompany $person_company)
    {
        $person_company->country;
        $person_company->billingcountry;
        $person_company->salutation;
        $person_company->company;
        $person_company->admin;
        $person_company->customer;
        //
        $countries = Country::select('id', 'name')
            ->orderBy('name')
            ->pluck('name', 'id');
        //
        $salutations = Salutation::select('id', 'name')
            ->orderBy('name')
            ->pluck('name', 'id');
        //
        return Inertia::render('Application/Admin/PersonCompanyForm', [
            'person_company' => $person_company,
            'countries' => $countries,
            'salutations' => $salutations,
        ]);
    }
    //
    public function admin_person_company_update(PersonCompany $person_company, RequestUpdatePersonCompany $request)
    {
        $person_company->update($request->validated());
        //
        return Redirect::route('admin.person_company.edit', $person_company->id)
            ->with(['success' => 'Die Daten der Person bzw. des Unternehmens wurden erfolgreich geändert.']);
    }
    //
    public function admin_person_company_credit_points(PersonCompany $person_company, $points)
    {
        //
        //Log::info('admin_person_company_credit_points', [
        //    'person_company->id' => $person_company->id,
        //    'points' => $points,
        //]);
        // validiere $points
        if ($points != 500 && $points != 1000 && $points != 2000) {
            $error = "Eine Punktegutschreibung funktioniert nur mit 500, 1.000 oder 2.000 Punkten.<br />";
            //
            return Redirect::route('admin.person_company.edit', $person_company->id)
                ->with([
                    'error' => $error,
                ]);
        }
        // erstelle jetzt noch den Datensatz in bookings
        Booking::createNewBooking(
            $person_company->id,
            BookingType::BOOKING_TYPE_PUNKTEGUTSCHRIFT,
            $points,
            0,
            0,
            "Ich habe deinem Punktekonto " . formatNumber($points, 0) . " KreativSchreiber-Punkte gutgeschrieben"
        );
        // erstelle eine digitale Nachricht
        $chat_message = "<b>Vielen Dank, dass du weiterhin die Anwendung KreativSchreiber verwendest.</b><br />";
        $chat_message .= "<br />";
        $chat_message .= "Ich habe deinem Punktekonto soeben " . formatNumber($points, 0) . " KreativSchreiber-Punkte gutgeschrieben.<br />";
        $chat_message .= "Ich hoffe, dass KreativSchreiber dir dabei helfen wird, deine Online-Präsenz zu stärken und deine Marketingkampagnen zu verbessern.<br />";
        $chat_message .= "Solltest du Fragen haben oder Unterstützung benötigen, zögere nicht, mich zu kontaktieren.<br />";
        $chat_message .= "<br />";
        $chat_message .= "Mit herzlichen Grüßen, Oliver Reinking und das KreativSchreiber-Team<br />";
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

        //
        return Redirect::route('admin.person_company.edit', $person_company->id)
            ->with(['success' => 'Die Punktegutschrift für die Person bzw. das Unternehmens wurde erfolgreich durchgeführt.']);
    }
    //
    public function admin_person_company_delete(PersonCompany $person_company)
    {
        $user = Auth::user();
        $Zeitpunkt = Carbon::now();
        //
        $admin = $person_company->admin;
        $company = $person_company->company;
        $customer = $person_company->customer;
        // --------------------------------------------
        // prüfe, ob Unternehmen bereits gelöscht wurde
        // --------------------------------------------
        if ($person_company->is_deleted) {
            //
            return Redirect::route('admin.person_company.index')
                ->with(['error' => 'Diese Person bzw. dieses Unternehmen wurde bereits gelöscht.']);
        }
        // -------------------------------
        // ist Unternehmen Administration?
        // -------------------------------
        if ($admin) {
            // lösche alle User mit users.admin_id = $admin.admin_id
            User::deleteUserAdmin($admin->admin_id);
            //
            $admin->delete();
        }
        // ----------------------
        // ist Unternehmen Kunde?
        // ----------------------
        if ($customer) {
            // lösche alle User mit users.customer_id = $customer.customer_id
            User::deleteUserCustomer($customer->customer_id);
            // lösche alle Datensätze des Kunden customer in contents
            $contents = Content::where('person_company_id', '=', $customer->customer_id)->get();
            foreach ($contents as $content) {
                $content->delete();
            }
            //
            $customer->delete();
        }
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
        $person_company->is_deleted = true;
        $delete_history = 'Der Anwender ' . $user->last_name . ' (Anwender-Nr ' . $user->id . ') hat am ' . formatDateTimeLocale($Zeitpunkt) . ' diese Person bzw. dieses Unternehmen gelöscht.';
        $person_company->delete_history = $delete_history;
        $person_company->save();
        //
        return Redirect::route('admin.person_company.index')
            ->with(['success' => 'Die Person bzw. das Unternehmen wurde erfolgreich gelöscht.']);
    }
    // ====================
    // APPLICATION CUSTOMER
    // ====================
    public function customer_person_company_show(PersonCompany $person_company)
    {
        $person_company->country;
        $person_company->billingcountry;
        $person_company->salutation;
        $person_company->admin;
        $person_company->company;
        $person_company->customer;
        //
        return Inertia::render('Application/Customer/PersonCompanyShow', [
            'person_company' => $person_company,
        ]);
    }
    //
    public function customer_person_company_edit(PersonCompany $person_company)
    {
        $user = Auth::user();
        //
        if (!$user->can('customer_crud_person_company', $person_company)) {
            $message = "Du besitzt leider nicht die notwendigen Kompetenzen, um diese Kundendaten zu ändern.";
            return Inertia::render('Application/Customer/NoPermission', [
                'message' => $message,
            ]);
        }
        //
        $person_company->country;
        $person_company->billingcountry;
        $person_company->salutation;
        $person_company->admin;
        $person_company->company;
        $person_company->customer;
        //
        $countries = Country::select('id', 'name')
            ->orderBy('name')
            ->pluck('name', 'id');
        //
        $salutations = Salutation::select('id', 'name')
            ->orderBy('name')
            ->pluck('name', 'id');
        //
        return Inertia::render('Application/Customer/PersonCompanyForm', [
            'person_company' => $person_company,
            'countries' => $countries,
            'salutations' => $salutations,
        ]);
    }
    //
    public function customer_person_company_update(PersonCompany $person_company, RequestUpdatePersonCompany $request)
    {
        $user = Auth::user();
        //
        if (!$user->can('customer_crud_person_company', $person_company)) {
            $message = "Du besitzt leider nicht die notwendigen Kompetenzen, um diese Kundendaten zu speichern.";
            return Inertia::render('Application/Customer/NoPermission', [
                'message' => $message,
            ]);
        }
        //
        $person_company->update($request->validated());
        //
        return Redirect::route('customer.person_company.edit', $person_company->id)
            ->with(['success' => 'Die Daten des Unternehmens wurden erfolgreich geändert.']);
    }
}

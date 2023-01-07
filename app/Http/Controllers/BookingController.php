<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Chat;
use App\Models\ChatType;
use App\Models\ChatUserType;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceStatus;
use App\Models\InvoiceType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    // ====================
    // APPLICATION CUSTOMER
    // ====================
    public function customer_booking_index()
    {
        $user = Auth::user();
        //
        $customer_id = $user->customer_id;
        //
        $bookings = Booking::select(
            'bookings.id as id',
            'booking_types.name as bookingtype_name',
            'bookings.booking_date as booking_date',
            'bookings.points as points',
        )
            ->leftJoin('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->orderBy('bookings.id', 'desc')
            ->filterCustomer(Request::only('search'))
            ->where('person_company_id', '=', $customer_id)
            ->paginate()
            ->withQueryString();
        //
        return Inertia::render('Application/Customer/BookingList', [
            'filters' => Request::all('search'),
            'bookings' => $bookings,
        ]);
    }
    //
    public function customer_booking_show(Booking $booking)
    {
        $user = Auth::user();
        //
        if (!$user->can('customer_crud_booking', $booking)) {
            $message = "Du besitzt leider nicht die notwendigen Kompetenzen, um diese KreativSchreiber-Transaktion anzuzeigen.";
            return Inertia::render('Application/Customer/NoPermission', [
                'message' => $message,
            ]);
        }
        //
        $booking->booking_type;
        $booking->content;
        $booking->invoice;
        //
        return Inertia::render('Application/Customer/BookingShow', [
            'booking' => $booking,
        ]);
    }
    //
    public function customer_booking_info()
    {
        //
        return Inertia::render('Application/Customer/BookingInfo');
    }
    //
    public function customer_booking_buying(int $points)
    {

        // validiere $points
        if ($points != 5000 && $points != 10000 && $points != 20000) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Es können nur 5.000, 10.000 oder 20.000 KreativSchreiber-Punkte erworben weden.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        // determine price
        $net_price = 30;
        $gross_price = 30;
        //
        if ($points == 5000) {
            $net_price = 30;
            $gross_price = 30;
        }
        if ($points == 10000) {
            $net_price = 57;
            $gross_price = 57;
        }
        if ($points == 20000) {
            $net_price = 108;
            $gross_price = 108;
        }
        //
        return Inertia::render('Application/Customer/BookingBuying', [
            'points' => $points,
            'net_price' => $net_price,
            'gross_price' => $gross_price,
        ]);
    }
    //
    public function customer_booking_purchase(int $points)
    {
        $user = Auth::user();
        //
        $customer = $user->customer;
        //
        $person_company = $customer->person_company;
        // validiere $points
        if ($points != 5000 && $points != 10000 && $points != 20000) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Es können nur 5.000, 10.000 oder 20.000 KreativSchreiber-Punkte erworben weden.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        // validiere die Attribute billing_* in person_companies
        if (!$person_company->billing_address) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Für die Erstellung der Rechnung benötigen wir eine Eingabe im Feld <b>Dein Name bzw. der Name des Unternehmens</b> in der Rubrik <b>Rechnungsanschrift</b>.<br />";
            $error .= "Klicke in der linken Navigationsspalte auf <b>Organisation</b> und dann auf den Menüpunkt <b>Kundendaten</b>.<br />";
            $error .= "Hier kannst du jetzt deine Rechnungsanschrift hinterlegen.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        //
        if (!$person_company->billing_street) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Für die Erstellung der Rechnung benötigen wir eine Eingabe im Feld <b>Straße</b> in der Rubrik <b>Rechnungsanschrift</b>.<br />";
            $error .= "Klicke in der linken Navigationsspalte auf <b>Organisation</b> und dann auf den Menüpunkt <b>Kundendaten</b>.<br />";
            $error .= "Hier kannst du jetzt deine Rechnungsanschrift hinterlegen.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        //
        if (!$person_company->billing_postcode) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Für die Erstellung der Rechnung benötigen wir eine Eingabe im Feld <b>Postleitzahl</b> in der Rubrik <b>Rechnungsanschrift</b>.<br />";
            $error .= "Klicke in der linken Navigationsspalte auf <b>Organisation</b> und dann auf den Menüpunkt <b>Kundendaten</b>.<br />";
            $error .= "Hier kannst du jetzt deine Rechnungsanschrift hinterlegen.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        //
        if (!$person_company->billing_city) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Für die Erstellung der Rechnung benötigen wir eine Eingabe im Feld <b>Stadt</b> in der Rubrik <b>Rechnungsanschrift</b>.<br />";
            $error .= "Klicke in der linken Navigationsspalte auf <b>Organisation</b> und dann auf den Menüpunkt <b>Kundendaten</b>.<br />";
            $error .= "Hier kannst du jetzt deine Rechnungsanschrift hinterlegen.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        // prüfe, ob für den Kunden unbezahlte Rechnungen vorliegen
        $unpaid_invoices = Invoice::
            join(
            'invoice_statuses',
            'invoice_statuses.id',
            '=',
            'invoices.invoice_status_id'
        )
            ->where('person_company_id', '=', $person_company->id)
            ->where('is_paid', '=', false)
            ->count();
        //
        if ($unpaid_invoices > 0) {
            $error = "Der Kauf der KreativSchreiber-Punkte hat leider nicht geklappt.<br />";
            $error .= "Es liegen noch unbezahlte Rechnungen vor.<br />";
            $error .= "Ein weiterer Kauf von KreativSchreiber-Punkten kann erst erfolgen, wenn diese Rechnungen bezahlt wurden.<br />";
            //
            return Redirect::route('customer.dashboard')
                ->with([
                    'error' => $error,
                ]);
        }
        // determine price
        $net_price = 30;
        $tax_rate = 0;
        $value_added_tax = 0;
        $gross_price = 30;
        //
        if ($points == 5000) {
            $net_price = 30;
            $tax_rate = 0;
            $value_added_tax = 0;
            $gross_price = 30;
        }
        if ($points == 10000) {
            $net_price = 57;
            $tax_rate = 0;
            $value_added_tax = 0;
            $gross_price = 57;
        }
        if ($points == 20000) {
            $net_price = 108;
            $tax_rate = 0;
            $value_added_tax = 0;
            $gross_price = 108;
        }
        // erstelle die rechnung
        $invoice = Invoice::create([
            'currency_id' => Currency::CURRENCY_EURO,
            'person_company_id' => $person_company->id,
            'invoice_status_id' => InvoiceStatus::INVOICE_STATUS_CREATED,
            'invoice_type_id' => InvoiceType::INVOICE_TYPE_INVOICE,
            'invoice_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14),
            'sum_net_price' => $net_price,
            'sum_value_added_tax' => $value_added_tax,
            'sum_gross_price' => $gross_price,
            'reminder_date' => null,
            'reminder_due_date' => null,
            //
            'person_company_number' => $person_company->person_company_number,
            'contactperson_salutation_id' => $person_company->contactperson_salutation_id,
            'contactperson_first_name' => $person_company->contactperson_first_name,
            'contactperson_last_name' => $person_company->contactperson_last_name,
            'billing_address' => $person_company->billing_address,
            'billing_address_line_2' => $person_company->billing_address_line_2,
            'billing_street' => $person_company->billing_street,
            'billing_country_id' => $person_company->billing_country_id,
            'billing_postcode' => $person_company->billing_postcode,
            'billing_city' => $person_company->billing_city,
            //
            'our_company_name' => config('kreativschreiber.rechnung.company_name'),
            'our_address' => config('kreativschreiber.rechnung.address'),
            'our_footer_line_1' => config('kreativschreiber.rechnung.footer_line_1'),
            'our_footer_line_2' => config('kreativschreiber.rechnung.footer_line_2'),
            'our_footer_line_3' => config('kreativschreiber.rechnung.footer_line_3'),
            'our_footer_line_4' => config('kreativschreiber.rechnung.footer_line_4'),
        ]);
        // erstelle einen Rechnungsposten für die Rechnung
        $invoice_item = InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'service_date' => Carbon::now(),
            'service_description' => 'KreativSchreiber-Punkte sind eine Währung, die verwendet wird, um Blog- und Werbetexte in der Anwendung <b>KreativSchreiber</b> zu bestellen. Jeder Punkt entspricht einem Wort.',
            'quantity' => $points,
            'quantity_text' => 'Punkte',
            'net_price' => $net_price,
            'tax_rate' => $tax_rate,
            'value_added_tax' => $value_added_tax,
            'gross_price' => $gross_price,
        ]);
        // erstelle jetzt noch den Datensatz in bookings
        Booking::createNewBooking(
            $person_company->id,
            BookingType::BOOKING_TYPE_PUNKTEGUTSCHRIFT,
            $points,
            0,
            $invoice->id,
            null
        );
        // erstelle eine digitale Nachricht
        $chat_message = "Die Rechnung (Rechnungs-Nr " . $invoice->invoice_number . ") wurde soeben erstellt. Bitte begleiche den offenen Rechnungsbetrag bis spätestens zum  " . formatDateLocale($invoice->due_date) . ".<br />";
        $chat_message .= "Deinem Punktekonto wurden soeben " . formatNumber($points, 0) . " KreativSchreiber-Punkte gutgeschrieben.<br />";
        //
        Chat::createChat(
            ChatType::ChatType_normaleNachricht,
            0,
            config('kreativschreiber.platform.admin_person_company_id'),
            ChatUserType::ChatUserType_Administrator,
            0,
            $invoice->person_company_id,
            ChatUserType::ChatUserType_Customer,
            $chat_message,
            null,
            null,
            Chat::Chat_ohne_Mailbenachrichtung
        );
        //
        $success = "Ich möchte mich herzlich für deinen Kauf bei mir bedanken.<br />";
        $success .= "Ich hoffe, dass du mit der Anwendung KreativSchreiber zufrieden bist. Danke schön!<br />";
        $success .= "Ich habe noch folgende Schritte durchgeführt:<br />";
        $success .= "- Rechnung erstellt. Diese findest du im Menüpunkt Organisation<br />";
        $success .= "- Nachricht erstellt. Diese findest du im Posteingang<br />";
        $success .= "- dein Punktekonto aufgefüllt<br />";
        //
        return Redirect::route('customer.dashboard')
            ->with([
                'success' => $success,
            ]);
    }
}

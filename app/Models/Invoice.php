<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\PersonCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    const INVOICE_ACTION_CREATED = "Rechnung erstellt";
    const INVOICE_ACTION_REMINDER = "Mahnung erstellt";
    const INVOICE_ACTION_PAID = "Rechnung wurde bezahlt";
    const INVOICE_ACTION_UNPAID_AGAIN = "Rechnung ist wieder unbezahlt";
    const INVOICE_ACTION_CANCELLED = "Rechnung wurde storniert";

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'reminder_date' => 'date',
        'reminder_due_date' => 'date',
        'original_invoice_date' => 'date',
    ];

    public function getInvoiceDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getDueDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getReminderDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getReminderDueDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getOriginalInvoiceDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format('Y-m-d');
    }

    // Ein Rechnung (invoices) gehört zu genau einer Währung (currencies)
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'id');
    }

    // Eine Rechnung (invoices) gehört zu genau einem Land (countries)
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    // Die Rechnungsadresse einer Rechnung (invoices) gehört zu genau einem Land (countries)
    public function billingcountry()
    {
        return $this->belongsTo('App\Models\Country', 'billing_country_id', 'id');
    }

    // Die Kontaktperson einer Rechnung (invoices) gehört zu genau einer Anrede (salutations)
    public function salutation()
    {
        return $this->belongsTo('App\Models\Salutation', 'contactperson_salutation_id', 'id');
    }
    // Eine Rechnung (invoices) gehört zu genau einer Person bzw.  Unternehmen (person_companies)
    public function person_company()
    {
        return $this->belongsTo('App\Models\PersonCompany', 'person_company_id', 'id')->with('salutation', 'country', 'billingcountry');
    }

    // Eine Rechnung (invoices) gehört zu genau einem Rechnungsstatus (invoice_statuses)
    public function invoice_status()
    {
        return $this->belongsTo('App\Models\InvoiceStatus', 'invoice_status_id', 'id');
    }

    // Eine Rechnung (invoices) gehört zu genau einem Rechnungstyp (invoice_typs)
    public function invoice_type()
    {
        return $this->belongsTo('App\Models\InvoiceType', 'invoice_type_id', 'id');
    }

    // Eine Rechnung (invoices) kann mehrere Rechnungsposten (invoice_items) besitzen
    public function invoice_items()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id', 'id')->with('invoice');
    }

    public function scopeFilterInvoiceAdmin($query, array $filters)
    {
        if (isset($filters['search']) && trim($filters['search'] !== '')) {
            $search = $filters['search'];
            $query->where('invoices.invoice_number', 'like', '%' . $search . '%')
                ->orWhere('person_companies.name', 'like', '%' . $search . '%')
                ->orWhere('person_companies.contactperson_email', 'like', '%' . $search . '%');
        }
        //
        return $query;
    }

    public function scopeFilterInvoiceCustomer($query, array $filters)
    {
        if (isset($filters['search']) && trim($filters['search'] !== '')) {
            $search = $filters['search'];
            $query->where('invoices.invoice_number', 'like', '%' . $search . '%');
        }
        //
        return $query;
    }

    // Ermittle Rechnung-Nr beim Einfügen eines neuen Datensatzes
    public static function booted()
    {
        static::created(function ($invoice) {
            $year = Carbon::now()->year;
            //
            $invoice->invoice_number = $year . '-KS-' . $invoice->person_company_id . '-' . $invoice->id;
            $invoice->save();
        });
    }

    public static function deleteInvoice(Invoice $invoice, User $user)
    {
        $return_values = collect();
        //
        $return_values->errorOn = false;
        $return_values->errorMessage = null;
        // prüfe, ob Rechnung gelöscht werden kann
        if ($invoice->invoice_status_id != InvoiceStatus::INVOICE_STATUS_CREATED) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Diese Rechnung hat nicht mehr den Status 'Rechnung erstellt', daher kann sie nicht mehr gelöscht werden.";
            return $return_values;
        }
        // lösche die Rechnungsitems
        $invoice_items = $invoice->invoice_items;
        //
        foreach ($invoice_items as $item) {
            // mache Punktegutschrift rückgängig
            Booking::createNewBooking(
                $invoice->person_company_id,
                BookingType::BOOKING_TYPE_PUNKTESTORNO,
                -$item->quantity,
                0,
                $invoice->id,
                null
            );
            // lösche Rechnungsposten
            $item->delete();
        }
        // lösche Rechnung
        $invoice->delete();
        //
        return $return_values;
    }

    public static function payInvoice(Invoice $invoice, User $user)
    {
        $return_values = collect();
        //
        $return_values->errorOn = false;
        $return_values->errorMessage = null;
        // prüfe, ob Rechnung auf bezahlt gesetzt werden kann
        if ($invoice->invoice_status_id == InvoiceStatus::INVOICE_STATUS_PAID) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Diese Rechnung wurde bereits bezahlt, daher kann sie nicht mehr auf bezahlt gesetzt werden.";
            return $return_values;
        }
        //
        if ($invoice->invoice_status_id == InvoiceStatus::INVOICE_STATUS_CANCELLED) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Für diese Rechnung wurde bereits eine Korrekturrechnung erstellt, daher kann sie nicht mehr auf bezahlt gesetzt werden.";
            return $return_values;
        }
        // verarbeite den Status
        $invoice->invoice_status_id = InvoiceStatus::INVOICE_STATUS_PAID;
        $invoice->save();
        // dokumentiere Bezahlung der Rechnung
        $message = Invoice::INVOICE_ACTION_PAID;
        Invoice::changeHistory($invoice, $user, $message, PersonCompany::PERSONCOMPANY_ADMINISTRATOR);
        //
        return $return_values;
    }

    public static function unpayInvoice(Invoice $invoice, User $user)
    {
        $return_values = collect();
        //
        $return_values->errorOn = false;
        $return_values->errorMessage = null;
        // prüfe, ob Rechnung wieder auf unbezahlt gesetzt werden kann
        if ($invoice->invoice_status->is_paid == false) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Diese Rechnung kann nicht auf wieder unbezahlt gesetzt werden, da sie nicht auf bezahlt steht.";
            return $return_values;
        }
        //
        if ($invoice->invoice_status_id == InvoiceStatus::INVOICE_STATUS_CANCELLED) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Für diese Rechnung wurde bereits eine Korrekturrechnung erstellt, daher kann sie nicht wieder auf unbezahlt gesetzt werden.";
            return $return_values;
        }
        // verarbeite den Status
        $invoice->invoice_status_id = InvoiceStatus::INVOICE_STATUS_UNPAID_AGAIN;
        $invoice->save();
        // dokumentiere Unbezahlt-Status der Rechnung
        $message = Invoice::INVOICE_ACTION_UNPAID_AGAIN;
        Invoice::changeHistory($invoice, $user, $message, PersonCompany::PERSONCOMPANY_ADMINISTRATOR);
        //
        return $return_values;
    }

    public static function remindInvoice(Invoice $invoice, User $user)
    {
        $return_values = collect();
        //
        $return_values->errorOn = false;
        $return_values->errorMessage = null;
        // prüfe, ob Rechnung gemahnt werden kann werden kann
        //
        if ($invoice->invoice_type_id != InvoiceType::INVOICE_TYPE_INVOICE) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Diese Rechnung kann nicht gemahnt werden, da es sich nicht um eine Rechnung handelt.";
            return $return_values;
        }
        //
        if ($invoice->invoice_status->is_paid == true) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Diese Rechnung kann nicht gemahnt werden, da die Rechnung auf bezahlt steht.";
            return $return_values;
        }
        //
        if ($invoice->due_date > Carbon::now()) {
            $return_values->errorOn = true;
            $return_values->errorMessage = "Diese Rechnung kann nicht gemahnt werden, da das Fälligkeitsdatum noch in der Zukunft liegt.";
            return $return_values;
        }
        // erstelle die Mahnung
        $invoice->reminder_date = Carbon::now();
        $invoice->reminder_due_date = Carbon::now()->addDays(7);
        $invoice->invoice_status_id = InvoiceStatus::INVOICE_STATUS_IN_REMINDER;
        $invoice->save();
        // dokumentiere Mahnung der Rechnung
        $message = Invoice::INVOICE_ACTION_REMINDER;
        Invoice::changeHistory($invoice, $user, $message, PersonCompany::PERSONCOMPANY_ADMINISTRATOR);
        // erstelle eine digitale Nachricht
        $chat_message = "Die Rechnung (Rechnungs-Nr " . $invoice->invoice_number . ") wurde soeben angemahnt. Bitte begleichen Sie den offenen Rechnungsbetrag bis spätestens zum  " . formatDateLocale($invoice->reminder_due_date) . ".<br />";
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
        return $return_values;
    }

    public static function changeHistory(
        Invoice $invoice,
        User $user,
        string $message,
        string $company_type
    ) {
        $Zeitpunkt = Carbon::now();
        //
        $userinfo = 'Der Kunde ' . $user->last_name . ' (Anwender-Nr ' . $user->id . ') hat am ' . formatDateTimeLocale($Zeitpunkt) . ' folgende Aktion durchgeführt.';
        if ($company_type == PersonCompany::PERSONCOMPANY_ADMINISTRATOR) {
            $userinfo = 'Der Administrator ' . $user->last_name . ' (Anwender-Nr ' . $user->id . ') hat am ' . formatDateTimeLocale($Zeitpunkt) . ' folgende Aktion durchgeführt.';
        }
        //
        $history = $invoice->history;
        //
        if ($history) {
            $history .= '<br />';
        }
        //
        $history .= $userinfo;
        //
        $history .= '<br />';
        $history .= $message;
        //
        $invoice->history = $history;
        $invoice->save();
    }

}

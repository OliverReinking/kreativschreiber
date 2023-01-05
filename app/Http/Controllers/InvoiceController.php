<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\InvoiceStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    // =================
    // APPLICATION ADMIN
    // =================
    public function admin_invoice_index($filter_value = 'all')
    {
        $invoices = Invoice::select(
            'invoices.id as id',
            'invoices.invoice_number as invoice_number',
            'invoices.invoice_date as invoice_date',
            'invoices.due_date as due_date',
            'invoices.reminder_due_date as reminder_due_date',
            'invoices.sum_gross_price as sum_gross_price',
            'invoice_statuses.id as invoice_status_id',
            'invoice_statuses.name as invoice_status_name',
            'invoice_types.name as invoice_type_name',
            'person_companies.name as company_name',
            'person_companies.contactperson_email as company_email'
        )
            ->join(
                'person_companies',
                'person_companies.id',
                '=',
                'invoices.person_company_id'
            )
            ->join(
                'invoice_statuses',
                'invoice_statuses.id',
                '=',
                'invoices.invoice_status_id'
            )
            ->join(
                'invoice_types',
                'invoice_types.id',
                '=',
                'invoices.invoice_type_id'
            )
            //
            ->where(function ($q) use ($filter_value) {
                if ($filter_value == 'unpaid') {
                    $q
                        ->where('invoice_statuses.is_paid', '=', false)
                        ->where(
                            'invoice_types.id',
                            '=',
                            InvoiceType::INVOICE_TYPE_INVOICE
                        )
                        ->whereDate('invoices.due_date', '<', Carbon::now());
                }
                if ($filter_value == 'reminding') {
                    $q
                        ->where(
                            'invoice_statuses.id',
                            '=',
                            InvoiceStatus::INVOICE_STATUS_IN_REMINDER
                        )
                        ->whereDate(
                            'invoices.reminder_due_date',
                            '<',
                            Carbon::now()
                        );
                }
                if ($filter_value == 'reminding_all') {
                    $q->where(
                        'invoice_statuses.id',
                        '=',
                        InvoiceStatus::INVOICE_STATUS_IN_REMINDER
                    );
                }
            })
            //
            ->filterInvoiceAdmin(Request::only('search'))
            ->orderBy('invoices.due_date', 'asc')
            ->paginate(10)
            ->withQueryString();
        //
        $filterInvoicesText = 'Es werden alle Rechnungen angezeigt';
        //
        if ($filter_value == 'unpaid') {
            $filterInvoicesText =
                'Es werden nur Rechnungen angezeigt, die unbezahlt sind und deren Fälligkeit in der Vergangenheit liegen.';
        }
        //
        if ($filter_value == 'reminding') {
            $filterInvoicesText =
                'Es werden nur Rechnungen angezeigt, die gemahnt werden und deren Fälligkeit in der Vergangenheit liegen.';
        }
        //
        if ($filter_value == 'reminding_all') {
            $filterInvoicesText =
                'Es werden nur Rechnungen angezeigt, die gemahnt werden.';
        }
        //
        return Inertia::render('Application/Admin/InvoiceList', [
            'filters' => Request::all('search'),
            'filterInvoicesText' => $filterInvoicesText,
            'invoices' => $invoices,
        ]);
    }
    //
    public function admin_invoice_edit(Invoice $invoice)
    {
        $invoice->currency;
        $invoice->invoice_status;
        $invoice->invoice_type;
        //
        $invoice_items = $invoice->invoice_items;
        //
        return Inertia::render('Application/Admin/InvoiceForm', [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
        ]);
    }
    //
    public function admin_invoice_display_pdf(Invoice $invoice)
    {
        $invoice->currency;
        $invoice->company;
        //
        $invoice_items = $invoice->invoice_items;
        //
        $pdf = PDF::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
        ]);
        //
        $filename = $invoice->invoice_number . '_invoice_kreativschreiber.pdf';
        //
        return $pdf->stream($filename);
    }
    //
    public function admin_reminder_invoice_display_pdf(Invoice $invoice)
    {
        //
        $invoice_items = $invoice->invoice_items;
        //
        $pdf = PDF::loadView('pdf.invoice_reminder', [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
        ]);
        //
        $filename =
            $invoice->invoice_number .
            '_reminder_invoice_kreativschreibero.pdf';
        //
        return $pdf->stream($filename);
    }
    //
    public function admin_invoice_action_deleting(Invoice $invoice)
    {
        $user = Auth::user();
        // lösche die Rechnung
        $values = Invoice::deleteInvoice($invoice, $user);
        //
        if ($values->errorOn) {
            $error = $values->errorMessage;
            return Redirect::route('admin.invoice.edit', $invoice->id)->with([
                'error' => $error,
            ]);
        }
        //
        $message = 'Die Rechnung wurde gelöscht.';
        return Redirect::route('admin.invoice.index')->with([
            'success' => $message,
        ]);
    }
    //
    public function admin_invoice_action_paying(Invoice $invoice)
    {
        $user = Auth::user();
        // setze die Rechnung auf bezahlt
        $values = Invoice::payInvoice($invoice, $user);
        //
        if ($values->errorOn) {
            $error = $values->errorMessage;
            return Redirect::route('admin.invoice.edit', $invoice->id)->with([
                'error' => $error,
            ]);
        }
        //
        $message = 'Die Rechnung wurde auf bezahlt gesetzt.';
        return Redirect::route('admin.invoice.edit', $invoice->id)->with([
            'success' => $message,
        ]);
    }
    //
    public function admin_invoice_action_unpaying(Invoice $invoice)
    {
        $user = Auth::user();
        // setze die Rechnung wieder auf unbezahlt
        $values = Invoice::unpayInvoice($invoice, $user);
        //
        if ($values->errorOn) {
            $error = $values->errorMessage;
            return Redirect::route('admin.invoice.edit', $invoice->id)->with([
                'error' => $error,
            ]);
        }
        //
        $message = 'Die Rechnung wurde auf wieder unbezahlt gesetzt.';
        return Redirect::route('admin.invoice.edit', $invoice->id)->with([
            'success' => $message,
        ]);
    }
    //
    public function admin_invoice_action_reminding(Invoice $invoice)
    {
        $user = Auth::user();
        // mahne die Rechnung
        $values = Invoice::remindInvoice($invoice, $user);
        //
        if ($values->errorOn) {
            $error = $values->errorMessage;
            return Redirect::route('admin.invoice.edit', $invoice->id)->with([
                'error' => $error,
            ]);
        }
        //
        $message = 'Für diese Rechnung wurde eine Mahnung erstellt.';
        return Redirect::route('admin.invoice.edit', $invoice->id)->with([
            'success' => $message,
        ]);
    }
    //
    public function admin_invoice_action_cancelling(Invoice $invoice)
    {
        $user = Auth::user();
        // erstelle für diese Rechnung eine Korrekturrechnung
        $values = Invoice::createCorrectionInvoice($invoice, $user);
        //
        if ($values->errorOn) {
            $error = $values->errorMessage;
            return Redirect::route('admin.invoice.edit', $invoice->id)->with([
                'error' => $error,
            ]);
        }
        //
        $message = 'Für diese Rechnung wurde eine Korrekturrechnung erstellt.';
        return Redirect::route('admin.invoice.edit', $invoice->id)->with([
            'success' => $message,
        ]);
    }
    //
    public function admin_invoice_action_add_note(
        Invoice $invoice,
        AdminInvoiceActionAddNotesRequest $request
    ) {
        $invoice->notes = $request->notes;
        $invoice->save();
        //
        $message = 'Für diese Rechnung wurde eine Notiz hinzugefügt.';
        return Redirect::route('admin.invoice.edit', $invoice->id)->with([
            'success' => $message,
        ]);
    }
    // ====================
    // APPLICATION CUSTOMER
    // ====================
    public function customer_invoice_index()
    {
        $user = Auth::user();
        //
        $customer_id = $user->customer_id;
        //
        $invoices = Invoice::select(
            'invoices.id as id',
            'invoices.invoice_number as invoice_number',
            'invoices.invoice_date as invoice_date',
            'invoices.due_date as due_date',
            'invoices.reminder_due_date as reminder_due_date',
            'invoices.sum_gross_price as sum_gross_price',
            'invoice_statuses.id as invoice_status_id',
            'invoice_statuses.name as invoice_status_name',
            'invoice_types.name as invoice_type_name',
            'person_companies.name as company_name',
            'person_companies.contactperson_email as company_email'
        )
            ->join(
                'person_companies',
                'person_companies.id',
                '=',
                'invoices.person_company_id'
            )
            ->join(
                'invoice_statuses',
                'invoice_statuses.id',
                '=',
                'invoices.invoice_status_id'
            )
            ->join(
                'invoice_types',
                'invoice_types.id',
                '=',
                'invoices.invoice_type_id'
            )
            ->where('invoices.person_company_id', '=', $customer_id)
            ->filterInvoiceCustomer(Request::only('search'))
            ->orderBy('invoices.invoice_number', 'desc')
            ->paginate(10)
            ->withQueryString();
        //
        return Inertia::render('Application/Customer/InvoiceList', [
            'filters' => Request::all('search'),
            'invoices' => $invoices,
        ]);
    }
    //
    public function customer_invoice_display_pdf(Invoice $invoice)
    {
        $user = Auth::user();
        //
        if (!$user->can('customer_crud_invoice', $invoice)) {
            $message =
                'Du besitzt leider nicht die notwendigen Kompetenzen, um eine Rechnung im PDF-Format anzuzeigen.';
            return Inertia::render('Application/Customer/NoPermission', [
                'message' => $message,
            ]);
        }
        //
        $invoice_items = $invoice->invoice_items;
        //
        $pdf = PDF::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
        ]);
        //
        $filename = $invoice->invoice_number . 'invoice_kreativschreiber.pdf';
        //
        return $pdf->stream($filename);
    }
    //
    public function customer_reminder_invoice_display_pdf(Invoice $invoice)
    {
        $user = Auth::user();
        //
        if (!$user->can('customer_crud_invoice', $invoice)) {
            $message =
                'Du besitzt leider nicht die notwendigen Kompetenzen, um eine Mahnung im PDF-Format anzuzeigen.';
            return Inertia::render('Application/Customer/NoPermission', [
                'message' => $message,
            ]);
        }
        //
        $invoice_items = $invoice->invoice_items;
        //
        $pdf = PDF::loadView('pdf.invoice_reminder', [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
        ]);
        //
        $filename =
            $invoice->invoice_number . 'reminder_invoice_kreativschreiber.pdf';
        //
        return $pdf->stream($filename);
    }
}

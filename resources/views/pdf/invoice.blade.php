@extends('pdf.layouts.pdfdokument')

@inject('country', 'App\Models\Country')
@inject('invoice_type', 'App\Models\InvoiceType')
@inject('carbon', 'Carbon\Carbon')

@section('content')
    <div>

        <table width="100%">
            <tr>
                <td style="vertical-align:top;" width="70%">
                    <div>
                        Firma
                        <br>
                        {{ $invoice->billing_address }}
                        <br>
                        {{ $invoice->billing_address_line_2 }}
                        <br>
                        {{ $invoice->salutation->name }} {{ $invoice->contactperson_first_name }}
                        {{ $invoice->contactperson_last_name }}
                        <br>
                        {{ $invoice->billing_street }}
                        <br>
                        {{ $invoice->billing_postcode }} {{ $invoice->billing_city }}
                        @if ($invoice->billing_country_id != $country::COUNTRY_GERMANY)
                            <br>
                            {{ $invoice->billingcountry->name }}
                        @endif
                    </div>
                </td>
                <td style="vertical-align:top;" width="30%">
                    <div class="image-center">
                        <img src="{{ public_path() . '/logo/Logo_KreativSchreiber.png' }}" width="40px" />
                    </div>
                    <div>{!! $invoice->our_address !!}</div>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 24px">
            <tr>
                <td>
                    <div style="margin-top: 12px; text-align: left;">
                        @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                            <h1>R E C H N U N G</h1>
                        @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_REIMBURSEMENT)
                            <h1>G U T S C H R I F T</h1>
                        @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
                            <h1>R E C H N U N G S K O R R E K T U R</h1>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 4px;">
            <tr>
                <td width="70%">
                    @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                        Rechnungsdatum
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_REIMBURSEMENT)
                        Datum der Gutschrift
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
                        Datum der Rechnungskorrektur
                    @endif
                </td>
                <td width="30%">
                    <b>{{ formatDateLocale($invoice->invoice_date) }}</b>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 4px;">
            <tr>
                <td width="70%">
                    Kunden-Nr
                </td>
                <td width="30%">
                    <b><b>{{ $invoice->person_company_number }}</b></b>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 4px;">
            <tr>
                <td width="70%">
                    @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                        Rechnungs-Nr
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_REIMBURSEMENT)
                        Gutschrift-Nr
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
                        Korrektur-Rechnungs-Nr
                    @endif
                </td>
                <td width="30%">
                    <b>{{ $invoice->invoice_number }}</b>
                </td>
            </tr>
        </table>

        @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
            <table width="100%" style="margin-top: 4px;">
                <tr>
                    <td width="70%">
                        Rechnungs-Nr der Ursprungsrechnung
                    </td>
                    <td width="30%">
                        <b>{{ $invoice->original_invoice_number }}</b>
                    </td>
                </tr>
            </table>
            <table width="100%" style="margin-top: 4px;">
                <tr>
                    <td width="70%">
                        Rechnungsdatum der Ursprungsrechnung
                    </td>
                    <td width="30%">
                        <b>{{ formatDateLocale($invoice->original_invoice_date) }}</b>
                    </td>
                </tr>
            </table>
        @endif

        <table width="100%" style="margin-top: 24px">
            <tr>
                <td>
                    Sehr geehrte Damen und Herren,
                    <br>
                    <br>
                    @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                        wir erlauben uns, Ihnen folgende Leistungen zu berechnen:
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_REIMBURSEMENT)
                        wir erlauben uns, Ihnen folgende Leistungen zu erstatten:
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
                        vereinbarungsgemäß erhalten Sie hiermit eine Gutschrift zu unserer Rechnung mit der Rechnungs-Nr
                        {{ $invoice->original_invoice_number }} vom
                        {{ formatDateLocale($invoice->original_invoice_date) }}
                    @endif
                    <br>
                    <br>
                </td>
            </tr>
        </table>


        <table width="100%" style="margin-top: 12px; font-size:10px">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <th style="vertical-align:top; text-align:left">Beschreibung</th>
                            <th style="vertical-align:top; text-align:left">Menge</th>
                            <th style="vertical-align:top; text-align:left">Leistungsdatum</th>
                            <th style="vertical-align:top; text-align:right">Nettopreis in {{ $invoice->currency->symbol }}</th>
                            <th style="vertical-align:top; text-align:right">Mwst.Satz in %</th>
                            <th style="vertical-align:top; text-align:right">MwSt. in {{ $invoice->currency->symbol }}</th>
                            <th style="vertical-align:top; text-align:right">Bruttopreis in {{ $invoice->currency->symbol }}</th>
                        </tr>
                        @foreach ($invoice_items as $item)
                            <tr>
                                <td style="vertical-align:top; text-align:left;">{!! $item->service_description !!}</td>
                                <td style="vertical-align:top; text-align:left;">
                                    {{ formatNumber($item->quantity, 0) }} {{ $item->quantity_text }}
                                </td>
                                <td style="vertical-align:top; text-align:left;">
                                    {{ formatDateLocale($item->service_date) }}
                                </td>
                                <td style="vertical-align:top; text-align:right;">{{ formatNumber($item->net_price, 2) }}
                                </td>
                                <td style="vertical-align:top; text-align:right;">{{ formatNumber($item->tax_rate, 2) }}
                                </td>
                                <td style="vertical-align:top; text-align:right;">
                                    {{ formatNumber($item->value_added_tax, 2) }}</td>
                                <td style="vertical-align:top; text-align:right;">{{ formatNumber($item->gross_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align:right; padding-top: 12px;">
                                @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                                    <b>Gesamtbetrag in Euro: </b>
                                @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_REIMBURSEMENT)
                                    <b>Gesamtgutschrift in Euro: </b>
                                @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
                                    <b>Stornorechnungsbetrag in Euro: </b>
                                @endif
                            </td>
                            <td style="padding-top: 12px; text-align:right;">
                                <b>{{ formatNumber($invoice->sum_net_price, 2) }}</b>
                            </td>
                            <td style="padding-top: 12px; text-align:right;">

                            </td>
                            <td style="padding-top: 12px; text-align:right;">
                                <b>{{ formatNumber($invoice->sum_value_added_tax, 2) }}</b>
                            </td>
                            <td style="padding-top: 12px; text-align:right;">
                                <b>{{ formatNumber($invoice->sum_gross_price, 2) }}</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 24px">
            <tr>
                <td>
                    @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)

                        Bitte überweisen Sie den Gesamtbetrag in Höhe von
                        <b>{{ formatNumber($invoice->sum_gross_price, 2) }} {{ $invoice->currency->symbol }}</b> bis
                        zum
                        {{ formatDateLocale($invoice->due_date) }}
                        unter Angabe der Rechnungs-Nr <b>{{ $invoice->invoice_number }}</b>
                        an die unten angegebene Bankverbindung.
                        <br>
                        <br>
                        Bei Rückfragen oder etwaigen Beanstandungen bezüglich der erworbenen Leistung können Sie sich
                        jederzeit gerne an uns wenden.
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_REIMBURSEMENT)
                        Die Gutschrift wird von uns schnellstmöglich an folgende Bankverbindung überwiesen:<br>
                        <br>
                        IBAN-Nr: {{ $invoice->bankconnection_iban }}<br>
                        Kontoinhaber: {{ $invoice->bankconnection_accountholder }}<br>
                        <br>
                        Bei Rückfragen oder etwaigen Beanstandungen bezüglich dieser Gutschrift können Sie sich jederzeit
                        gerne an uns wenden.
                    @elseif ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_CORRECTION_INVOICE)
                        Die Gutschrift wird von uns schnellstmöglich an folgende Bankverbindung überwiesen:<br>
                        <br>
                        IBAN-Nr: {{ $invoice->bankconnection_iban }}<br>
                        Kontoinhaber: {{ $invoice->bankconnection_accountholder }}<br>
                        <br>
                        Bei Rückfragen oder etwaigen Beanstandungen bezüglich dieser Gutschrift können Sie sich jederzeit
                        gerne an uns wenden.
                    @endif
                    <br>
                    <br>
                    Nach § 19 Abs. 1 UStG wird keine Umsatzsteuer berechnet.
                    <br>
                    <br>
                    <br>
                    Mit freundlichen Grüßen
                    <br>
                    <br>
                    {{ $invoice->our_company_name }}
                </td>
            </tr>
        </table>

    </div>
@endsection

@section('footer')
    <div class="footer--border">
        <div class="footer--info">
            {!! $invoice->our_footer_line_1 !!}
            <br>
            {!! $invoice->our_footer_line_2 !!}
            <br>
            {!! $invoice->our_footer_line_3 !!}
            <br>
            {!! $invoice->our_footer_line_4 !!}
            <br>
            Seite -<span class="pagenum"></span>-
        </div>
    </div>
@endsection

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
                        {{ $invoice->billing_address }}
                        @if ($invoice->billing_address_line_2)
                            <br>
                            {{ $invoice->billing_address_line_2 }}
                        @endif
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
                            <h1>M A H N U N G</h1>
                        @else
                            <h1>M A H N U N G (G U T S C H R I F T)</h1>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 4px;">
            <tr>
                <td width="70%">
                    @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                        Mahndatum
                    @else
                        Mahndatum der Gutschrift
                    @endif
                </td>
                <td width="30%">
                    <b>{{ formatDateLocale($invoice->reminder_date) }}</b>
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
                    @else
                        Gutschrift-Nr
                    @endif
                </td>
                <td width="30%">
                    <b>{{ $invoice->invoice_number }}</b>
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 24px">
            <tr>
                <td>
                    Sehr geehrte Damen und Herren,
                    <br>
                    <br>
                    @if ($invoice->invoice_type_id == $invoice_type::INVOICE_TYPE_INVOICE)
                        wir erlauben uns, Ihnen folgende Leistungen zu berechnen:
                    @else
                        wir erlauben uns, Ihnen folgende Leistungen zu erstatten:
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
                            <th style="vertical-align:top; text-align:right">Nettopreis in {{ $invoice->currency->symbol }}
                            </th>
                            <th style="vertical-align:top; text-align:right">Mwst.Satz in %</th>
                            <th style="vertical-align:top; text-align:right">MwSt. in {{ $invoice->currency->symbol }}</th>
                            <th style="vertical-align:top; text-align:right">Bruttopreis in
                                {{ $invoice->currency->symbol }}</th>
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
                                <b>Gesamtbetrag in Euro: </b>
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
                        {{ formatDateLocale($invoice->reminder_due_date) }}
                        unter Angabe der Rechnungs-Nr <b>{{ $invoice->invoice_number }}</b>
                        an die unten angegebene Bankverbindung.
                        <br>
                        <br>
                        Bei Rückfragen oder etwaigen Beanstandungen bezüglich der erworbenen Leistung können Sie sich
                        jederzeit gerne an uns wenden.
                    @else
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
                    <div>{!! $invoice->our_company_name !!}</div>
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

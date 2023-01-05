<template>
  <section-content :full-width="fullWidth">
    <template #title>Rechnungsdaten</template>
    <template #description
      >Hier werden alle Daten der Rechnung angezeigt</template
    >
    <template #content>
      <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
        <div>
          <display-title>Rechnungsnummer, Datum, Fälligkeit</display-title>
          <display-row label="Rechnungsnummer">
            <template #content>
              {{ invoice.invoice_number }}
            </template>
          </display-row>
          <display-row label="Rechnungsdatum">
            <template #content>
              <display-date :value="invoice.invoice_date" :time-on="false" />
            </template>
          </display-row>
          <display-row label="Fälligkeit">
            <template #content>
              <display-date :value="invoice.due_date" :time-on="false" />
            </template>
          </display-row>

          <template v-if="invoice.reminder_date">
            <display-title>Mahnung</display-title>
            <display-row label="Mahndatum">
              <template #content>
                <display-date :value="invoice.reminder_date" :time-on="false" />
              </template>
            </display-row>
            <display-row label="Fälligkeit">
              <template #content>
                <display-date
                  :value="invoice.reminder_due_date"
                  :time-on="false"
                />
              </template>
            </display-row>
          </template>

          <display-title>Status, Typ</display-title>
          <display-row label="Status">
            <template #content>
              <invoice-status-show
                :id="invoice.invoice_status.id"
                :name="invoice.invoice_status.name"
              ></invoice-status-show>
            </template>
          </display-row>
          <display-row label="Typ">
            <template #content>
              {{ invoice.invoice_type.name }}
            </template>
          </display-row>
        </div>

        <div>
          <display-title>Rechnungsbeträge</display-title>
          <display-row label="Währung">
            <template #content>
              {{ invoice.currency.name }}
            </template>
          </display-row>

          <display-row label="Nettobetrag">
            <template #content>
              <display-number
                :value="invoice.sum_net_price"
                :after-digits="2"
                :value-unit="invoice.currency.symbol"
              ></display-number>
            </template>
          </display-row>

          <display-row label="Mehrwertsteuer">
            <template #content>
              <display-number
                :value="invoice.sum_value_added_tax"
                :after-digits="2"
                :value-unit="invoice.currency.symbol"
              ></display-number>
            </template>
          </display-row>

          <display-row label="Bruttobetrag">
            <template #content>
              <display-number
                :value="invoice.sum_gross_price"
                :after-digits="2"
                :value-unit="invoice.currency.symbol"
              ></display-number>
            </template>
          </display-row>
        </div>

        <div class="col-span-12" v-if="routeInvoiceDisplayPdf">
          <display-title>Rechnung im PDF-Format</display-title>
          <display-row>
            <template #content>
              <input-icon-hyperlink
                :href="route(routeInvoiceDisplayPdf, invoice.id)"
                target="_blank"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                PDF-Rechnung anzeigen
              </input-icon-hyperlink>
            </template>
          </display-row>
        </div>

        <div class="col-span-12" v-if="invoice.correction_invoice_id">
          <display-title>Zugehörige Korrekturrechnung</display-title>
          <display-row>
            <template #content>
              <input-icon-hyperlink
                :href="route(routeInvoiceShow, invoice.correction_invoice_id)"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                zur Korrekturrechnung
              </input-icon-hyperlink>
            </template>
          </display-row>
        </div>

        <div class="col-span-12" v-if="invoice.original_invoice_id">
          <display-title>Zugehörige Ursprungsrechnung</display-title>
          <display-row>
            <template #content>
              <input-icon-hyperlink
                :href="route(routeInvoiceShow, invoice.original_invoice_id)"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                zur Ursprungsrechnung
              </input-icon-hyperlink>
            </template>
          </display-row>
        </div>

        <div
          class="col-span-12"
          v-if="routeReminderDisplayPdf && invoice.reminder_date"
        >
          <display-title>Mahnung im PDF-Format</display-title>
          <display-row>
            <template #content>
              <input-icon-hyperlink
                :href="route(routeReminderDisplayPdf, invoice.id)"
                target="_blank"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                PDF-Mahnung anzeigen
              </input-icon-hyperlink>
            </template>
          </display-row>
        </div>

        <div class="col-span-12">
          <display-title>Rechnungsnotiz</display-title>
          <display-row>
            <template #content>
              <div v-if="invoice.notes">
                <span v-html="invoice.notes"></span>
              </div>
              <div v-else>Für diese Rechnung wurde keine Rechnungsnotiz hinzugefügt.</div>
            </template>
          </display-row>
        </div>

        <div class="col-span-12">
          <display-title>Rechnungshistorie</display-title>
          <display-row>
            <template #content>
              <div v-if="invoice.history">
                <span v-html="invoice.history"></span>
              </div>
              <div v-else>Bisher ist noch nichts geschehen</div>
            </template>
          </display-row>
        </div>
      </div>
    </template>
  </section-content>

  <section-border></section-border>

  <invoice-item-list
    title="Liste der Rechnungsposten"
    description="Hier kannst du die Liste der Rechnungsposten für diese Rechnung einsehen."
    alert_message="Für diese Rechnung liegen keine Rechnungsposten vor."
    :invoice_items="invoice_items"
    :route-contract-show="routeContractShow"
  ></invoice-item-list>
</template>
<script>
import SectionContent from "@/Pages/Components/Content/SectionContent.vue";
import SectionBorder from "@/Pages/Components/Content/SectionBorder.vue";

import DisplayTitle from "@/Pages/Components/Content/DisplayTitle.vue";
import DisplayRow from "@/Pages/Components/Content/DisplayRow.vue";
import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

import InputIconHyperlink from "@/Pages/Components/Form/InputIconHyperlink.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";

import InvoiceItemList from "@/Pages/Application/Shared/InvoiceItemList.vue";
import InvoiceStatusShow from "@/Pages/Application/Shared/InvoiceStatusShow.vue";

export default {
  name: "Shared_InvoiceShow",

  components: {
    SectionContent,
    SectionBorder,
    DisplayTitle,
    DisplayRow,
    DisplayDate,
    DisplayNumber,
    InputIconHyperlink,
    IconEye,
    InvoiceItemList,
    InvoiceStatusShow,
  },

  props: {
    fullWidth: {
      type: Boolean,
      default: false,
    },
    invoice: {
      type: Object,
      default: () => ({}),
    },
    invoice_items: {
      type: Object,
      default: () => ({}),
    },
    routeInvoiceDisplayPdf: {
      type: String,
      default: null,
    },
    routeReminderDisplayPdf: {
      type: String,
      default: null,
    },
    routeInvoiceShow: {
      type: String,
      default: null,
    },
    routeContractShow: {
      type: String,
      default: null,
    },
  },
};
</script>

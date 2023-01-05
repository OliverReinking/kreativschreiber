<template>
  <section-content
    class="mt-6"
    :full-width="Object.keys(invoice_items).length ? true : false"
  >
    <template #title> {{ title }} </template>

    <template #description>
      {{ description }}
    </template>
    <template #content>
      <table class="np-dl-table" v-if="Object.keys(invoice_items).length > 0">
        <thead class="np-dl-thead">
          <tr>
            <th class="np-dl-th-normal">Leistungsdatum</th>
            <th class="np-dl-th-normal">Leistungsbeschreibung</th>
            <th class="np-dl-th-normal">Menge</th>
            <th class="np-dl-th-normal">Nettopreis</th>
            <th class="np-dl-th-normal">Mehrwertsteuer</th>
            <th class="np-dl-th-normal">Bruttopreis</th>
            <th class="np-dl-th-normal" v-if="routeInvoiceDisplayPdf">
              zur PDF-Rechnung
            </th>
            <th class="np-dl-th-normal" v-if="routeInvoiceShow">
              zur Rechnung
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in invoice_items" :key="item.id" class="np-dl-tr">
            <td class="np-dl-td-normal">
              <display-date
                :value="item.service_date"
                :time-on="false"
              ></display-date>
            </td>
            <td class="np-dl-td-normal">
                <span v-html="item.service_description"></span>
            </td>
            <td class="np-dl-td-normal">
              <display-number
                :value="item.quantity"
                :after-digits="0"
                :value-unit="item.quantity_text"
              ></display-number>
            </td>
            <td class="np-dl-td-normal">
              <display-number
                :value="item.net_price"
                :after-digits="2"
                :value-unit="item.invoice.currency.symbol"
              ></display-number>
            </td>
            <td class="np-dl-td-normal">
              <display-number
                :value="item.value_added_tax"
                :after-digits="2"
                :value-unit="item.invoice.currency.symbol"
              ></display-number>
            </td>
            <td class="np-dl-td-normal">
              <display-number
                :value="item.gross_price"
                :after-digits="2"
                :value-unit="item.invoice.currency.symbol"
              ></display-number>
            </td>
            <td class="np-dl-td-normal" v-if="routeInvoiceDisplayPdf">
              <input-icon-hyperlink
                :href="route(routeInvoiceDisplayPdf, item.invoice_id)"
                target="_blank"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                PDF-Rechnung anzeigen
              </input-icon-hyperlink>
            </td>
            <td class="np-dl-td-normal" v-if="routeInvoiceShow">
              <input-icon-hyperlink
                :href="route(routeInvoiceShow, item.invoice_id)"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                zur Rechnung
              </input-icon-hyperlink>
            </td>
          </tr>
        </tbody>
      </table>
      <alert type="info" v-if="Object.keys(invoice_items).length == 0">
        <div>
          {{ alert_message }}
        </div>
      </alert>
    </template>
  </section-content>
</template>
<script>
import SectionContent from "@/Pages/Components/Content/SectionContent.vue";

import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

import InputIconHyperlink from "@/Pages/Components/Form/InputIconHyperlink.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";

import Alert from "@/Pages/Components/Content/Alert.vue";

export default {
  name: "Shared_InvoiceItemList",

  components: {
    SectionContent,
    DisplayDate,
    DisplayNumber,
    InputIconHyperlink,
    IconEye,
    Alert,
  },

  props: {
    title: {
      type: String,
      default: null,
    },
    description: {
      type: String,
      default: null,
    },
    alert_message: {
      type: String,
      default: null,
    },
    fullWidth: {
      type: Boolean,
      default: false,
    },
    invoice_items: {
      type: Object,
      default: () => ({}),
    },
    routeInvoiceDisplayPdf: {
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

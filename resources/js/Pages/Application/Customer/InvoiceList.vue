<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Liste der Rechnungen"
        :breadcrumbs="{
          'Übersicht Organisation': route('customer.organization.dashboard'),
        }"
      ></breadcrumb>
    </template>
    <!-- Anzeige der Rechnungsliste -->
    <section class="mt-8">
      <list-container
        title="Liste der Rechnungen"
        :datarows="invoices"
        route-index="customer.invoice.index"
        :filters="filters"
        :search-filter="true"
        search-text="Gesucht werden alle Rechnungen, die den Suchbegriff in der Rechnungsnummer enthalten."
      >
        <template #header>
          <tr>
            <th class="np-dl-th-normal">R-Nr</th>
            <th class="np-dl-th-normal">Status</th>
            <th class="np-dl-th-normal">Typ</th>
            <th class="np-dl-th-normal">Fälligkeit</th>
            <th class="np-dl-th-normal">Brutto</th>
            <th class="np-dl-th-normal">zur PDF-Rechnung</th>
          </tr>
        </template>
        <template v-slot:datarow="data">
          <td class="np-dl-td-normal">
            {{ data.datarow.invoice_number }}
          </td>
          <td class="np-dl-td-normal">
            <invoice-status-show
              :id="data.datarow.invoice_status_id"
              :name="data.datarow.invoice_status_name"
            ></invoice-status-show>
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.invoice_type_name }}
          </td>
          <td class="np-dl-td-normal">
            <display-date
              :value="data.datarow.due_date"
              :time-on="false"
            ></display-date>
            <span v-if="data.datarow.reminder_due_date">
              ,
              <display-date
                :value="data.datarow.reminder_due_date"
                :time-on="false"
              ></display-date>
            </span>
          </td>
          <td class="np-dl-td-normal">
            <display-number
              :value="data.datarow.sum_gross_price"
              :after-digits="2"
              :value-unit="data.datarow.currency_name"
            ></display-number>
          </td>
          <td class="np-dl-td-normal">
            <div v-if="!data.datarow.reminder_due_date">
              <input-icon-hyperlink
                :href="route('customer.invoice.display.pdf', data.datarow.id)"
                target="_blank"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                Rechnung anzeigen
              </input-icon-hyperlink>
            </div>
            <div v-else>
              <input-icon-hyperlink
                :href="route('customer.reminder_invoice.display.pdf', data.datarow.id)"
                target="_blank"
              >
                <template #icon>
                  <icon-eye class="h-5 w-5 mr-2"></icon-eye>
                </template>
                Mahnung anzeigen
              </input-icon-hyperlink>
            </div>
          </td>
        </template>
      </list-container>
    </section>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import ListContainer from "@/Pages/Components/Lists/ListContainer.vue";

import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

import InputIconHyperlink from "@/Pages/Components/Form/InputIconHyperlink.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";

import InvoiceStatusShow from "@/Pages/Application/Shared/InvoiceStatusShow.vue";

export default defineComponent({
  name: "Customer_InvoiceList",

  components: {
    CustomerLayout,
    Breadcrumb,
    ListContainer,
    DisplayDate,
    DisplayNumber,
    InputIconHyperlink,
    IconEye,
    InvoiceStatusShow,
  },

  props: {
    invoices: {
      type: Object,
      default: () => ({}),
    },
    filters: {
      type: Object,
      default: () => ({}),
    },
  },
});
</script>

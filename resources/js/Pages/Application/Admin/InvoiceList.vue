<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Liste der Rechnungen"
      ></breadcrumb>
    </template>

    <!-- Loading -->
    <input-loading
      :loading="loading"
      :loading-text="loadingText"
    ></input-loading>
    <!-- ENDS Loading -->

    <!-- Message -->
    <action-message
      :show="filterInvoicesText"
      type="info"
      :message="filterInvoicesText"
    >
    </action-message>
    <!-- ENDS Message -->

    <!-- Anzeige der Rechnungsliste -->
    <section class="mt-8">
      <list-container
        title="Liste der Rechnungen"
        :datarows="invoices"
        route-index="admin.invoice.index"
        :filters="filters"
        :search-filter="true"
        search-text="Gesucht werden alle Rechnungen, die den Suchbegriff in der Rechnungsnummer oder im Namen bzw. der Mailadresse des Unternehmens enthalten."
        :edit-on="true"
        route-edit="admin.invoice.edit"
      >
        <template #button>
          <input-button type="button" @click.prevent="filterInvoices('all')"
            >alle Rechnungen</input-button
          >
          <input-button type="button" @click.prevent="filterInvoices('unpaid')"
            >unbezahlte Rechnungen mit abgelaufener Fälligkeit</input-button
          >
          <input-button type="button" @click.prevent="filterInvoices('reminding')"
            >Rechnungen in Mahnung mit abgelaufener Fälligkeit</input-button
          >
           <input-button type="button" @click.prevent="filterInvoices('reminding_all')"
            >Rechnungen in Mahnung</input-button
          >
        </template>
        <template #header>
          <tr>
            <th class="np-dl-th-normal">R-Nr</th>
            <th class="np-dl-th-normal">Unternehmen</th>
            <th class="np-dl-th-normal">Mail</th>
            <th class="np-dl-th-normal">Status</th>
            <th class="np-dl-th-normal">Typ</th>
            <th class="np-dl-th-normal">Fälligkeit</th>
            <th class="np-dl-th-normal">Brutto</th>
          </tr>
        </template>
        <template v-slot:datarow="data">
          <td class="np-dl-td-normal">
            {{ data.datarow.invoice_number }}
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.company_name }}
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.company_email }}
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
        </template>
      </list-container>
    </section>
  </admin-layout>
</template>
<script>
import { defineComponent } from "vue";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import ListContainer from "@/Pages/Components/Lists/ListContainer.vue";

import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

import InvoiceStatusShow from "@/Pages/Application/Shared/InvoiceStatusShow.vue";

import InputButton from "@/Pages/Components/Form/InputButton.vue";
import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ActionMessage from "@/Pages/Components/Content/ActionMessage.vue";

export default defineComponent({
  name: "Admin_InvoiceList",

  components: {
    AdminLayout,
    Breadcrumb,
    ListContainer,
    DisplayDate,
    DisplayNumber,
    InvoiceStatusShow,
    InputButton,
    InputLoading,
    ActionMessage,
  },

  props: {
    invoices: {
      type: Object,
      default: () => ({}),
    },
    filterInvoicesText: {
      type: String,
      default: () => ({}),
    },
    filters: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      loading: false,
      loadingText: null,
    };
  },

  methods: {
    filterInvoices(filter_value) {
      console.log("filterInvoices: ", filter_value);
      //
      this.loading = true;
      //
      this.loadingText = "Alle Rechnungen werden angezeigt!";
      //
      if (filter_value == "unpaid") {
        this.loadingText = "Es werden nur Rechnungen angezeigt, die unbezahlt sind und deren Fälligkeit in der Vergangenheit liegen!";
      }
      //
      if (filter_value == "reminding") {
        this.loadingText = "Es werden nur Rechnungen angezeigt, die gemahnt werden und deren Fälligkeit in der Vergangenheit liegen!";
      }
      //
      if (filter_value == "reminding_all") {
        this.loadingText = "Es werden nur Rechnungen angezeigt, die gemahnt werden!";
      }
      //
      this.$inertia.get(
        this.route("admin.invoice.index", { filter_value, page: 1 }),
        {
          onSuccess: () => {
            this.loading = false;
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },
  },
});
</script>

<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Anzeige einer KreativSchreiber-Transaktion"
        :breadcrumbs="{
          Organisation: route('customer.organization.dashboard'),
          Liste: route('customer.booking.index'),
        }"
      ></breadcrumb>
    </template>
    <!-- Anzeige Text -->
    <display-row label="Transaktion erstellt am">
      <template #content>
        <display-date :value="booking.booking_date" :time-on="true" />
      </template>
    </display-row>

    <display-row label="Typ">
      <template #content>
        {{ booking.booking_type.name }}
      </template>
    </display-row>

    <display-row label="KreativSchreiber-Punkte">
      <template #content>
        <display-number
          :value="booking.points"
          :after-digits="0"
          value-unit="Punkte"
        />
      </template>
    </display-row>

    <display-row label="Notiz zu dieser Buchung" v-if="booking.notes">
      <template #content>
        <span v-html="booking.notes"></span>
      </template>
    </display-row>

    <display-row label="zur Rechnung" v-if="booking.invoice_id > 0">
      <template #content>
        <input-icon-hyperlink
          :href="route('customer.invoice.display.pdf', booking.invoice_id)"
          target="_blank"
        >
          <template #icon>
            <icon-eye class="h-5 w-5 mr-2"></icon-eye>
          </template>
          Rechnung anzeigen
        </input-icon-hyperlink>
      </template>
    </display-row>

    <display-row label="zum Text" v-if="booking.content_id > 0">
      <template #content>
        <input-icon-hyperlink
          :href="route('customer.content.show', booking.content_id)"
        >
          <template #icon>
            <icon-eye class="h-5 w-5 mr-2"></icon-eye>
          </template>
          Text anzeigen
        </input-icon-hyperlink>
      </template>
    </display-row>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import DisplayRow from "@/Pages/Components/Content/DisplayRow.vue";
import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

import InputIconHyperlink from "@/Pages/Components/Form/InputIconHyperlink.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";

export default defineComponent({
  name: "Customer_BookingShow",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
    DisplayRow,
    DisplayDate,
    DisplayNumber,
    InputIconHyperlink,
    IconEye,
  },

  props: {
    booking: {
      type: Object,
      default: () => ({}),
    },
  },
});
</script>


<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Liste der KreativSchreiber-Transaktionen"
        :breadcrumbs="{
          Organisation: route('customer.organization.dashboard'),
        }"
      ></breadcrumb>
    </template>
    <!-- Anzeige der KreativSchreiber-Transaktionen-Liste -->
    <section class="mt-8">
      <list-container
        title="Liste der KreativSchreiber-Transaktionen"
        :datarows="bookings"
        route-index="customer.booking.index"
        :filters="filters"
        :search-filter="true"
        search-text="Gesucht werden alle KreativSchreiber-Transaktionen, die den Suchbegriff im Attribut Punkte bzw. im Attribut Typ enthalten."
        :show-on="true"
        route-show="customer.booking.show"
      >
        <template #header>
          <tr>
            <th class="np-dl-th-normal">Datum</th>
            <th class="np-dl-th-normal">Typ</th>
            <th class="np-dl-th-normal">Punkte</th>
          </tr>
        </template>
        <template v-slot:datarow="data">
          <td class="np-dl-td-normal">
            <display-date :value="data.datarow.booking_date" :time-on="true" />
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.bookingtype_name }}
          </td>
          <td class="np-dl-td-normal">
            <display-number :value="data.datarow.points" :after-digits="0" />
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

export default defineComponent({
  name: "Customer_BookingList",

  components: {
    CustomerLayout,
    Breadcrumb,
    ListContainer,
    DisplayDate,
    DisplayNumber,
  },

  props: {
    bookings: {
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

<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Liste der KreativSchreiber-Transaktionen"
      ></breadcrumb>
    </template>
    <!-- Anzeige der KreativSchreiber-Transaktionen-Liste -->
    <section class="mt-8">
      <list-container
        title="Liste der KreativSchreiber-Transaktionen"
        :datarows="bookings"
        route-index="admin.booking.index"
        :filters="filters"
        :search-filter="true"
        search-text="Gesucht werden alle KreativSchreiber-Transaktionen, die den Suchbegriff im Attribut Punkte bzw. im Attribut Typ enthalten."
        :show-on="true"
        route-show="admin.booking.show"
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
  </admin-layout>
</template>
<script>
import { defineComponent } from "vue";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import ListContainer from "@/Pages/Components/Lists/ListContainer.vue";

import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

export default defineComponent({
  name: "Admin_BookingList",

  components: {
    AdminLayout,
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

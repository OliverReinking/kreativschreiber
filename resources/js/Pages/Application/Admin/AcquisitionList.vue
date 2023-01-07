<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Liste der Akquisitionen"
        :breadcrumbs="{
          'Übersicht Akquisition': route('admin.acquisition.dashboard'),
        }"
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
      :show="filterAcquisitionsText"
      type="info"
      :message="filterAcquisitionsText"
    >
    </action-message>
    <!-- ENDS Message -->

    <!-- Anzeige der Akquisitionsliste -->
    <section class="mt-8">
      <list-container
        title="Liste der Akquisitionen"
        :datarows="acquisitions"
        route-index="admin.acquisition.index"
        :filters="filters"
        :search-filter="true"
        search-text="Gesucht werden alle Akquisitionen, die den Suchbegriff in der Mail, in der Branche oder im Aktionsnamen der letzten Aktion enthalten."
        :show-on="true"
        route-show="admin.acquisition.show"
        :edit-on="true"
        route-edit="admin.acquisition.edit"
        :create-on="true"
        route-create="admin.acquisition.create"
      >
        <template #button>
          <button-group>
            <input-button
              type="button"
              @click.prevent="filterAcquisitions('all')"
              >alle Akquisitionen</input-button
            >
            <input-button
              type="button"
              @click.prevent="filterAcquisitions('running')"
              >nur laufende Akquisitionen</input-button
            >
            <input-button
              type="button"
              @click.prevent="filterAcquisitions('completed')"
              >nur beendet Akquisitionen</input-button
            >
          </button-group>
        </template>

        <template #header>
          <tr>
            <th class="np-dl-th-normal">Mail</th>
            <th class="np-dl-th-normal">Branche</th>
            <th class="np-dl-th-normal">letzte Aktion am</th>
            <th class="np-dl-th-normal">letzte Aktion</th>
            <th class="np-dl-th-normal">läuft?</th>
            <th class="np-dl-th-normal">erfolgreich?</th>
          </tr>
        </template>
        <template v-slot:datarow="data">
          <td class="np-dl-td-normal">
            {{ data.datarow.email }}
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.branch }}
          </td>
          <td class="np-dl-td-normal">
            <display-date
              :value="data.datarow.last_action_date"
              :time-on="true"
            ></display-date>
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.last_action_name }}
          </td>
          <td class="np-dl-td-normal">
            <display-yes-or-no
              :value="data.datarow.running"
            ></display-yes-or-no>
          </td>
          <td class="np-dl-td-normal">
            <display-yes-or-no
              :value="data.datarow.successful"
            ></display-yes-or-no>
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
import DisplayYesOrNo from "@/Pages/Components/Content/DisplayYesOrNo.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ActionMessage from "@/Pages/Components/Content/ActionMessage.vue";

export default defineComponent({
  name: "Admin_AcquisitionList",

  components: {
    AdminLayout,
    Breadcrumb,
    ListContainer,
    DisplayDate,
    DisplayYesOrNo,
    ButtonGroup,
    InputButton,
    InputLoading,
    ActionMessage,
  },

  props: {
    acquisitions: {
      type: Object,
      default: () => ({}),
    },
    filterAcquisitionsText: {
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
    filterAcquisitions(filter_read) {
      console.log("filter_read");
      //
      this.loading = true;
      //
      this.loadingText = "Alle Akquisitionen werden angezeigt!";
      //
      if (filter_read == "running") {
        this.loadingText = "Nur laufenden Akquisitionen werden angezeigt!";
      }
      //
      if (filter_read == "completed") {
        this.loadingText = "Nur beendeten Akquisitionen werden angezeigt!";
      }
      //
      this.$inertia.get(
        this.route("admin.acquisition.index", { filter_read, page: 1 }),
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

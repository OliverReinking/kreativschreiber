<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Liste der erstellten Werbe- und Blogtexte"
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
      :show="filterContentsText"
      type="info"
      :message="filterContentsText"
    >
    </action-message>
    <!-- ENDS Message -->

    <!-- Anzeige der Contentliste -->
    <section class="mt-8">
      <list-container
        title="Liste der erstellten Werbe- und Blogtexte"
        :datarows="contents"
        route-index="customer.content.index"
        :filters="filters"
        :search-filter="true"
        search-text="Gesucht werden alle Texte, die den Suchbegriff in der Zusammenfassung enthalten."
        :show-on="true"
        route-show="customer.content.show"
      >
        <template #button>
          <button-group>
            <input-button type="button" @click.prevent="filterContents('all')"
              >alle Texte</input-button
            >
            <input-button
              type="button"
              @click.prevent="filterContents('advertising')"
              >nur Werbetexte</input-button
            >
            <input-button type="button" @click.prevent="filterContents('blog')"
              >nur Blogtexte</input-button
            >
          </button-group>
          <button-group>
            <input-button type="button">
              <Link
                :href="route('customer.content.advertising.create')"
                class="flex items-center"
              >
                <icon-add-circle class="h-4 w-4 mr-1" />Neuer Werbetext
              </Link></input-button
            >
            <input-button type="button">
              <Link
                :href="route('customer.content.blog.create')"
                class="flex items-center"
              >
                <icon-add-circle class="h-4 w-4 mr-1" />Neuer Blogtext
              </Link></input-button
            >
          </button-group>
        </template>

        <template #header>
          <tr>
            <th class="np-dl-th-normal">erstellt am</th>
            <th class="np-dl-th-normal">Typ</th>
            <th class="np-dl-th-normal">Zusammenfassung</th>
          </tr>
        </template>
        <template v-slot:datarow="data">
          <td class="np-dl-td-normal">
            <display-date
              :value="data.datarow.creation_date"
              :time-on="true"
            ></display-date>
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.content_type_name }}
          </td>
          <td class="np-dl-td-normal">
            {{ data.datarow.summary }}
          </td>
        </template>
      </list-container>
    </section>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import ListContainer from "@/Pages/Components/Lists/ListContainer.vue";
import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ActionMessage from "@/Pages/Components/Content/ActionMessage.vue";

import IconAddCircle from "@/Pages/Components/Icons/AddCircle.vue";

export default defineComponent({
  name: "Customer_TeamMemberList",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
    ListContainer,
    DisplayDate,
    ButtonGroup,
    InputButton,
    InputLoading,
    ActionMessage,
    IconAddCircle,
  },

  props: {
    contents: {
      type: Object,
      default: () => ({}),
    },
    filterContentsText: {
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
    filterContents(filter_read) {
      console.log("filter_read");
      //
      this.loading = true;
      //
      this.loadingText = "Alle Texte werden angezeigt!";
      //
      if (filter_read == "advertising") {
        this.loadingText = "Nur Werbetexte werden angezeigt!";
      }
      //
      if (filter_read == "blog") {
        this.loadingText = "Nur Blogtexte werden angezeigt!";
      }
      //
      this.$inertia.get(
        this.route("customer.content.index", { filter_read, page: 1 }),
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

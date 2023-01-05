<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Anzeige des Werbetextes"
        :breadcrumbs="{
          Liste: route('customer.content.index'),
        }"
      ></breadcrumb>
    </template>
    <!-- Anzeige Text -->
    <display-row label="Text erstellt am">
      <template #content>
        <display-date :value="content.creation_date" :time-on="true" />
      </template>
    </display-row>

    <display-row label="Eingaben">
      <template #content>
        <span v-html="content.prompt" class="text-lg"></span>
      </template>
    </display-row>

    <display-row label="Werbetext">
      <template #content>
        <copy-to-clipboard
          :copy-text="content.content"
          copy-description="Klicke hier und der Werbetext wird in die Zwischenablage kopiert"
        ></copy-to-clipboard>
      </template>
    </display-row>

    <button-group align="mt-4 justify-start">
      <input-button type="button">
        <Link
          :href="route('customer.content.advertising.create')"
          class="flex items-center"
        >
          <icon-add-circle class="h-4 w-4 mr-1" />Neuer Werbetext
        </Link></input-button
      >
    </button-group>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import DisplayRow from "@/Pages/Components/Content/DisplayRow.vue";
import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";

import CopyToClipboard from "@/Pages/Components/CopyToClipboard.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";

import IconAddCircle from "@/Pages/Components/Icons/AddCircle.vue";

export default defineComponent({
  name: "Customer_ContentAdvertisingShow",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
    DisplayRow,
    DisplayDate,
    CopyToClipboard,
    ButtonGroup,
    InputButton,
    IconAddCircle,
  },

  props: {
    content: {
      type: Object,
      default: () => ({}),
    },
  },
});
</script>


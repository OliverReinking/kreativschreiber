<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Nachricht an Oliver Reinking"
        :breadcrumbs="{
          Organisation: route('customer.dashboard'),
        }"
      ></breadcrumb>
    </template>

    <section-form>
      <template #title>Nachricht an Oliver</template>
      <template #description
        >Hier kannst du eine Nachricht an Oliver erstellen
        <!-- Loading -->
        <input-loading
          :loading="loading"
          :loading-text="loadingText"
        ></input-loading>
        <!-- ENDS Loading -->
      </template>

      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle
          >Deine Anregung, deine Frage, deine Kritik
        </input-subtitle>

        <input-group>
          <input-container :full-width="true">
            <input-label name="content" label="Deine Nachricht"></input-label>
            <input-textarea
              :rows="6"
              name="content"
              v-model="form.content"
              ref="content"
              placeholder="Deine Nachricht"
            ></input-textarea>
            <input-error :message="errors.content" />
          </input-container>
        </input-group>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="sendMessage">
              Nachricht versenden
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import SmoothScroll from "@/Pages/Components/SmoothScroll.vue";

import SectionForm from "@/Pages/Components/Content/SectionForm.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ErrorList from "@/Pages/Components/Form/ErrorList.vue";
import InputSubtitle from "@/Pages/Components/Form/InputSubtitle.vue";
import InputGroup from "@/Pages/Components/Form/InputGroup.vue";
import InputContainer from "@/Pages/Components/Form/InputContainer.vue";
import InputLabel from "@/Pages/Components/Form/InputLabel.vue";
import InputTextarea from "@/Pages/Components/Form/InputTextarea.vue";
import InputError from "@/Pages/Components/Form/InputError.vue";

export default defineComponent({
  name: "Customer_ChatCreate",

  components: {
    CustomerLayout,
    Breadcrumb,
    SmoothScroll,
    SectionForm,
    ButtonGroup,
    InputButton,
    InputLoading,
    ErrorList,
    InputSubtitle,
    InputGroup,
    InputContainer,
    InputLabel,
    InputTextarea,
    InputError,
  },

  props: {
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      loading: false,
      loadingText: null,
      //
      form: {
        content: null,
      },
    };
  },

  methods: {
    sendMessage() {
      this.loading = true;
      this.loadingText =
        "Deine Nachricht wird versendet.";
      //
      this.$inertia.post(
        this.route("customer.chat.store"),
        this.form,
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

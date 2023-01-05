<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Nachricht"
        :breadcrumbs="{
          Posteingang: route('admin.chat.inbox.index'),
        }"
      ></breadcrumb>
    </template>
    <!-- Anzeige Nachricht -->
    <chat-show
      :inbox="true"
      :chat="chat"
      :chathistory="chathistory"
    ></chat-show>

    <section-border></section-border>

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
          >Deine Antwort auf die obige Nachricht
        </input-subtitle>

        <input-group>
          <input-container :full-width="true">
            <input-label name="content" label="Deine Antwort"></input-label>
            <input-textarea
              :rows="6"
              name="content"
              v-model="form.content"
              ref="content"
              placeholder="Deine Antwort"
            ></input-textarea>
            <input-error :message="errors.content" />
          </input-container>
        </input-group>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="answerMessage">
              Nachricht beantworten
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
  </admin-layout>
</template>
<script>
import { defineComponent } from "vue";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import ChatShow from "@/Pages/Application/Shared/ChatShow.vue";

import SmoothScroll from "@/Pages/Components/SmoothScroll.vue";

import SectionForm from "@/Pages/Components/Content/SectionForm.vue";
import SectionBorder from "@/Pages/Components/Content/SectionBorder.vue";

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
  name: "Admin_ChatInboxShow",

  components: {
    AdminLayout,
    Breadcrumb,
    ChatShow,
    SmoothScroll,
    SectionForm,
    SectionBorder,
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
    chat: {
      type: Object,
      default: () => ({}),
    },
    chathistory: {
      type: Object,
      default: () => ({}),
    },
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
    answerMessage() {
      this.loading = true;
      this.loadingText = "Die Antwort auf diese Nachricht wird versendet.";
      //
      this.$inertia.post(this.route("admin.chat.inbox.store", this.chat.id), this.form, {
        onSuccess: () => {
          this.loading = false;
        },
        onError: () => {
          this.loading = false;
        },
      });
    },
  },
});
</script>


<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        :current="
          acquisition.id > 0 ? 'Ändere Akquisition' : 'Akquisition erstellen'
        "
        :breadcrumbs="{
          'Übersicht Akquisition': route('admin.acquisition.dashboard'),
          'Liste der Akquisitionen': route('admin.acquisition.index'),
          'Anzeige einer Akquisition': route(
            'admin.acquisition.show',
            acquisition.id
          ),
        }"
      ></breadcrumb>
    </template>

    <section-form :full-width="true">
      <template #title>Akquisition</template>
      <template #description
        >Hier kannst du die Daten einer Akquisition ändern
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

        <input-subtitle>Daten </input-subtitle>

        <input-group>
          <input-container>
            <input-element
              type="hidden"
              name="id"
              v-model="form.id"
              ref="id"
            ></input-element>

            <input-label name="email" label="Mailadresse"></input-label>
            <input-element
              type="text"
              name="email"
              v-model="form.email"
              :required="true"
              ref="email"
            ></input-element>
            <input-error :message="errors.email" />
          </input-container>

          <input-container>
            <input-label name="branch" label="Branche"></input-label>
            <input-element
              type="text"
              name="branch"
              v-model="form.branch"
              :required="true"
              ref="branch"
            ></input-element>
            <input-error :message="errors.branch" />
          </input-container>

          <input-container>
            <input-label name="notes" label="Notiz"></input-label>
            <input-element
              type="text"
              name="notes"
              v-model="form.notes"
              ref="notes"
            ></input-element>
            <input-error :message="errors.notes" />
          </input-container>
        </input-group>
      </template>

      <template #actions>
        <div class="flex flex-col gap-4">
          <!-- Befehle -->
          <button-group>
            <smooth-scroll href="#app-layout-start" v-if="acquisition.id > 0">
              <input-button
                type="button"
                @click.prevent="updateAcquisitionData"
              >
                Akquisition ändern
              </input-button>
            </smooth-scroll>
            <smooth-scroll href="#app-layout-start" v-if="acquisition.id == 0">
              <input-button
                type="button"
                @click.prevent="createAcquisitionData"
              >
                Akquisition erstellen
              </input-button>
            </smooth-scroll>
            <input-danger-button
              type="button"
              @click.prevent="deleteAcquisitionData"
            >
              Akquisition löschen
            </input-danger-button>
          </button-group>
          <!-- ENDS Befehle -->
          <!-- Befehle -->
          <button-group>
            <smooth-scroll href="#app-layout-start">
              <input-button
                type="button"
                @click.prevent="finishedAcquisition()"
              >
                Akquisition ist beendet
              </input-button>
            </smooth-scroll>
            <smooth-scroll href="#app-layout-start">
              <input-button type="button" @click.prevent="runningAcquisition()">
                Akquisition läuft
              </input-button>
            </smooth-scroll>
            <smooth-scroll href="#app-layout-start">
              <input-button
                type="button"
                @click.prevent="unsucessfulAcquisition()"
              >
                Akquisition war erfolglos
              </input-button>
            </smooth-scroll>
            <smooth-scroll href="#app-layout-start">
              <input-button
                type="button"
                @click.prevent="sucessfulAcquisition()"
              >
                Akquisition war erfolgreich
              </input-button>
            </smooth-scroll>
          </button-group>
          <!-- ENDS Befehle -->
        </div>
      </template>
    </section-form>
  </admin-layout>
</template>
<script>
import { defineComponent } from "vue";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import SmoothScroll from "@/Pages/Components/SmoothScroll.vue";

import SectionForm from "@/Pages/Components/Content/SectionForm.vue";
import SectionBorder from "@/Pages/Components/Content/SectionBorder.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";
import InputDangerButton from "@/Pages/Components/Form/InputDangerButton.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ErrorList from "@/Pages/Components/Form/ErrorList.vue";
import InputSubtitle from "@/Pages/Components/Form/InputSubtitle.vue";
import InputGroup from "@/Pages/Components/Form/InputGroup.vue";
import InputContainer from "@/Pages/Components/Form/InputContainer.vue";
import InputLabel from "@/Pages/Components/Form/InputLabel.vue";
import InputElement from "@/Pages/Components/Form/InputElement.vue";
import InputError from "@/Pages/Components/Form/InputError.vue";

export default defineComponent({
  name: "Admin_AcquisitionForm",

  components: {
    AdminLayout,
    Breadcrumb,
    SmoothScroll,
    SectionForm,
    SectionBorder,
    ButtonGroup,
    InputButton,
    InputDangerButton,
    InputLoading,
    ErrorList,
    InputSubtitle,
    InputGroup,
    InputContainer,
    InputLabel,
    InputElement,
    InputError,
  },

  props: {
    acquisition: {
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
        id: this.acquisition.id,
        email: this.acquisition.email,
        branch: this.acquisition.branch,
        notes: this.acquisition.notes,
      },
    };
  },

  methods: {
    createAcquisitionData() {
      this.loading = true;
      this.loadingText = "Die neue Akquisition wird erstellt.";
      //
      this.$inertia.post(
        this.route("admin.acquisition.store", this.acquisition.id),
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

    updateAcquisitionData() {
      this.loading = true;
      this.loadingText =
        "Die geänderten Daten der Akquisition werden jetzt gespeichert!";
      //
      this.$inertia.put(
        this.route("admin.acquisition.update", this.acquisition.id),
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

    deleteAcquisitionData() {
      this.loading = true;
      this.loadingText = "Die Akquisition wird gelöscht!";
      //
      this.$inertia.delete(
        this.route("admin.acquisition.delete", this.acquisition.id),
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

    finishedAcquisition() {
      this.loading = true;
      this.loadingText = "Die Akquisition wird in beendet geändert!";
      //
      this.$inertia.put(
        this.route(
          "admin.acquisition.update.running.false",
          this.acquisition.id
        ),
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

    runningAcquisition() {
      this.loading = true;
      this.loadingText = "Die Akquisition wird in laufend geändert!";
      //
      this.$inertia.put(
        this.route(
          "admin.acquisition.update.running.true",
          this.acquisition.id
        ),
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

    unsucessfulAcquisition() {
      this.loading = true;
      this.loadingText = "Die Akquisition wird in erfolglos geändert!";
      //
      this.$inertia.put(
        this.route(
          "admin.acquisition.update.successful.false",
          this.acquisition.id
        ),
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

    sucessfulAcquisition() {
      this.loading = true;
      this.loadingText = "Die Akquisition wird in erfolgreich geändert!";
      //
      this.$inertia.put(
        this.route(
          "admin.acquisition.update.successful.true",
          this.acquisition.id
        ),
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


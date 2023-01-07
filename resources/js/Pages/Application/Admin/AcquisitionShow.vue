<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Anzeige einer Akquisition"
        :breadcrumbs="{
          'Übersicht Akquisition': route('admin.acquisition.dashboard'),
          'Liste der Akquisitionen': route('admin.acquisition.index'),
          'Änderung einer Akquisition': route(
            'admin.acquisition.edit',
            acquisition.id
          ),
        }"
      ></breadcrumb>
    </template>

    <page-title> Anzeige einer Akquisition </page-title>

    <!-- Loading -->
    <input-loading
      :loading="loading"
      :loading-text="loadingText"
    ></input-loading>
    <!-- ENDS Loading -->

    <section-content :full-width="true">
      <template #content>
        <display-title>Daten der Akquisition</display-title>
        <display-row label="Mail">
          <template #content>
            {{ acquisition.email }}
          </template>
        </display-row>

        <display-row label="Branche">
          <template #content>
            {{ acquisition.branch }}
          </template>
        </display-row>

        <display-row label="letzte Aktion am">
          <template #content>
            <display-date
              :value="acquisition.last_action_date"
              :time-on="true"
            ></display-date>
          </template>
        </display-row>

        <display-row label="letzte Aktion">
          <template #content>
            {{ acquisition.last_action_name }}
          </template>
        </display-row>

        <display-row label="läuft die Akquisition noch?">
          <template #content>
            <display-yes-or-no :value="acquisition.running"></display-yes-or-no>
          </template>
        </display-row>

        <display-row label="war die Akquisition erfolreich?">
          <template #content>
            <display-yes-or-no
              :value="acquisition.successful"
            ></display-yes-or-no>
          </template>
        </display-row>

        <display-title>Aktionen</display-title>
        <!-- Befehle -->
        <button-group align="justify-start">
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="executeAction(1)">
              1. Mail an einen Online-Shop
            </input-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="executeAction(2)">
              2. Mail an einen Online-Shop
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-content>

    <section-border></section-border>

    <section-content :full-width="true">
      <template #content>
        <display-title>Bisherige Aktionen</display-title>

        <array-list-container
          :list-data="acquisition_actions"
          :size="50"
          :curent-page="1"
          no-entries="Es wurden keine Aktionen gefunden"
        >
          <template #header>
            <tr>
              <th class="np-dl-th-normal">Aktionsdatum</th>
              <th class="np-dl-th-normal">Name der Aktion</th>
            </tr>
          </template>
          <template v-slot:datarow="data">
            <td class="np-dl-td-normal-top">
              <display-date :value="data.datarow.action_date" :time-on="true" />
            </td>
            <td class="np-dl-td-normal-top">
              {{ data.datarow.action_name }}
            </td>
          </template>
        </array-list-container>
      </template>
    </section-content>

    <section-border></section-border>

    <section-accordion :full-width="true">
      <template #title>Mailtexte</template>
      <template #description
        >eine Liste aller Mailtexte für die Aquisition</template
      >
      <template #content>
        <accordion title="1. Mail an einen Online-Shop">
          <template #content>
            <copy-to-clipboard
              :copy-text="mailtext_onlineshop_one"
              copy-description="Klicke hier und den Mailtext in die Zwischenablage zu kopieren"
            ></copy-to-clipboard>
          </template>
        </accordion>
      </template>
    </section-accordion>
  </admin-layout>
</template>

<script>
import { defineComponent } from "vue";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import PageTitle from "@/Pages/Components/Content/PageTitle.vue";

import SmoothScroll from "@/Pages/Components/SmoothScroll.vue";

import SectionContent from "@/Pages/Components/Content/SectionContent.vue";
import SectionBorder from "@/Pages/Components/Content/SectionBorder.vue";

import DisplayTitle from "@/Pages/Components/Content/DisplayTitle.vue";
import DisplayRow from "@/Pages/Components/Content/DisplayRow.vue";
import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";
import DisplayYesOrNo from "@/Pages/Components/Content/DisplayYesOrNo.vue";

import Accordion from "@/Pages/Components/Content/Accordion.vue";

import SectionAccordion from "@/Pages/Components/Content/SectionAccordion.vue";

import CopyToClipboard from "@/Pages/Components/CopyToClipboard.vue";

import ArrayListContainer from "@/Pages/Application/Shared/ArrayListContainer.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";
import InputDangerButton from "@/Pages/Components/Form/InputDangerButton.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

export default defineComponent({
  name: "Admin_AcquisitionShow",

  components: {
    AdminLayout,
    Breadcrumb,
    PageTitle,
    SmoothScroll,
    SectionContent,
    SectionBorder,
    DisplayTitle,
    DisplayRow,
    DisplayDate,
    DisplayYesOrNo,
    Accordion,
    SectionAccordion,
    CopyToClipboard,
    ArrayListContainer,
    ButtonGroup,
    InputButton,
    InputDangerButton,
    InputLoading,
  },

  props: {
    acquisition: {
      type: Object,
      default: () => ({}),
    },
    acquisition_actions: {
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

  computed: {
    mailtext_onlineshop_one() {
      return `
Sehr geehrte Damen und Herren,

ich hoffe, Sie sind gut ins neue Jahr gestartet.

Als Betreiber eines Online-Shops möchte ich Ihnen gerne eine neue Anwendung vorstellen, die ich entwickelt habe: KreativSchreiber.
KreativSchreiber ist eine webbasierte Anwendung, die mithilfe von künstlicher Intelligenz professionelle und qualitativ hochwertige Blog- und Werbetexte erstellt.
Unternehmen können mit KreativSchreiber ihre Online-Präsenz stärken und ihre Marketingkampagnen verbessern.

Ich würde Ihnen gerne eine kostenlose Testphase anbieten, in der Sie KreativSchreiber ausprobieren können. Ich glaube, dass die Anwendung auch für Ihren Online-Shop von großem Nutzen sein könnte.

Bitte lassen Sie mich wissen, ob Sie Interesse an einer Testphase haben oder weitere Fragen zu KreativSchreiber haben. Ich stehe Ihnen gerne zur Verfügung.

Mit freundlichen Grüßen,

Oliver Reinking
Diplom-Mathematiker

66482 Zweibrücken
Nordpfad 25

Telefon: 06332 - 993 993

P.S. Möchten Sie sofort starten? Hier geht es zur Webseite von KreativSchreiber: kreativschreiber.com
Einfach registrieren und noch heute den ersten Text erstellen.`;
    },
  },

  methods: {
    executeAction(action_number) {
      this.loading = true;
      this.loadingText = "Die Aktion wird dokumentiert!";
      //
      this.$inertia.put(
        this.route("admin.acquisition.create.action", [
          this.acquisition.id,
          action_number,
        ]),
        {},
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

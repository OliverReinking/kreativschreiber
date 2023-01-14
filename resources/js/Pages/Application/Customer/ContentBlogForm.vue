<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Blogtext erstellen"
        :breadcrumbs="{
          Liste: route('customer.content.index'),
        }"
      ></breadcrumb>
    </template>

    <!-- Loading -->
    <input-loading
      :loading="loading"
      :loading-text="loadingText"
    ></input-loading>
    <!-- ENDS Loading -->

    <section-form>
      <template #title>neuen Blogtext erstellen</template>
      <template #description
        >Hier kannst du einen neuen Blogtext erstellen
      </template>

      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle>Daten</input-subtitle>

        <input-group>
          <input-container :full-width="true">
            <input-label
              name="topic"
              label="Beschreibung des Themas"
            ></input-label>
            <input-textarea
              :rows="6"
              name="topic"
              v-model="form.topic"
              ref="offer"
              placeholder="Beschreibe das Thema für den Blogtext"
            ></input-textarea>
            <input-error :message="errors.topic" />
          </input-container>

          <input-container :full-width="true">
            <input-label
              name="interest_groups"
              label="Interessengruppen"
            ></input-label>
            <input-textarea
              :rows="1"
              name="interest_groups"
              v-model="form.interest_groups"
              ref="interest_groups"
              placeholder="Beschreibe die Interessengruppen"
            ></input-textarea>
            <input-error :message="errors.interest_groups" />
          </input-container>

          <input-container :full-width="true">
            <input-label
              name="professional_groups"
              label="Berufsgruppen"
            ></input-label>
            <input-textarea
              :rows="1"
              name="professional_groups"
              v-model="form.professional_groups"
              ref="professional_groups"
              placeholder="Beschreibe die Berufsgruppen"
            ></input-textarea>
            <input-error :message="errors.professional_groups" />
          </input-container>

          <input-container :full-width="true">
            <input-label name="lifestyle" label="Lifestyle"></input-label>
            <input-textarea
              :rows="1"
              name="lifestyle"
              v-model="form.lifestyle"
              ref="lifestyle"
              placeholder="Beschreibe den Lifestyle"
            ></input-textarea>
            <input-error :message="errors.lifestyle" />
          </input-container>

          <input-container>
            <input-label
              name="number_of_words"
              label="Anzahl der Wörter"
            ></input-label>
            <input-select
              v-model="form.number_of_words"
              :options="numbers"
              :sort-column="0"
              ref="number_of_words"
            ></input-select>
            <input-error :message="errors.number_of_words" />
          </input-container>
        </input-group>

        <input-subtitle>Geschlecht</input-subtitle>
        <input-group>
          <input-container>
            <input-checkbox name="gender_female" v-model="form.gender_female">
              Weiblich</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox name="gender_male" v-model="form.gender_male">
              Männlich</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox name="gender_divers" v-model="form.gender_divers">
              Divers</input-checkbox
            >
          </input-container>
        </input-group>

        <input-subtitle>Altersschichten</input-subtitle>
        <input-group>
          <input-container>
            <input-checkbox
              name="age_strata_children"
              v-model="form.age_strata_children"
            >
              Kinder</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name="age_strata_young"
              v-model="form.age_strata_young"
            >
              Jugendliche</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name="age_strata_adults"
              v-model="form.age_strata_adults"
            >
              Erwachsene</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name="age_strata_seniors"
              v-model="form.age_strata_seniors"
            >
              Senioren</input-checkbox
            >
          </input-container>
        </input-group>

        <input-subtitle>Gewünschter Schreibstil</input-subtitle>
        <input-group>
          <input-container>
            <input-checkbox
              name="writing_style_personal"
              v-model="form.writing_style_personal"
            >
              Persönlich</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name="writing_style_objective"
              v-model="form.writing_style_objective"
            >
              Sachlich</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name="writing_style_opinionated"
              v-model="form.writing_style_opinionated"
            >
              Meinungsstark</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name=" writing_style_entertaining"
              v-model="form.writing_style_entertaining"
            >
              Unterhaltend</input-checkbox
            >
          </input-container>
          <input-container>
            <input-checkbox
              name="writing_style_creative"
              v-model="form.writing_style_creative"
            >
              Kreativ</input-checkbox
            >
          </input-container>
        </input-group>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="createBlogText">
              Blogtext erstellen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>

    <section-border></section-border>

    <section-accordion>
      <template #title>Hilfe</template>
      <template #description>Informationen zu den Eingabefeldern</template>
      <template #content>
        <accordion title="Hilfe">
          <template #content>
            <online-help-container>
              <online-help-title
                value="Beschreibung des Blogthemas"
              ></online-help-title>
              <online-help-description>
                <div class="mt-2">
                  Beschreibe das Blogthema möglichst präzise.
                </div>
                <div class="mt-2">
                  Hier ein paar Beispiele:
                  <ul>
                    <li>"Die Top 10 Reiseziele für 2022"</li>
                    <li>"5 Tipps für den perfekten Garten"</li>
                    <li>"Warum Du jetzt mit dem Rauchen aufhören solltest"</li>
                    <li>"Die besten veganen Rezepte für den Sommer"</li>
                    <li>"Die Vor- und Nachteile von Homeschooling"</li>
                  </ul>
                </div>
              </online-help-description>

              <online-help-title value="Interessengruppen"></online-help-title>
              <online-help-description>
                Einige Beispiele für Interessengruppen, die man in diesem
                Eingabefeld angeben könnte, sind:
                <ul>
                  <li>Sportbegeisterte</li>
                  <li>Reisende</li>
                  <li>Musikfans</li>
                  <li>Naturliebhaber</li>
                  <li>Kunstinteressierte</li>
                  <li>Technikfreaks</li>
                  <li>Gamer</li>
                  <li>Tierbesitzer</li>
                  <li>Familien</li>
                  <li>Singles</li>
                  <li>Senioren</li>
                </ul>
              </online-help-description>

              <online-help-title value="Berufsgruppen"></online-help-title>
              <online-help-description>
                Einige Beispiele für Berufsgruppen, die man in diesem
                Eingabefeld angeben könnte, sind:
                <ul>
                  <li>Ärzte</li>
                  <li>Lehrer</li>
                  <li>Ingenieure</li>
                  <li>Juristen</li>
                  <li>Architekten</li>
                  <li>Steuerberater</li>
                  <li>Verwaltungsfachkräfte</li>
                  <li>Buchhalter</li>
                  <li>Medienberufe (z.B. Journalisten, PR-Manager)</li>
                  <li>Marketing- und Verkaufsprofis</li>
                  <li>IT-Fachkräfte</li>
                  <li>Handwerker</li>
                </ul>
              </online-help-description>

              <online-help-title value="Lifestyle"></online-help-title>
              <online-help-description>
                Ein Eingabefeld für Lifestyle könnte verwendet werden, um die
                Zielgruppe für einen Blogtext zu definieren und um den Text
                möglichst passgenau auf sie zuzuschneiden. Hier könnten
                verschiedene Aspekte des Lebensstils der Zielgruppe aufgelistet
                werden, die für den Blogtext relevant sind. Einige Beispiele für
                Lifestyle-Aspekte, die man in diesem Eingabefeld angeben könnte,
                sind:
                <ul>
                  <li>Sportaktivitäten und -interessen</li>
                  <li>Ernährungsgewohnheiten</li>
                  <li>Reiseverhalten</li>
                  <li>Hobbys und Freizeitbeschäftigungen</li>
                  <li>Mode- und Einrichtungsvorlieben</li>
                  <li>Technikaffinität</li>
                  <li>Konsumverhalten</li>
                  <li>Umweltbewusstsein</li>
                  <li>Gesundheitsbewusstsein</li>
                  <li>Familienstand und Kinderwunsch</li>
                </ul>

                Es ist wichtig zu beachten, dass der Lifestyle einer Person
                einen großen Einfluss auf ihre Kaufentscheidungen hat und daher
                auch für Blogtexte von großer Bedeutung sein kann. Daher sollte
                man sorgfältig überlegen, welche Aspekte des Lebensstils der
                Zielgruppe für den Blogtext relevant sind und wie man sie in den
                Text einbeziehen kann.
              </online-help-description>

              <online-help-title value="Anzahl der Wörter"></online-help-title>
              <online-help-description>
                Du kannst hier die Länge des Blogtextes festlegen.
              </online-help-description>

              <online-help-title value="Geschlecht"></online-help-title>
              <online-help-description>
                Blogtexte können sich an bestimmte Geschlechter richten, wie
                z.B. Männer oder Frauen.
              </online-help-description>

              <online-help-title value="Altersschichten"></online-help-title>
              <online-help-description>
                Blogtexte können sich an bestimmte Altersschichten richten, wie
                z.B. Kinder, Jugendliche, Erwachsene oder Senioren.
              </online-help-description>

              <online-help-title
                value="Gewünschter Schreibstil"
              ></online-help-title>
              <online-help-description>
                <div>
                  <b>Persönlich</b>
                  <br />
                  Dieser Schreibstil ist geprägt durch die persönliche
                  Perspektive und Erfahrung des Autors. Er kann Geschichten,
                  Gedanken und Meinungen des Autors enthalten und eine
                  persönliche Verbindung zum Leser aufbauen.
                </div>
                <div class="mt-2">
                  <b>Sachlich</b>
                  <br />
                  Dieser Schreibstil ist geprägt durch die Präsentation von
                  Fakten und Informationen in einer objektiven und neutralen Art
                  und Weise. Er eignet sich besonders für Blogs, die sachliche
                  Themen behandeln, wie z.B. Nachrichten oder Wissenschaft.
                </div>
                <div class="mt-2">
                  <b>Meinungsstark</b>
                  <br />
                  Dieser Schreibstil drückt die Meinung und Perspektive des
                  Autors deutlich aus und versucht, den Leser von einer
                  bestimmten Sichtweise zu überzeugen. Er eignet sich besonders
                  für Blogs, die Meinungsartikel oder Debatten enthalten.
                </div>
                <div class="mt-2">
                  <b>Unterhaltend</b>
                  <br />
                  Dieser Schreibstil versucht, den Leser durch Unterhaltung und
                  Humor zu begeistern. Er eignet sich besonders für Blogs, die
                  sich an eine breite Zielgruppe richten und die eine leichtere,
                  unterhaltsame Lektüre bieten möchten.
                </div>
                <div class="mt-2">
                  <b>Kreativ</b>
                  <br />
                  Dieser Schreibstil setzt auf kreative Elemente wie Metaphern,
                  Analogien oder poetische Formen, um eine besondere Atmosphäre
                  zu schaffen oder die Aufmerksamkeit des Lesers zu wecken. Er
                  eignet sich besonders für Blogs, die sich an eine
                  künstlerische oder kreative Zielgruppe richten.
                </div>
                <div class="mt-2">
                  Du musst mindestens einen Schreibstil auswählen, aber du
                  kannst auch mehrere Schreibstile auswählen.
                </div>
              </online-help-description>
            </online-help-container>
          </template>
        </accordion>
      </template>
    </section-accordion>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
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
import InputCheckbox from "@/Pages/Components/Form/InputCheckbox.vue";
import InputSelect from "@/Pages/Components/Form/InputSelect.vue";
import InputTextarea from "@/Pages/Components/Form/InputTextarea.vue";
import InputHtml from "@/Pages/Components/Form/InputHtml.vue";
import InputError from "@/Pages/Components/Form/InputError.vue";

import DialogModal from "@/Pages/Components/DialogModal.vue";

import Alert from "@/Pages/Components/Content/Alert.vue";

import Accordion from "@/Pages/Components/Content/Accordion.vue";

import SectionAccordion from "@/Pages/Components/Content/SectionAccordion.vue";

import OnlineHelpContainer from "@/Pages/Components/Content/OnlineHelpContainer.vue";
import OnlineHelpTitle from "@/Pages/Components/Content/OnlineHelpTitle.vue";
import OnlineHelpDescription from "@/Pages/Components/Content/OnlineHelpDescription.vue";

export default defineComponent({
  name: "Customer_ContentBlogForm",

  components: {
    CustomerLayout,
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
    InputCheckbox,
    InputSelect,
    InputTextarea,
    InputHtml,
    InputError,
    DialogModal,
    Alert,
    Accordion,
    SectionAccordion,
    OnlineHelpContainer,
    OnlineHelpTitle,
    OnlineHelpDescription,
  },

  props: {
    content: {
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
      numbers: {
        400: "400 Wörter",
        500: "500 Wörter",
        600: "600 Wörter",
        700: "700 Wörter",
        800: "800 Wörter",
        900: "900 Wörter",
      },
      //
      form: {
        topic: this.content?.topic,
        interest_groups: this.content?.interest_groups,
        professional_groups: this.content?.professional_groups,
        lifestyle: this.content?.lifestyle,
        //
        number_of_words: this.content?.number_of_words,
        //
        writing_style_personal: this.content?.writing_style_personal,
        writing_style_objective: this.content?.writing_style_objective,
        writing_style_opinionated: this.content?.writing_style_opinionated,
        writing_style_entertaining: this.content?.writing_style_entertaining,
        writing_style_creative: this.content?.writing_style_creative,
        //
        age_strata_children: this.content?.age_strata_children,
        age_strata_young: this.content?.age_strata_young,
        age_strata_adults: this.content?.age_strata_adults,
        age_strata_seniors: this.content?.age_strata_seniors,
        //
        gender_female: this.content?.gender_female,
        gender_male: this.content?.gender_male,
        gender_divers: this.content?.gender_divers,
      },
    };
  },

  methods: {
    createBlogText() {
      this.loading = true;
      this.loadingText =
        "Der Blogtext wird erstellt, bitte habe einen Augenblick Geduld!<br />Die Erstellung kann schon mal eine Minute oder länger andauern.";
      //
      this.$inertia.post(this.route("customer.content.blog.store"), this.form, {
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

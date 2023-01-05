<template>
  <homepage-layout header-title="Preise">
    <section
      class="
        bg-layout-100
        text-layout-800
        dark:bg-layout-800 dark:text-layout-100
      "
    >
      <div
        class="container flex flex-col justify-center px-4 py-8 mx-auto md:p-8"
      >
        <h2 class="text-2xl font-semibold sm:text-4xl">
          Häufig gestellte Fragen
        </h2>
        <p class="mt-4 mb-8 text-layout-600 dark:text-layout-400">
          Alles, was Sie über KreativSchreiber wissen müssen - immer griffbereit
          in unseren FAQs
        </p>
        <div class="space-y-4">
          <details class="w-full border rounded-lg bg-transparent">
            <summary
              class="
                px-4
                py-6
                hover:bg-sunprimary-lighter hover:dark:bg-nightprimary-lighter
                focus:outline-none
                focus-visible:ring-sunprimary
                rounded-lg
              "
            >
              Was ist KreativSchreiber?
            </summary>
            <p
              class="
                px-4
                py-6
                pt-0
                ml-4
                mt-4
                text-layout-600
                dark:text-layout-400
              "
            >
              KreativSchreiber ist eine Web-Anwendung, die Unternehmen dabei
              hilft, Werbe- und Blogtexte schnell und einfach zu erstellen. Mit
              Hilfe des ChatGPT können Nutzer direkt mit der Anwendung
              kommunizieren und Texte in Echtzeit erstellen.
            </p>
          </details>
          <details class="w-full border rounded-lg bg-transparent">
            <summary
              class="
                px-4
                py-6
                hover:bg-sunprimary-lighter hover:dark:bg-nightprimary-lighter
                focus:outline-none
                focus-visible:ring-sunprimary
                rounded-lg
              "
            >
              Wie funktioniert KreativSchreiber?
            </summary>
            <p
              class="
                px-4
                py-6
                pt-0
                ml-4
                mt-4
                text-layout-600
                dark:text-layout-400
              "
            >
              Um einen Text zu erstellen, gibt der Nutzer einfach eine
              Überschrift und einige Stichworte ein, die den Inhalt des Textes
              beschreiben. Die Anwendung verwendet dann den ChatGPT, um einen
              einzigartigen und professionellen Text zu erstellen, der die
              Stichworte enthält. Der Nutzer kann den Text dann noch bearbeiten
              und anpassen, bevor er ihn veröffentlicht.
              <br />
              Die erstellten Texte werden in einer Datenbank gespeichert und
              können jederzeit erneut abgerufen werden
            </p>
          </details>
          <details class="w-full border rounded-lg bg-transparent">
            <summary
              class="
                px-4
                py-6
                hover:bg-sunprimary-lighter hover:dark:bg-nightprimary-lighter
                focus:outline-none
                focus-visible:ring-sunprimary
                rounded-lg
              "
            >
              Wie viel kostet KreativSchreiber?
            </summary>
            <div
              class="
                px-4
                py-6
                pt-0
                ml-4
                mt-4
                text-layout-600
                dark:text-layout-400
              "
            >
              Die Kosten für die Nutzung von KreativSchreiber hängen von der
              Anzahl der gewünschten Texte ab. Es gibt verschiedene Preispläne
              zur Auswahl, um den Bedürfnissen jedes Nutzers gerecht zu werden.
              <br />
              <div class="mt-4">
                <input-icon-hyperlink :href="route('pricing')">
                  <template #icon>
                    <icon-credit-card class="h-5 w-5 mr-1"></icon-credit-card>
                  </template>
                  zur Preisübersicht
                </input-icon-hyperlink>
              </div>
            </div>
          </details>
          <details class="w-full border rounded-lg bg-transparent">
            <summary
              class="
                px-4
                py-6
                hover:bg-sunprimary-lighter hover:dark:bg-nightprimary-lighter
                focus:outline-none
                focus-visible:ring-sunprimary
                rounded-lg
              "
            >
              Bietet KreativSchreiber auch Kundensupport?
            </summary>
            <div
              class="
                px-4
                py-6
                pt-0
                ml-4
                mt-4
                text-layout-600
                dark:text-layout-400
              "
            >
              Ja, es gibt ein Support-Team, das Nutzern bei Fragen oder
              Problemen mit KreativSchreiber weiterhelfen kann. Der Support ist
              per E-Mail oder auch telefonisch erreichbar.
              <br />
              <div class="mt-4">
                <input-icon-hyperlink :href="route('contact')">
                  <template #icon>
                    <icon-credit-card class="h-5 w-5 mr-1"></icon-credit-card>
                  </template>
                  zu den Kontaktdaten
                </input-icon-hyperlink>
              </div>
            </div>
          </details>
        </div>
      </div>
    </section>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";

import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

import Accordion from "@/Pages/Components/Content/Accordion.vue";

import InputIconHyperlink from "@/Pages/Components/Form/InputIconHyperlink.vue";

import IconCreditCard from "@/Pages/Components/Icons/CreditCard.vue";

export default defineComponent({
  name: "Homepage_Faq",

  components: {
    HomepageLayout,
    Accordion,
    InputIconHyperlink,
    IconCreditCard,
  },
});
</script>

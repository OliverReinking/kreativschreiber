<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="Infos zu den KreativSchreiber-Punkten"
      ></breadcrumb>
    </template>

    <div
      class="
        mx-auto
        p-6
        bg-white
        border border-layout-200
        rounded-lg
        shadow-md
        dark:bg-layout-800 dark:border-layout-700
      "
    >
      <h5
        class="
          mb-2
          text-2xl
          font-bold
          tracking-tight
          text-layout-900
          dark:text-white
        "
      >
        Informationen zu den KreativSchreiber-Punkten
      </h5>

      <div class="mb-3 font-normal text-layout-700 dark:text-layout-400">
        <div class="mt-2">
          Ich freue mich, dass du dich für die Anwendung zur Erstellung von
          professionellen Werbe- und Blogtexten entschieden hast.
        </div>
        <div class="mt-2">
          Um dir die Nutzung von KreativSchreiber so einfach wie möglich zu
          machen, biete ich dir die Möglichkeit, KreativSchreiber-Punkte zu
          erwerben und damit Texte zu erstellen.
        </div>
        <div class="mt-2">
          Jeder KreativSchreiber-Punkt entspricht einem Wort und wird für die
          Erstellung von Texten verwendet.
        </div>
        <div class="mt-2">
          Du kannst dein Punktekonto auffüllen, indem du eines unserer drei
          verfügbaren Pakete erwirbst:
        </div>
        <div class="mt-2">
          <ul class="list-disc list-inside">
            <li>
              Das Starter-Paket kostet 30 EUR und enthält 5.000
              KreativSchreiber-Punkte
            </li>
            <li>
              Das Plus-Paket kostet 57 EUR und enthält 10.000
              KreativSchreiber-Punkte
            </li>
            <li>
              Das Premium-Paket kostet 108 EUR und enthält 20.000
              KreativSchreiber-Punkte
            </li>
          </ul>
        </div>
        <div class="mt-2">
          Sobald du ein Paket erworben hast, werden die KreativSchreiber-Punkte
          automatisch deinem Punktekonto gutgeschrieben und können zur
          Erstellung von Texten verwendet werden.
        </div>
        <div class="mt-2">
          Du kannst jederzeit überprüfen, wie viele Punkte noch auf deinem Konto
          verfügbar sind, indem du auf der Startseite den Punktestand abliest.
        </div>
        <div class="mt-2">
          Eine Übersicht aller <b>KreativSchreiber-Transaktionen</b> findest du,
          wenn du in der linken Navigation auf <b>Organisation</b> klickst, und
          dort dann den Menüpunkt
          <b>Liste der KreativSchreiber-Transaktionen</b> auswählst.
        </div>
      </div>
    </div>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

export default defineComponent({
  name: "Customer_BookingInfo",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
  },
});
</script>


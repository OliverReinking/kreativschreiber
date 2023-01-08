<template>
  <homepage-layout header-title="Preise">
    <section class="bg-layout-100 dark:bg-layout-900">
      <div class="container px-6 py-8 mx-auto">
        <div class="sm:flex sm:items-center sm:justify-between pb-12">
          <div>
            <h2
              class="
                text-3xl
                font-bold
                text-layout-800
                lg:text-4xl
                dark:text-layout-100
              "
            >
              Ein ganz einfaches Preismodell
            </h2>
            <p class="mt-8 text-layout-600 dark:text-layout-300 text-lg">
              Keine monatlichen Gebühren!
              <br />
              <br />
              Bei uns hast du die Wahl! Mit unserem flexiblen Punkte-Modell
              kannst du genau das buchen, was du brauchst. Ob nun ein kleines
              oder großes Projekt, wir haben das passende Paket für dich. Kaufe
              einfach die benötigte Anzahl an KreativSchreiber-Punkten und nutze
              diese für unsere professionellen Textleistungen. Du entscheidest,
              wie viel du ausgeben möchtest und hast damit volle
              Kostenkontrolle.
              <br />
              <br />
              Überzeuge dich selbst von unserem unschlagbaren Angebot und
              registriere dich jetzt! Als Dankeschön schenken wir dir 2.000
              KreativSchreiber-Punkte, damit du unsere Anwendung in aller Ruhe
              ausprobieren kannst.
            </p>
            <Link
              :href="route('register')"
              class="
                mt-8
                inline-flex
                items-center
                px-4
                py-2
                h-10
                rounded-md
                font-medium
                text-xs
                tracking-widest
                disabled:opacity-25
                transition
                cursor-pointer
                border-2
                focus:ring focus:outline-none
                border-sunprimary
                text-on-sunprimary
                hover:bg-layout-200 hover:border-sunprimary
                focus:border-sunprimary
                dark:border-nightprimary
                dark:text-on-nightprimary
                dark:hover:text-on-nightprimary-dark
                dark:hover:border-nightprimary
                dark:focus:border-nightprimary
              "
            >
              Jetzt kostenfrei ausprobieren!
            </Link>
          </div>
        </div>

        <div
          class="
            grid
            gap-6
            mt-16
            -mx-6
            sm:gap-8 sm:grid-cols-2
            lg:grid-cols-3
            p-4
          "
        >
          <div
            class="
              px-6
              py-4
              transition-colors
              duration-300
              transform
              rounded-lg
              bg-white
              dark:bg-layout-800
              hover:bg-layout-200
              dark:hover:bg-layout-700
            "
          >
            <p class="text-lg font-medium text-layout-800 dark:text-layout-100">
              Starter
            </p>

            <h4
              class="
                mt-2
                text-4xl
                font-semibold
                text-layout-800
                dark:text-layout-100
              "
            >
              30 €
            </h4>

            <div class="mt-4 text-layout-500 dark:text-layout-300 h-24">
              Mit unserem Starter-Paket kannst du Blog- und Werbetext erstellen,
              dabei stehen dir ingesamt 5.000 Wörter zur Verfügung.
            </div>

            <div class="mt-8 space-y-8">
              <div class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 mr-2 text-sunprimary dark:text-nightprimary"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"
                  />
                </svg>

                <div class="mx-4 text-layout-700 dark:text-layout-300">
                  5.000 Wörter
                </div>
              </div>
            </div>
          </div>
          <div
            class="
              px-6
              py-4
              transition-colors
              duration-300
              transform
              rounded-lg
              bg-white
              dark:bg-layout-800
              hover:bg-layout-200
              dark:hover:bg-layout-700
            "
          >
            <div class="text-lg font-medium text-layout-800 dark:text-layout-100">
              Plus
            </div>

            <h4
              class="
                mt-2
                text-4xl
                font-semibold
                text-layout-800
                dark:text-layout-100
              "
            >
              57 €
            </h4>

            <div class="mt-4 text-layout-500 dark:text-layout-300 h-24">
              Mit unserem Plus-Paket stehen dir ingesamt 10.000 Wörter zur
              Verfügung.
            </div>

            <div class="mt-8 space-y-8">
              <div class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 mr-2 text-sunprimary dark:text-nightprimary"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"
                  />
                </svg>

                <div class="mx-4 text-layout-700 dark:text-layout-300">
                  10.000 Wörter
                </div>
              </div>
            </div>
          </div>

          <div
            class="
              px-6
              py-4
              transition-colors
              duration-300
              transform
              rounded-lg
              bg-white
              dark:bg-layout-800
              hover:bg-layout-200
              dark:hover:bg-layout-700
            "
          >
            <p class="text-lg font-medium text-layout-800 dark:text-layout-100">
              Premium
            </p>

            <h4
              class="
                mt-2
                text-4xl
                font-semibold
                text-layout-800
                dark:text-layout-100
              "
            >
              108 €
            </h4>

            <div class="mt-4 text-layout-500 dark:text-layout-300 h-24">
              Mit unserem Premium-Paket stehen dir ingesamt 20.000 Wörter zur
              Verfügung.
            </div>

            <div class="mt-8 space-y-8">
              <div class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 mr-2 text-sunprimary dark:text-nightprimary"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"
                  />
                </svg>

                <div class="mx-4 text-layout-700 dark:text-layout-300">
                  20.000 Wörter
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

export default defineComponent({
  name: "Homepage_Pricing",

  components: {
    Link,
    HomepageLayout,
  },
});
</script>

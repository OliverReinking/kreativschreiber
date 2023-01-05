<template>
  <homepage-layout header-title="Home">
    <section class="py-6 bg-layout-100 text-layout-900 dark:bg-layout-900 dark:text-layout-50">
      <div
        class="
          container
          mx-auto
          flex flex-col
          items-center
          justify-center
          p-4
          space-y-8
          md:p-10 md:px-24
          xl:px-48
        "
      >
        <h1 class="text-5xl font-extrabold font-logo leading-none text-center">
          Werbe mit Worten - lass uns deine Marke zum Strahlen
          bringen.
        </h1>

        <div class="text-2xl font-bold text-center">
          Schreibe deine Geschichte - mit KreativSchreiber als Ghostwriter
        </div>
        <div class="text-xl font-medium text-center">
          Möchtst du deine Geschichte erzählen, aber fehlen dir die Worte dafür?
          <br />
          <br />
          Kein Problem!
          <br />
          <br />Mit KreativSchreiber hast du einen professionellen Ghostwriter
          an deiner Seite, der dir dabei hilft, kreative und informative Blog-
          oder Werbetexte mit Hilfe von ChatGPT zu erstellen.
          <br />
          <br />
          Mit ChatGPT, einem künstlichen Intelligenz-System, können wir schnell
          und einfach hochwertige Texte für dich erstellen, die deinen
          Anforderungen und Zielen entsprechen.
          <br />
          <br />
          Überzeuge dich selbst von unserem unschlagbaren Angebot und
          registriere dich jetzt! Als Dankeschön schenken wir dir 2.000
          KreativSchreiber-Punkte, damit du unsere Anwendung in aller Ruhe
          ausprobieren kannst.
        </div>
        <div
          class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:space-x-8"
        >
          <button
            class="
              px-8
              py-3
              text-lg
              font-semibold
              rounded-lg
              bg-sunprimary-darker
              text-on-sunprimary-darker
              dark:bg-nightprimary-lighter
              dark:text-on-nightprimary
              hover:bg-sunprimary-dark
              hover:dark:bg-nightprimary

            "
          >
            <Link :href="route('register')">
              Jetzt sofort ausprobieren!
            </Link>
          </button>
        </div>
      </div>
    </section>


    <home-content-box
      category="Deine Vorteile"
      part_one="Texte, die begeistern"
    >
      <template #part_two>
        - lass uns deine
        <span class="text-sunprimary dark:text-nightprimary">Zielgruppe</span>
        erreichen.
      </template>
      <template #content>
        <div
          class="
            grid
            gap-8
            row-gap-5
            mb-8
            md:row-gap-8
            lg:grid-cols-4
            sm:grid-cols-2
          "
        >
          <div
            class="
              duration-300
              transform
              bg-layout-100
              dark:bg-layout-900
              border-l-4 border-sunprimary
              dark:border-nightprimary
              hover:-translate-y-2
            "
          >
            <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
              <h6 class="mb-2 font-semibold leading-5">Kosteneinsparungen</h6>
              <p class="text-sm">
                Die Anwendung <b>{{ $page.props.platform.name }}</b> bietet eine
                kostengünstige Alternative zum Einstellen von
                Inhouse-Schreibern.
              </p>
            </div>
          </div>
          <div
            class="
              duration-300
              transform
              bg-layout-100
              dark:bg-layout-900
              border-l-4 border-sunprimary
              dark:border-nightprimary
              hover:-translate-y-2
            "
          >
            <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
              <h6 class="mb-2 font-semibold leading-5">Flexibilität</h6>
              <p class="text-sm">
                Die Anwendung <b>{{ $page.props.platform.name }}</b> kann von
                überall auf der Welt aus genutzt werden und bietet die
                Möglichkeit, Texte für verschiedene Zwecke und Zielgruppen zu
                erstellen.
              </p>
            </div>
          </div>
          <div
            class="
              duration-300
              transform
              bg-layout-100
              dark:bg-layout-900
              border-l-4 border-sunprimary
              dark:border-nightprimary
              hover:-translate-y-2
            "
          >
            <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
              <h6 class="mb-2 font-semibold leading-5">Zeiteinsparung</h6>
              <p class="text-sm">
                Die Anwendung <b>{{ $page.props.platform.name }}</b> übernimmt
                das Schreiben für dich, sodass du dich auf andere wichtige
                Aufgaben konzentrieren kannst.
              </p>
            </div>
          </div>
          <div
            class="
              duration-300
              transform
              bg-layout-100
              dark:bg-layout-900
              border-l-4 border-sunprimary
              dark:border-nightprimary
              hover:-translate-y-2
            "
          >
            <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
              <h6 class="mb-2 font-semibold leading-5">
                Professionelles Ergebnis
              </h6>
              <p class="text-sm">
                Die Anwendung <b>{{ $page.props.platform.name }}</b> bietet
                professionell geschriebene Texte, die deine Marke oder dein
                Unternehmen repräsentieren und deine Zielgruppe überzeugen.
              </p>
            </div>
          </div>
        </div>
      </template>
    </home-content-box>

    <home-content-box
      v-if="blog"
      category="Blog"
      :category-route="route('home.blog.index')"
      part_one="Aktuelles "
    >
      <template #part_two>
        aus unserem
        <span class="text-sunprimary dark:text-nightprimary"
          >Blog</span
        ></template
      >
      <template #content>
        <div class="mt-8 container max-w-6xl mx-auto space-y-6 sm:space-y-12">
          <blog-preview-big :blog="blog"></blog-preview-big></div
      ></template>
    </home-content-box>

    <home-content-box
      v-if="webinar"
      category="Webinare"
      :category-route="route('home.webinar.index')"
      part_one="Unser "
    >
      <template #part_two>
        nächstes Webinar
        <span class="text-sunprimary dark:text-nightprimary"
          >"{{ webinar.title }}"</span
        >
        startet am <display-date :value="webinar.event_date" :time-on="false" />
        um
        <span>{{ webinar.event_start }}</span> Uhr
      </template>
      <template #content>
        <div class="mt-8 container max-w-6xl mx-auto space-y-6 sm:space-y-12">
          <webinar-preview-big :webinar="webinar"></webinar-preview-big>
        </div>
      </template>
    </home-content-box>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

import BlogPreviewBig from "@/Pages/Application/Shared/BlogPreviewBig.vue";
import WebinarPreviewBig from "@/Pages/Application/Shared/WebinarPreviewBig.vue";

import HomeContentBox from "@/Pages/Application/Homepage/Shared/HomeContentBox.vue";

import DisplayDate from "@/Pages/Components/Content/DisplayDate.vue";

export default defineComponent({
  name: "Homepage_Home",

  components: {
    Link,
    HomepageLayout,
    BlogPreviewBig,
    WebinarPreviewBig,
    HomeContentBox,
    DisplayDate,
  },

  props: {
    blog: {
      type: Object,
      default: () => ({}),
    },
    webinar: {
      type: Object,
      default: () => ({}),
    },
  },
});
</script>

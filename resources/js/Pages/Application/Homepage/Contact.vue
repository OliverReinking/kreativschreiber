<template>
  <homepage-layout header-title="Kontakt">
    <div class="container px-6 py-16 mx-auto">
      <div class="items-center lg:flex lg:items-start">
        <div class="w-full lg:w-1/2">
          <div class="lg:max-w-lg">
            <h1 class="font-logo text-2xl font-semibold uppercase lg:text-3xl">
              Kontakt
            </h1>
            <div class="mt-2">
              Willkommen auf meiner Kontaktseite. Ich freue mich, von dir zu
              hören und stehe dir gerne für alle Fragen und Anliegen zur
              Verfügung. Auf dieser Seite findest du meine Kontaktdaten, unter
              denen du mich erreichen kannst.
            </div>
            <div class="mt-2">
              Du kannst mich per E-Mail oder per Telefon kontaktieren und ich
              werde mich so schnell wie möglich bei dir melden. Ich wünsche dir
              viel Erfolg mit der Anwendung
              {{ $page.props.platform.name }} und hoffe, dass ich dir bald
              weiterhelfen kann.
            </div>
            <div class="mt-2">Oliver Reinking</div>
            <div class="mt-2">Nordpfad 25, 66482 Zweibrücken</div>
            <div class="mt-2">Mobil: +49 170 881 9944</div>
            <div class="mt-2">Mail oliver[at]codingjungle.de</div>
            <div class="mt-2">Web: https://codingjungle.de</div>
          </div>
        </div>

        <div
          class="flex items-center justify-center w-full mt-6 lg:mt-0 lg:w-1/2"
        >
          <undraw-contact-us
            class="w-full h-full lg:max-w-2xl"
          ></undraw-contact-us>
        </div>
      </div>
    </div>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";
import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

import UndrawContactUs from "@/Pages/Components/UnDraw/ContactUs.vue";

export default defineComponent({
  name: "Homepage_Contact",

  components: {
    HomepageLayout,
    UndrawContactUs,
  },
});
</script>

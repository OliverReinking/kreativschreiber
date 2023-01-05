<template>
  <homepage-layout header-title="Meine Mission">
    <div class="container px-6 py-16 mx-auto">
      <div class="items-center lg:flex lg:items-start">
        <div class="w-full lg:w-1/2">
          <div class="lg:max-w-lg">
            <h1 class="font-logo text-2xl font-semibold uppercase lg:text-3xl">
              Meine Mission
            </h1>
            <div class="mt-2 prose dark:prose-invert">
              <div class="mt-4">
                Meine Mission ist es, Unternehmen dabei zu helfen, ihre
                Online-Präsenz zu stärken und ihre Marketingkampagnen zu
                verbessern. Durch die Verwendung fortschrittlicher Technologien
                wie ChatGPT biete ich professionelle und qualitativ hochwertige
                Blog- und Werbetexte an.
              </div>
              <div class="mt-4">
                Ich bin stolz darauf, meinen Kunden zu helfen, ihre Botschaften
                zu verbreiten und ihre Zielmärkte zu erreichen. Ich arbeite hart
                daran, meine Dienstleistungen ständig zu verbessern und neue
                Wege zu finden, um meinen Kunden den größtmöglichen Mehrwert zu
                bieten.
              </div>
              <div class="mt-4">
                Ich glaube daran, dass die Kommunikation eine wichtige Rolle bei
                der Erreichung von Geschäftszielen spielt und bin fest
                entschlossen, meinen Kunden dabei zu helfen, ihre Ziele zu
                erreichen. Ich bin sind immer auf der Suche nach neuen
                Herausforderungen und freue mich darauf, meine Fähigkeiten und
                mein Wissen in zukünftigen Projekten einzubringen.
              </div>
            </div>
          </div>
        </div>

        <div
          class="flex items-center justify-center w-full mt-6 lg:mt-0 lg:w-1/2"
        >
          <undraw-target
            class="w-full h-full lg:max-w-2xl"
          ></undraw-target>
        </div>
      </div>
    </div>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";
import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

import UndrawTarget from "@/Pages/Components/UnDraw/Target.vue";

export default defineComponent({
  name: "Homepage_Mission",

  components: {
    HomepageLayout,
    UndrawTarget,
  },
});
</script>

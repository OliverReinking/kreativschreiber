<template>
  <homepage-layout header-title="Über mich">
    <div class="container px-6 py-16 mx-auto">
      <div class="items-center lg:flex lg:items-start">
        <div class="w-full lg:w-1/2">
          <div class="lg:max-w-lg">
            <h1 class="font-logo text-2xl font-semibold uppercase lg:text-3xl">
              Über mich
            </h1>
            <div class="mt-2 prose dark:prose-invert">
              <div class="mt-4">
                Mein Name ist Oliver Reinking und ich bin Mathematiker und
                Softwareentwickler.
                <br />
                Ich wurde 1963 in Lübeck geboren und lebe heute in
                Zweibrücken.<br />
                In meiner Freizeit entwickle ich Web-Anwendungen mit Laravel,
                Vue.js und Tailwind CSS. Ich habe auch mehrere Sachbücher
                veröffentlicht, die sich mit der Nutzung dieser Technologien
                beschäftigen.<br />
              </div>
              <div class="mt-4">
                Ende 2022 habe ich beschlossen, die Web-Anwendung
                <b>{{ $page.props.platform.name }}</b> zur Erstellung von Werbe- und Blogtexten mit
                Hilfe des ChatGPT zu entwickeln. Ich hoffe, dass
                {{ $page.props.platform.name }} Unternehmen dabei helfen wird, ihre
                Online-Präsenz zu stärken und ihre Marketingkampagnen zu
                verbessern.<br />
              </div>
            </div>
          </div>
        </div>

        <div
          class="flex items-center justify-center w-full mt-6 lg:mt-0 lg:w-1/2"
        >
          <undraw-profile
            class="w-full h-full lg:max-w-2xl"
          ></undraw-profile>
        </div>
      </div>
    </div>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";
import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

import UndrawProfile from "@/Pages/Components/UnDraw/Profile.vue";

export default defineComponent({
  name: "Homepage_About",

  components: {
    HomepageLayout,
    UndrawProfile,
  },
});
</script>

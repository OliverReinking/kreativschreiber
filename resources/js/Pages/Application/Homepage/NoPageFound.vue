<template>
  <homepage-layout header-title="Seite nicht gefunden">
    <section class="flex items-center h-full p-16 bg-layout-50 text-layout-800 dark:bg-layout-900 dark:text-layout-100">
      <div
        class="
          container
          flex flex-col
          items-center
          justify-center
          px-5
          mx-auto
          my-8
        "
      >
        <div class="max-w-md text-center">
          <h2 class="mb-8 font-extrabold text-9xl text-layout-400 dark:text-layout-600">
            <span class="sr-only">Error</span>404
          </h2>
          <p class="text-2xl font-semibold md:text-3xl">
            Seite nicht gefunden!
          </p>
          <p class="mt-4 mb-8 text-layout-600 dark:text-layout-400">
            Aber keine Sorge, auf unserer Homepage finden Sie noch viele andere Dinge.
          </p>
          <a
            :href="route('home')"
            class="px-8 py-3 font-semibold rounded bg-sunprimary text-on-sunprimary dark:bg-nightprimary dark:text-on-nightprimary"
            >Zurück zur Homepage</a
          >
        </div>
      </div>
    </section>
  </homepage-layout>
</template>
<script>
import { defineComponent } from "vue";
import HomepageLayout from "@/Pages/Application/Homepage/Shared/Layout.vue";

export default defineComponent({
  name: "Homepage_NoPageFound",

  components: {
    HomepageLayout,
  },
});
</script>

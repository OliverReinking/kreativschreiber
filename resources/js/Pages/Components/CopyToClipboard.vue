<template>
  <div
    class="
      flex
      items-start
      justify-betweeen
      rounded-lg
      border
      text-layout-900
      bg-layout-50
      border-layout-100
      dark:text-layout-100 dark:bg-layout-800 dark:border-layout-700
    "
  >
    <div class="p-4 flex-1">
      {{ copyText }}
    </div>
    <div class="my-2 mr-2 text-sunprimary dark:text-nightprimary">
      <button
        type="submit"
        class="
          cursor-pointer
          outline-none
          h-8
          w-8
          rounded-full
          bg-sunprimary-lighter
          text-on-sunprimary-lighter
          hover:bg-sunprimary-darker
          hover:text-on-sunprimary-darker
          dark:bg-nightprimary-darker
          dark:text-on-nightprimary-darker
          dark:hover:bg-nightprimary-lighter
          dark:hover:text-on-nightprimary-lighter
        "
        @click.prevent="copyToClipboard"
        v-tippy
      >
        <icon-clipboard-document class="w-5 h-5 inline-flex items-center">
        </icon-clipboard-document>
      </button>
      <tippy>{{ copyDescription }}</tippy>
    </div>
  </div>
</template>
<script>
import { defineComponent } from "vue";

import IconClipboardDocument from "@/Pages/Components/Icons/ClipboardDocument.vue";

export default defineComponent({
  name: "Component_CopyToClipboard",

  components: {
    IconClipboardDocument,
  },

  props: {
    copyText: {
      type: String,
      required: true,
    },
    copyDescription: {
      type: String,
      default: "Hier klicken, dann wird der Text in die Zwischenablage kopiert",
    },
  },

  methods: {
    copyToClipboard() {
      //console.log("copyToClipboard");
      // Copy the text inside the text field
      navigator.clipboard.writeText(this.copyText);
      //
      alert("Der Text wurde in die Zwischenablage kopiert.");
    },
  },
});
</script>

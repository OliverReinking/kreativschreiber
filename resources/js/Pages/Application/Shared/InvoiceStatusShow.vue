<template>
  <div>
    <span
      v-if="id == 1"
      class="
        inline-block
        py-1.5
        px-4
        text-sm text-orange-700
        bg-orange-100
        rounded-lg
        dark:bg-orange-200 dark:text-orange-800
      "
    >
      {{ name }}
    </span>
    <span
      v-if="id == 2"
      class="
        inline-block
        py-1.5
        px-4
        text-sm text-red-700
        bg-red-100
        rounded-lg
        dark:bg-red-200 dark:text-red-800
      "
    >
      {{ name }}
    </span>
    <span
      v-if="id == 3"
      class="
        inline-block
        py-1.5
        px-4
        text-sm text-green-700
        bg-green-100
        rounded-lg
        dark:bg-green-200 dark:text-green-800
      "
    >
      {{ name }}
    </span>
    <span
      v-if="id == 4"
      class="
        inline-block
        py-1.5
        px-4
        text-sm text-orange-700
        bg-orange-100
        rounded-lg
        dark:bg-orange-200 dark:text-orange-800
      "
    >
      {{ name }}
    </span>
    <span
      v-if="id == 5"
      class="
        inline-block
        py-1.5
        px-4
        text-sm text-blue-700
        bg-blue-100
        rounded-lg
        dark:bg-blue-200 dark:text-blue-800
      "
    >
      {{ name }}
    </span>
  </div>
</template>
<script>
export default {
  name: "Shared_InvoiceStatusShow",

  props: {
    id: {
      type: Number,
      default: null,
    },
    name: {
      type: String,
      default: null,
    },
  },
};
</script>

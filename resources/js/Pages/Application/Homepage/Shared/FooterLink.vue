<template>
  <div v-if="routeName" class="inline-block">
    <Link :href="route(routeName)" class="hover:underline">
      {{ label }}</Link
    >
  </div>
  <div v-else class="inline-block">
    <div class="hover:underline cursor-pointer">
      <slot></slot>
    </div>
  </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  name: "Homepage_FooterLink",
  //
  components: {
    Link,
  },
  //
  props: {
    label: {
      type: String,
      default: null,
    },
    routeName: {
      type: String,
      default: null,
    },
  },
};
</script>

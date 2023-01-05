<template>
  <div
    class="
      px-4
      py-4
      max-w-none
      prose
      prose-lg
      rounded-md
      border
      border-green-500
      text-layout-900
      bg-layout-100
      dark:border-green-500
      dark:text-layout-50
      dark:bg-layout-800
    "
  ><slot></slot></div>
</template>
<script>
export default {
  name: "OnlineHelpContainer",
};
</script>

<template>
  <div>
    <div class="relative my-4">
      <div
        class="
          flex
          absolute
          inset-y-0
          left-0
          items-center
          pl-3
          pointer-events-none
        "
      >
        <icon-search class="block mr-3 h-5 w-5" />
      </div>
      <input
        type="text"
        id="default-search"
        class="
          block
          p-4
          pl-10
          w-full
          rounded-lg
          border
          text-sm text-layout-900
          bg-layout-50
          border-layout-300
          dark:text-layout-100 dark:bg-layout-900 dark:border-layout-700
          hover:outline-none
          focus:outline-none
          focus:ring-sunprimary-lighter focus:border-sunprimary-lighter
        "
        autocomplete="off"
        name="search"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      />

      <div class="absolute right-2 bottom-2 flex items-center justify-end gap-4">
        <button
          type="submit"
          class="
            font-medium
            rounded-lg
            text-sm
            px-4
            py-2
            cursor-pointer
            focus:ring focus:outline-none
            border-2 border-sunprimary
            bg-white
            text-layout-900
            hover:text-on-sunprimary-dark
            hover:bg-sunprimary-dark
            hover:border-sunprimary-dark
            focus:border-sunprimary-darker
            dark:border-nightprimary
            dark:bg-layout-900
            dark:text-white
            dark:hover:text-on-nightprimary
            dark:hover:bg-nightprimary
            dark:hover:border-nightprimary-dark
            dark:focus:border-nightprimary-darker
          "
          @click.prevent="$emit('searching')"
        >
          Suchen
        </button>
        <button
          type="submit"
          class="
            font-medium
            rounded-lg
            text-sm
            px-4
            py-2
            cursor-pointer
            focus:ring focus:outline-none
            border-2 border-sunprimary
            bg-white
            text-layout-900
            hover:text-on-sunprimary-dark
            hover:bg-sunprimary-dark
            hover:border-sunprimary-dark
            focus:border-sunprimary-darker
            dark:border-nightprimary
            dark:bg-layout-900
            dark:text-white
            dark:hover:text-on-nightprimary
            dark:hover:bg-nightprimary
            dark:hover:border-nightprimary-dark
            dark:focus:border-nightprimary-darker
          "
          @click.prevent="$emit('reset')"
        >
          Suche zurücksetzen
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import IconSearch from "@/Pages/Components/Icons/Search.vue";
//
export default {
  name: "ArrayListSearch",
  //
  emits: ["update:modelValue", "searching"],
  //
  components: {
    IconSearch,
  },
  //
  props: {
    modelValue: {
      type: String,
      default: null,
    },
    placeholder: {
      type: String,
      default: "Suchen",
    },
    searchText: {
      type: String,
    },
  },
};
</script>

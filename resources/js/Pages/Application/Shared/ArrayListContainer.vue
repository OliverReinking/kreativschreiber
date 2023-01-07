<template>
  <div>
    <div v-if="dataLength > 0">
      <table class="np-dl-table">
        <thead class="np-dl-thead">
          <slot name="header"></slot>
        </thead>

        <tbody>
          <tr
            v-for="datarow in paginateData"
            :key="datarow.id"
            class="np-dl-tr"
          >
            <slot name="datarow" :datarow="datarow"></slot>
            <td
              v-if="editOn"
              class="np-dl-td-edit"
              @click.prevent="editDataRow(datarow.id)"
            >
              <icon-edit class="w-4 h-4" />
            </td>
            <td
              v-if="showOn"
              class="np-dl-td-edit"
              @click.prevent="showDataRow(datarow.id)"
            >
              <icon-eye class="w-4 h-4" />
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-8 flex items-center justify-center" v-if="pageCount > 1">
        <button
          @click.prevent="previousPage"
          class="
            inline-flex
            items-center
            py-2
            px-4
            text-sm
            font-medium
            text-on-sunprimary-dark
            bg-sunprimary-dark
            rounded-lg
            border border-layout-300
            hover:bg-sunprimary-light hover:text-on-sunprimary-light
            dark:bg-nightprimary-dark
            dark:border-layout-700
            dark:text-on-nightprimary-dark
            dark:hover:bg-nightprimary-light
            dark:hover:text-on-nightprimary-light
          "
          :class="[dataCurrentPage <= 1 ? 'cursor-not-allowed' : '']"
        >
          <icon-chevron-left class="h-4 w-4"></icon-chevron-left>
        </button>

        <div class="mx-4 text-xs">
          Seite {{ dataCurrentPage }} von {{ pageCount }}
        </div>

        <!-- Next Button -->
        <button
          @click.prevent="nextPage"
          class="
            inline-flex
            items-center
            py-2
            px-4
            text-sm
            font-medium
            text-on-sunprimary-dark
            bg-sunprimary-dark
            rounded-lg
            border border-layout-300
            hover:bg-sunprimary-light hover:text-on-sunprimary-light
            dark:bg-nightprimary-dark
            dark:border-layout-700
            dark:text-on-nightprimary-dark
            dark:hover:bg-nightprimary-light
            dark:hover:text-on-nightprimary-light
          "
          :class="[dataCurrentPage >= pageCount ? 'cursor-not-allowed' : '']"
        >
          <icon-chevron-right class="h-4 w-4"></icon-chevron-right>
        </button>
      </div>
    </div>
    <div v-if="dataLength == 0">
      <alert type="warning">{{ noEntries }} </alert>
    </div>
  </div>
</template>
<script>
import IconChevronLeft from "@/Pages/Components/Icons/ChevronLeft.vue";
import IconChevronRight from "@/Pages/Components/Icons/ChevronRight.vue";

import IconEdit from "@/Pages/Components/Icons/Edit.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";

import Alert from "@/Pages/Components/Content/Alert.vue";

export default {
  components: {
    IconChevronLeft,
    IconChevronRight,
    IconEdit,
    IconEye,
    Alert,
  },
  //
  props: {
    listData: {
      type: [Object, Array],
      default: () => [],
    },
    noEntries: {
      type: String,
      default: "Es wurden keine Datensätze gefunden.",
    },
    size: {
      type: Number,
      default: 10,
    },
    currentPage: {
      type: Number,
      default: 1,
    },
    showOn: {
      type: Boolean,
      default: false,
    },
    routeShow: {
      type: String,
    },
    editOn: {
      type: Boolean,
      default: false,
    },
    routeEdit: {
      type: String,
    },
  },
  //
  data() {
    return {
      dataCurrentPage: this.currentPage,
    };
  },
  //
  computed: {
    dataLength() {
      if (this.listData.constructor.name === "Object") {
        return Object.keys(this.listData).length;
      }
      return this.listData.length;
    },
    pageCount() {
      return Math.ceil(this.dataLength / this.size);
    },
    paginateData() {
      const start = (this.dataCurrentPage - 1) * this.size,
        end = start + this.size;
      //console.log("paginateData: ", start, end);
      return this.listData.slice(start, end);
    },
  },
  //
  methods: {
    nextPage() {
      this.dataCurrentPage += 1;
      if (this.dataCurrentPage > this.pageCount) {
        this.dataCurrentPage = this.pageCount;
      }
    },
    //
    previousPage() {
      this.dataCurrentPage -= 1;
      if (this.dataCurrentPage < 1) {
        this.dataCurrentPage = 1;
      }
    },
    editDataRow(id) {
      this.$inertia.get(this.route(this.routeEdit, id));
    },
    //
    showDataRow(id) {
      this.$inertia.get(this.route(this.routeShow, id));
    },
  },
};
</script>

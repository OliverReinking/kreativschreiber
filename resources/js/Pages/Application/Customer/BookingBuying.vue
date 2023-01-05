<template>
  <customer-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_customer"
        current="KreativSchreiber-Punkte kaufen"
      ></breadcrumb>
    </template>

    <div
      class="
        mx-auto
        p-6
        bg-white
        border border-layout-200
        rounded-lg
        shadow-md
        dark:bg-layout-800 dark:border-layout-700
      "
    >
      <h5
        class="
          mb-2
          text-2xl
          font-bold
          tracking-tight
          text-gray-900
          dark:text-white
        "
      >
        KreativSchreiber-Punkte kaufen
      </h5>
      <!-- Loading -->
      <input-loading
        :loading="loading"
        :loading-text="loadingText"
      ></input-loading>
      <!-- ENDS Loading -->
      <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        Du möchtest
        <display-number
          :value="points"
          :after-digits="0"
          value-unit="KreativSchreiber-Punkte"
        ></display-number>
        kaufen?
        <br />
        Der Preis hierfür beträgt
        <display-number
          :value="net_price"
          :after-digits="2"
          value-unit=" €"
        ></display-number>
      </div>
      <button-group align="mt-4 justify-start">
        <input-button type="button" @click.prevent="confirmPurchase()">
          Jetzt kaufen
        </input-button>
      </button-group>
    </div>

    <!-- Puchase Confirmation Modal -->
    <dialog-modal :show="confirmingPurchase" @close="close_confirmingPurchase">
      <template #title> KreativSchreiber-Punkte kaufen </template>

      <template #content>
        Bist du sicher, dass du {{ points }} KreativSchreiber-Punkte kaufen
        möchtest?
      </template>

      <template #footer>
        <button-group>
          <input-button @click="close_confirmingPurchase">
            Zurück
          </input-button>

          <input-button @click="purchasePoints">
            KreativSchreiber-Punkte jetzt kaufen
          </input-button>
        </button-group>
      </template>
    </dialog-modal>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";

import DisplayNumber from "@/Pages/Components/Content/DisplayNumber.vue";

import DialogModal from "@/Pages/Components/DialogModal.vue";

export default defineComponent({
  name: "Customer_BookingBuying",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
    InputLoading,
    ButtonGroup,
    InputButton,
    DisplayNumber,
    DialogModal,
  },

  props: {
    points: {
      type: Number,
      default: 1000,
    },
    net_price: {
      type: Number,
      default: 30,
    },
    gross_price: {
      type: Number,
      default: 30,
    },
  },

  data() {
    return {
      loading: false,
      loadingText: null,
      //
      confirmingPurchase: false,
    };
  },

  methods: {
    confirmPurchase() {
      this.confirmingPurchase = true;
    },

    purchasePoints() {
      this.confirmingPurchase = false;
      //
      this.loading = true;
      this.loadingText = "Die KreativSchreiber-Punkte werden gekauft!";
      //
      this.$inertia.post(
        this.route("customer.booking.purchase", this.points),
        {
          onSuccess: () => {
            this.loading = false;
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },

    close_confirmingPurchase() {
      this.confirmingPurchase = false;
    },
  },
});
</script>


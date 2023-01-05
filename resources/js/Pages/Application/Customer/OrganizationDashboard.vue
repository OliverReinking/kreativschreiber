<template>
  <customer-layout>
    <breadcrumb
      :application-name="$page.props.applications.app_customer"
      current="Übersicht Organisation"
    ></breadcrumb>

    <section class="mt-8">
      <div class="grid gap-6 grid-cols-1 md:grid-cols-2 2xl:grid-cols-3">

        <navigation-card
          title="Rechnungen"
          :buttonTwo="false"
        >
          <template #icon> <icon-credit-card /> </template>
          <template #description> Hier findest du alle Rechnungen </template>
          <template #buttonOne>
            <Link
              :href="route('customer.invoice.index')"
              class="flex items-center"
            >
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Liste
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Liste der KreativSchreiber-Transaktionen">
          <template #icon> <icon-clipboard /> </template>
          <template #description>
            Hier kannst du eine Liste der KreativSchreiber-Transaktionen
            anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.booking.index')"
              class="flex items-center"
            >
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Liste
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Kundendaten" :buttonTwo="true">
          <template #icon> <icon-building-office /> </template>
          <template #description>
            Hier kannst du deine Kundendaten ändern bzw. anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="
                route(
                  'customer.person_company.edit',
                  $page.props.userdata.customer_id
                )
              "
              class="flex items-center"
            >
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Jetzt ändern
            </Link>
          </template>
          <template #buttonTwo>
            <Link
              :href="
                route(
                  'customer.person_company.show',
                  $page.props.userdata.customer_id
                )
              "
              class="flex items-center"
            >
              <icon-eye class="inline-block h-5 w-5 mr-2" />Anzeigen
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Teammitglieder" :buttonTwo="true">
          <template #icon> <icon-users /> </template>
          <template #description>
            Hier kannst du eine Liste deiner Teammitglieder anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.teammember.index')"
              class="flex items-center"
            >
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Liste
            </Link>
          </template>
          <template #buttonTwo>
            <Link
              :href="route('customer.teammember.create')"
              class="flex items-center"
            >
              <icon-add-circle class="inline-block h-5 w-5 mr-2" />Neu
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Liste der Einladungen" :buttonTwo="false">
          <template #icon> <icon-users /> </template>
          <template #description>
            Hier kannst du eine Liste aller Teammitglieder-Einladungen anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.invitation.index')"
              class="flex items-center"
            >
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Liste
            </Link>
          </template>
        </navigation-card>
      </div>
    </section>
  </customer-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import CustomerLayout from "@/Pages/Application/Customer/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import NavigationCard from "@/Pages/Components/Content/NavigationCard.vue";

import IconBuildingOffice from "@/Pages/Components/Icons/BuildingOffice.vue";
import IconArrowLeftOnRectangle from "@/Pages/Components/Icons/ArrowLeftOnRectangle.vue";
import IconArrowRightOnRectangle from "@/Pages/Components/Icons/ArrowRightOnRectangle.vue";
import IconUsers from "@/Pages/Components/Icons/Users.vue";
import IconDocumentText from "@/Pages/Components/Icons/DocumentText.vue";
import IconCardList from "@/Pages/Components/Icons/CardList.vue";
import IconAddCircle from "@/Pages/Components/Icons/AddCircle.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";
import IconClipboard from "@/Pages/Components/Icons/Clipboard.vue";
import IconCreditCard from "@/Pages/Components/Icons/CreditCard.vue";

export default defineComponent({
  name: "Customer_OrganizationDashboard",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
    NavigationCard,
    IconBuildingOffice,
    IconArrowLeftOnRectangle,
    IconArrowRightOnRectangle,
    IconUsers,
    IconDocumentText,
    IconCardList,
    IconAddCircle,
    IconEye,
    IconClipboard,
    IconCreditCard,
  },
});
</script>

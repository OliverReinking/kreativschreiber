<template>
  <customer-layout>
    <breadcrumb
      :application-name="$page.props.applications.app_customer"
      :start-page="true"
    ></breadcrumb>

    <page-title>
      Herzlich Willkommen in der Anwendung {{ $page.props.platform.name }}!
    </page-title>

    <section class="mt-8">
      <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
         <statistic-value
          :with-link="true"
          route-name="customer.booking.info"
          :with-icon="true"
          icon="icon-pencil-square"
          label="KreativSchreiber-Punkte"
          value-type="number"
          :after-digits="0"
          value-unit="Punkte"
          value-single-unit="Punkt"
          :value="$page.props.userdata.ksPoints"
          v-tippy
        ></statistic-value>
        <tippy>Klicke hier, dann erfährst du mehr über KreativSchreiber-Punkte</tippy>
        <statistic-value
          :with-link="true"
          route-name="customer.booking.buying"
          :route-param=5000
          :with-icon="true"
          icon="icon-credit-card"
          label="Kaufe 5.000 KreativSchreiber-Punkte für"
          value-type="number"
          :after-digits="0"
          value-unit="EUR"
          value-single-unit="EUR"
          :value=30
          v-tippy
        ></statistic-value>
        <tippy>Klicke hier, und du kannst 5.000 KreativSchreiber-Punkte kaufen</tippy>
        <statistic-value
          :with-link="true"
          route-name="customer.booking.buying"
          :route-param=10000
          :with-icon="true"
          icon="icon-credit-card"
          label="Kaufe 10.000 KreativSchreiber-Punkte für"
          value-type="number"
          :after-digits="0"
          value-unit="EUR"
          value-single-unit="EUR"
          :value=57
          v-tippy
        ></statistic-value>
        <tippy>Klicke hier, und du kannst 10.000 KreativSchreiber-Punkte kaufen</tippy>
        <statistic-value
          :with-link="true"
          route-name="customer.booking.buying"
          :route-param=20000
          :with-icon="true"
          icon="icon-credit-card"
          label="Kaufe 20.000 KreativSchreiber-Punkte für"
          value-type="number"
          :after-digits="0"
          value-unit="EUR"
          value-single-unit="EUR"
          :value=108
          v-tippy
        ></statistic-value>
        <tippy>Klicke hier, und du kannst 20.000 KreativSchreiber-Punkte kaufen</tippy>
      </div>
    </section>

    <section class="mt-8">
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <navigation-card title="Liste der erstellten Werbe- und Blogtexte">
          <template #icon> <icon-document-text /> </template>
          <template #description>
            Hier kannst du eine Liste der erstellten Werbe- und Blogtexte
            anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.content.index')"
              class="flex items-center"
            >
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Liste
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Werbetext">
          <template #icon> <icon-document-text /> </template>
          <template #description>
            Hier kannst du einen neuen Werbetext erstellen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.content.advertising.create')"
              class="flex items-center"
            >
              <icon-add-circle class="inline-block h-5 w-5 mr-2" />Neu
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Blogtext">
          <template #icon> <icon-document-text /> </template>
          <template #description>
            Hier kannst du einen neuen Blogtext erstellen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.content.blog.create')"
              class="flex items-center"
            >
              <icon-add-circle class="inline-block h-5 w-5 mr-2" />Neu
            </Link>
          </template>
        </navigation-card>


        <navigation-card
          title="Organisation"
        >
          <template #icon> <icon-building-office /> </template>
          <template #description>
            Deine Kundendaten, Teammitglieder, KreativSchreiber-Transaktionen und Rechnungen.
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.organization.dashboard')"
              class="flex items-center"
            >
              <icon-eye class="inline-block h-5 w-5 mr-2" />Übersicht
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Posteingang">
          <template #icon>
            <icon-arrow-left-on-rectangle />
          </template>
          <template #description>
            Hier kannst du eine Liste aller Nachrichten im Posteingang anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.chat.inbox.index')"
              class="flex items-center"
            >
              <icon-card-list class="h-4 w-4 mr-1" />Posteingang
            </Link>
          </template>
        </navigation-card>

        <navigation-card title="Postausgang">
          <template #icon>
            <icon-arrow-right-on-rectangle />
          </template>
          <template #description>
            Hier kannst du eine Liste aller Nachrichten im Postausgang anzeigen
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.chat.outbox.index')"
              class="flex items-center"
            >
              <icon-card-list class="h-4 w-4 mr-1" />Postausgang
            </Link>
          </template>
        </navigation-card>

         <navigation-card title="Nachricht an Oliver Reinking">
          <template #icon> <icon-edit /> </template>
          <template #description>
            Du hast eine Anregung, eine Frage oder auch Kritik?<br>
            Schreibe mir!
          </template>
          <template #buttonOne>
            <Link
              :href="route('customer.chat.create')"
              class="flex items-center"
            >
              <icon-add-circle class="inline-block h-5 w-5 mr-2" />Info an Oliver
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

import PageTitle from "@/Pages/Components/Content/PageTitle.vue";

import NavigationCard from "@/Pages/Components/Content/NavigationCard.vue";

import StatisticValue from "@/Pages/Components/Content/StatisticValue.vue";

import IconBuildingOffice from "@/Pages/Components/Icons/BuildingOffice.vue";
import IconArrowLeftOnRectangle from "@/Pages/Components/Icons/ArrowLeftOnRectangle.vue";
import IconArrowRightOnRectangle from "@/Pages/Components/Icons/ArrowRightOnRectangle.vue";
import IconUsers from "@/Pages/Components/Icons/Users.vue";
import IconDocumentText from "@/Pages/Components/Icons/DocumentText.vue";
import IconCardList from "@/Pages/Components/Icons/CardList.vue";
import IconAddCircle from "@/Pages/Components/Icons/AddCircle.vue";
import IconEye from "@/Pages/Components/Icons/Eye.vue";
import IconClipboard from "@/Pages/Components/Icons/Clipboard.vue";
import IconEdit from "@/Pages/Components/Icons/Edit.vue";

export default defineComponent({
  name: "Customer_Dashboard",

  components: {
    Link,
    CustomerLayout,
    Breadcrumb,
    PageTitle,
    NavigationCard,
    StatisticValue,
    IconBuildingOffice,
    IconArrowLeftOnRectangle,
    IconArrowRightOnRectangle,
    IconUsers,
    IconDocumentText,
    IconCardList,
    IconAddCircle,
    IconEye,
    IconClipboard,
    IconEdit,
  },
});
</script>

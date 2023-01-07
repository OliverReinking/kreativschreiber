<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Übersicht Akquisition"
      ></breadcrumb>
    </template>

    <section class="mt-8">
      <div class="grid gap-6 grid-cols-1 md:grid-cols-2 2xl:grid-cols-3">
        <navigation-card title="Liste aller Akquisitionen" :buttonTwo="true">
          <template #icon> <icon-newspaper /> </template>
          <template #description>
            Hier kannst du eine Liste aller Akquisitionen anzeigen
          </template>
          <template #buttonOne>
            <Link :href="route('admin.acquisition.index')" class="flex items-center">
              <icon-card-list class="inline-block h-5 w-5 mr-2" />Liste
            </Link>
          </template>
          <template #buttonTwo>
            <Link :href="route('admin.acquisition.create')" class="flex items-center">
              <icon-add-circle class="inline-block h-5 w-5 mr-2" />Neu
            </Link>
          </template>
        </navigation-card>
      </div>
    </section>
  </admin-layout>
</template>
<script>
import { defineComponent } from "vue";

import { Link } from "@inertiajs/inertia-vue3";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import PageTitle from "@/Pages/Components/Content/PageTitle.vue";

import IconCardList from "@/Pages/Components/Icons/CardList.vue";
import IconAddCircle from "@/Pages/Components/Icons/AddCircle.vue";
import IconNewspaper from "@/Pages/Components/Icons/Newspaper.vue";

import NavigationCard from "@/Pages/Components/Content/NavigationCard.vue";

export default defineComponent({
  name: "Admin_AcquisitionDashboard",

  components: {
    Link,
    AdminLayout,
    Breadcrumb,
    PageTitle,
    IconCardList,
    IconAddCircle,
    IconNewspaper,
    NavigationCard,
  },
});
</script>

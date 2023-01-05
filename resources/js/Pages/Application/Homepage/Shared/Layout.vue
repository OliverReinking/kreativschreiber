<template>
  <Head :title="headerTitle" />
  <div class="relative flex flex-col justify-start" :class="mode">
    <!-- Header -->
    <header
      class="
        w-full
        bg-white
        dark:bg-layout-900
        border-b border-layout-100
        dark:border-transparent
        px-2
        sm:px-4
      "
    >
      <nav class="container mx-auto px-2 lg:px-8 py-2.5 rounded">
        <div class="flex flex-wrap justify-between items-center mx-auto">
          <company-name
            :with-favicon="true"
            :with-link="true"
            :with-slogan="true"
            route-name="home"
          ></company-name>
          <div class="flex md:order-2 items-center">
            <button-register-now></button-register-now>
            <button
              type="button"
              class="
                inline-flex
                items-center
                p-2
                text-sm text-layout-500
                rounded-lg
                md:hidden
                hover:bg-layout-100
                focus:outline-none focus:ring-2 focus:ring-layout-200
                dark:text-layout-400
                dark:hover:bg-layout-700
                dark:focus:ring-layout-600
              "
              v-on:click="toggleNavbar()"
            >
              <span class="sr-only">Menü öffnen</span>
              <icon-menu class="w-6 h-6" v-if="!isOpen"></icon-menu>
              <icon-close class="w-6 h-6" v-if="isOpen"></icon-close>
            </button>
          </div>
          <div
            class="
              justify-start
              items-start
              w-full
              md:flex md:w-auto md:order-1
            "
            v-bind:class="{
              hidden: !isOpen,
              'min-h-screen block': isOpen,
            }"
          >
            <ul
              class="
                flex flex-col
                items-center
                mt-4
                md:flex-row
                md:flex-nowrap
                md:space-x-8
                md:mt-0
                md:text-sm
                md:font-medium
              "
            >
              <li
                v-bind:class="{
                  'w-full': isOpen,
                }"
              >
                <nav-link label="Startseite" route-name="home"></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                }"
              >
                <nav-link label="Preise" route-name="pricing"></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                }"
              >
                <nav-link label="Blog" route-name="home.blog.index"></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                }"
              >
                <nav-link
                  label="Webinare"
                  route-name="home.webinar.index"
                ></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                }"
              >
                <nav-link label="Kontakt" route-name="contact"></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                  hidden: !isOpen,
                }"
              >
                <nav-link label="Login" route-name="login"></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                  hidden: !isOpen,
                }"
              >
                <nav-link
                  label="Registrierung"
                  route-name="register"
                ></nav-link>
              </li>
              <li
                v-bind:class="{
                  'w-full': isOpen,
                }"
              >
                <button-change-mode
                  :mode="mode"
                  @changeMode="changeMode"
                ></button-change-mode>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Content -->
    <section
      id="app-layout-start"
      class="
        text-layout-800
        dark:text-white
        bg-white
        dark:bg-layout-800
        w-full
        min-h-screen
        px-2
        sm:px-4
        pb-48
      "
    >
      <div class="container mx-auto px-2 lg:px-8 pt-2 lg:pt-8">
        <!-- Toast -->
        <toast></toast>
        <!-- CookieConsent inklusive slot für Content -->
        <div>
          <vue-cookie-accept-decline
            class="p-4 text-center cookie-container"
            :ref="'vcad_customer'"
            :elementId="'vcad_customer'"
            :debug="false"
            :position="'top-left'"
            :type="'bar'"
            :disableDecline="false"
            :transitionName="'slideFromBottom'"
            :showPostponeButton="true"
            @status="cookieStatus"
            @clicked-accept="cookieClickedAccept"
            @clicked-decline="cookieClickedDecline"
            @clicked-postpone="cookieClickedPostpone"
            @removed-cookie="cookieRemovedCookie"
          >
            <template #postponeContent>
              <div class="flex justify-end">
                <icon-close class="h-8 w-8 text-sunprimary" />
              </div>
            </template>

            <!-- Optional -->
            <template #message>
              <div class="my-8">
                Wir verwenden auf unserer Website Cookies.
                <br />
                Diese Cookies sind erforderlich, damit du diese Webseite nutzen
                kannst.
                <br />
                Die Cookie-Einwilligung kann jederzeit über den Link
                <b>Cookie-Einstellung</b> im Header angepasst werden.
              </div>
              <div class="mt-4 text-center">
                Weitere Informationen zum Thema
                <b>Cookies</b> findest Du in unserer
                <br />
                <a :href="route('privacy')" class="my-4 cookie-consent-link"
                  >Datenschutzerklärung</a
                >
              </div>
            </template>

            <!-- Optional -->
            <template #declineContent>
              <div class="btn-cookie-consent btn-cookie-consent-decline mr-2">
                Cookies ablehnen
              </div>
            </template>

            <!-- Optional -->
            <template #acceptContent>
              <div class="btn-cookie-consent btn-cookie-consent-accept mr-2">
                Cookies akzeptieren
              </div>
            </template>
          </vue-cookie-accept-decline>

          <div v-if="cookieConsentStatus == 'accept' || !cookieConsentDisplay">
            <slot></slot>
          </div>
          <div v-else class="cookie-container">
            <div class="p-4">
              Diese Webseite kann nicht genutzt werden, da Du die Nutzung
              unserer Cookies nicht akzeptiert hast.
              <br />
              Du kannst die Cookie-Einstellungen ändern, wenn Du in der
              Kopfzeile auf den Link
              <b>Cookie-Einstellungen</b> klickst.
            </div>

            <div class="p-4">
              Oder Du klickst auf den folgenden Button:
              <br />
              <button
                @click.prevent="cookieHasRemoved"
                class="mt-2 btn-cookie-consent btn-cookie-consent-change"
              >
                Cookie-Einstellungen anpassen
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->

    <footer
      class="
        px-4
        divide-y
        bg-layout-100
        text-layout-800
        dark:bg-layout-900 dark:text-layout-100
      "
    >
      <div
        class="
          container
          flex flex-col
          justify-between
          py-10
          mx-auto
          space-y-8
          lg:flex-row lg:space-y-0
        "
      >
        <div class="lg:w-1/3">
          <a
            rel="noopener noreferrer"
            href="#"
            class="flex justify-center space-x-3 lg:justify-start"
          >
            <company-name
              :with-favicon="true"
              :with-link="true"
              :with-slogan="false"
              route-name="home"
            ></company-name>
          </a>
        </div>
        <div
          class="
            grid grid-cols-2
            text-sm
            gap-x-3 gap-y-8
            lg:w-2/3
            sm:grid-cols-4
          "
        >
          <div class="space-y-3">
            <h3
              class="
                tracking-wide
                uppercase
                text-layout-900
                dark:text-layout-100
              "
            >
              KreativSchreiber
            </h3>
            <ul class="space-y-1">
              <li>
                <footer-link label="Preise" route-name="pricing"></footer-link>
              </li>
              <li>
                <footer-link
                  label="Blog"
                  route-name="home.blog.index"
                ></footer-link>
              </li>
              <li>
                <footer-link
                  label="Webinare"
                  route-name="home.webinar.index"
                ></footer-link>
              </li>
              <li>
                <footer-link label="FAQ" route-name="faq"></footer-link>
              </li>
            </ul>
          </div>
          <div class="space-y-3">
            <h3
              class="
                tracking-wide
                uppercase
                text-layout-900
                dark:text-layout-100
              "
            >
              Unternehmen
            </h3>
            <ul class="space-y-1">
              <li>
                <footer-link label="Über mich" route-name="about"></footer-link>
              </li>
              <li>
                <footer-link
                  label="Meine Mission"
                  route-name="mission"
                ></footer-link>
              </li>
              <li>
                <footer-link label="Kontakt" route-name="contact"></footer-link>
              </li>
              <li>
                <footer-link
                  label="Impressum"
                  route-name="imprint"
                ></footer-link>
              </li>
              <li>
                <footer-link
                  label="Datenschutzerklärung"
                  route-name="privacy"
                ></footer-link>
              </li>
              <li>
                <footer-link
                  label="Nutzungsbedingungen"
                  route-name="terms"
                ></footer-link>
              </li>

              <li>
                <smooth-scroll href="#app-layout-start">
                  <footer-link>
                    <div @click.prevent="cookieHasRemoved">
                      Cookie-Einstellungen
                    </div>
                  </footer-link>
                </smooth-scroll>
              </li>
            </ul>
          </div>
          <div class="space-y-3">
            <h3 class="uppercase text-layout-900 dark:text-layout-100">
              Zur Anwendung
            </h3>
            <ul class="space-y-1">
              <li>
                <footer-link label="Login" route-name="login"></footer-link>
              </li>
              <li>
                <footer-link
                  label="Registrierung"
                  route-name="register"
                ></footer-link>
              </li>
            </ul>
          </div>
          <div class="space-y-3">
            <div class="uppercase text-layout-900 dark:text-layout-100">
              Social Media
            </div>
            <div class="flex justify-start space-x-3">
              <a
                target="_blank"
                href="https://twitter.com"
                title="Twitter"
                class="flex items-center p-1"
              >
                <svg
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 fill-current"
                >
                  <path
                    d="M23.954 4.569a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.061a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div
        class="py-6 text-sm text-center text-layout-600 dark:text-layout-400"
      >
        © 2022 - {{ year }}
        <footer-link label="KreativSchreiber" route-name="home"></footer-link>.
        <br />
        <span class="hidden sm:inline-block">
          Version: {{ $page.props.version.versionnr }} vom
          {{ $page.props.version.versionsdatum }}
        </span>
      </div>
    </footer>
  </div>
</template>
<script>
// https://github.com/johndatserakis/vue-cookie-accept-decline
import VueCookieAcceptDecline from "vue-cookie-accept-decline";

import { ref } from "vue";

import { Head } from "@inertiajs/inertia-vue3";

import SmoothScroll from "@/Pages/Components/SmoothScroll.vue";

import NavLink from "@/Pages/Application/Homepage/Shared/NavLink.vue";
import ButtonRegisterNow from "@/Pages/Application/Homepage/Shared/ButtonRegisterNow.vue";
import FooterLink from "@/Pages/Application/Homepage/Shared/FooterLink.vue";

import Favicon from "@/Pages/Components/Logo/Favicon.vue";
import IconNight from "@/Pages/Components/Icons/Night.vue";
import IconSun from "@/Pages/Components/Icons/Sun.vue";
import IconMenu from "@/Pages/Components/Icons/Menu.vue";
import IconClose from "@/Pages/Components/Icons/Close.vue";

import ButtonChangeMode from "@/Pages/Components/ButtonChangeMode.vue";

import Toast from "@/Pages/Components/Content/Toast.vue";

import CompanyName from "@/Pages/Components/Content/CompanyName.vue";

export default {
  name: "Homepage_Layout",

  components: {
    VueCookieAcceptDecline,
    Head,
    SmoothScroll,
    NavLink,
    ButtonRegisterNow,
    FooterLink,
    Favicon,
    IconNight,
    IconSun,
    IconMenu,
    IconClose,
    ButtonChangeMode,
    Toast,
    CompanyName,
  },

  props: {
    headerTitle: {
      type: String,
      default: "KreativSchreiber",
    },
    cookieConsentDisplay: {
      type: Boolean,
      default: true,
    },
  },

  setup(props) {
    const mode = ref();
    const isOpen = ref(false);
    const year = ref(new Date().getFullYear());
    const cookieConsentStatus = ref("unknown");
    const vcad_customer = ref(null);
    //
    if (localStorage.theme) {
      mode.value = localStorage.theme;
    }
    //
    function changeMode(value) {
      mode.value = value;
      //
      localStorage.theme = mode.value;
    }
    //
    function toggleNavbar() {
      this.isOpen = !this.isOpen;
    }
    //
    function cookieStatus(status) {
      //console.log("status: " + status);
      if (status) {
        cookieConsentStatus.value = status;
      }
    }
    //
    function cookieClickedAccept() {
      //console.log("here in accept");
      cookieConsentStatus.value = "accept";
    }
    //
    function cookieClickedDecline() {
      //console.log("here in decline");
      cookieConsentStatus.values = "decline";
    }
    //
    function cookieClickedPostpone() {
      //console.log("here in postpone");
      cookieConsentStatus.values = "postpone";
    }
    //
    function cookieRemovedCookie() {
      //console.log("here in cookieRemoved");
      vcad_customer.value.init();
    }
    //
    function cookieHasRemoved() {
      //console.log("App methods cookieHasRemoved");
      vcad_customer.value.removeCookie();
    }
    //
    return {
      mode,
      isOpen,
      year,
      cookieConsentStatus,
      vcad_customer,
      changeMode,
      toggleNavbar,
      cookieStatus,
      cookieClickedAccept,
      cookieClickedDecline,
      cookieClickedPostpone,
      cookieRemovedCookie,
      cookieHasRemoved,
    };
  },
};
</script>

<template>
  <admin-layout>
    <template #breadcrumb>
      <breadcrumb
        :application-name="$page.props.applications.app_admin"
        current="Rechnung"
        :breadcrumbs="{
          'Liste der Rechnungen': route('admin.invoice.index'),
        }"
      ></breadcrumb>
    </template>

    <!-- Loading -->
    <input-loading
      :loading="loading"
      :loading-text="loadingText"
    ></input-loading>
    <!-- ENDS Loading -->

    <section-form :full-width="true" v-if="invoiceShowing">
      <template #form> <input-subtitle>Aktionen</input-subtitle> </template>
      <template #actions>
        <!-- Befehle -->
        <button-group align="justify-start">
          <input-danger-button
            type="button"
            @click.prevent="showDeletingInvoice"
          >
            Rechnung löschen
          </input-danger-button>
          <input-button type="button" @click.prevent="showInvoiceUnpaidAgain">
            Rechnung ist wieder unbezahlt
          </input-button>
          <input-button type="button" @click.prevent="showInvoiceWasPaid">
            Rechnung wurde bezahlt
          </input-button>
          <input-button type="button" @click.prevent="showInvoiceReminder">
            Rechnung mahnen
          </input-button>
          <input-button type="button" @click.prevent="showInvoiceCancel">
            Rechnung stornieren
          </input-button>
          <input-button type="button" @click.prevent="showInvoiceNote">
            Rechnungsnotiz hinzufügen
          </input-button>
        </button-group>
      </template>
    </section-form>

    <!-- Rechnung löschen -->
    <section-form :full-width="true" v-if="!loading && deletingInvoice">
      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle>Rechnung löschen</input-subtitle>

        <div>
          Die Rechnung und alle ihre Rechnungsposten werden gelöscht.
          <br />
          In den zugehörigen Abonnements der Rechnungsposten wird das Attribut
          'Rechnung gestellt bis' entsprechend angepasst.
        </div>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-danger-button type="button" @click.prevent="deleteInvoice">
              Rechnung löschen
            </input-danger-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelForm">
              Abbrechen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
    <!-- ENDS Rechnung löschen -->

    <!-- Rechnung ist wieder unbezahlt -->
    <section-form :full-width="true" v-if="!loading && unpayingInvoice">
      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle>Rechnung ist wieder unbezahlt</input-subtitle>

        <div>
          Die Rechnung wird auf unbezahlt gesetzt.
        </div>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="unpayInvoice">
              Rechnung ist wieder unbezahlt
            </input-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelForm">
              Abbrechen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
    <!-- ENDS Rechnung ist wieder unbezahlt -->

    <!-- Rechnung wurde bezahlt -->
    <section-form :full-width="true" v-if="!loading && payingInvoice">
      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle>Rechnung wurde bezahlt</input-subtitle>

        <div>
          Die Rechnung wird auf bezahlt gesetzt.
          <br />
          Diese Rechnung kann danach nicht mehr gelöscht werden.
        </div>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="payInvoice">
              Rechnung wurde bezahlt
            </input-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelForm">
              Abbrechen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
    <!-- ENDS Rechnung wurde bezahlt -->

    <!-- Rechnung mahnen -->
    <section-form :full-width="true" v-if="!loading && remindingInvoice">
      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle>Rechnung mahnen</input-subtitle>

        <div>
          Die Rechnung wird angemahnt.
          <br />
          D.h. der Rechnungsstatus wird in 'Rechnung wird gemahnt' abgeändert.
          <br />
          Zusätzlich wird eine 'digitale Nachricht' an das Unternehmen
          versendet.
          <br />
          Diese 'digitale Nachricht' wird dem Unternehmen mittels E-Mail
          angekündigt.
        </div>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="remindInvoice">
              Rechnung mahnen
            </input-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelForm">
              Abbrechen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
    <!-- ENDS Rechnung mahnen -->

    <!-- Rechnung stornieren -->
    <section-form :full-width="true" v-if="!loading && cancellingInvoice">
      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle
          >Rechnungsstornierung - Was gilt es zu beachten?</input-subtitle
        >
        <div>
          Eine doppelte Rechnungsnummer, eine falsche Adresse oder eine fehlende
          Ausweisung der Mehrwertsteuer. Die Liste möglicher Fehler bei der
          Rechnungserstellung ist lang. Im Falle einer Betriebsprüfung können
          auch kleine Fehler zu großen Problemen führen. Wichtig ist, dass
          Rechnungen keinesfalls vom Leistungsempfänger korrigiert werden,
          sondern ausschließlich vom ursprünglichen Rechnungssteller.
        </div>
        <div>
          <b>Rechnungstatus 'Rechnung erstellt'</b>
          <br />
          Einfach die Rechnung löschen und eine neue Rechnung erstellen.
        </div>
        <div>
          <b>Rechnungstatus 'Rechnung bezahlt'</b>
          <br />
          Sind Rechnungen bereits verbucht, lassen sich diese nicht mehr im
          Nachhinein korrigieren. Hier führt kein Weg an einer
          Rechnungsstornierung vorbei. Wurde der Rechnungsbetrag bereits
          bezahlt, muss eine Art „Gutschrift” für die jeweilige Rechnungssumme
          erstellt werden. Dazu wird eine Storno-Rechnung erstellt, die den
          Rechnungsbetrag als Negativsumme ausweist.
        </div>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelInvoice">
              Rechnung stornieren
            </input-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelForm">
              Abbrechen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
    <!-- ENDS Rechnung stornieren -->

    <!-- Notiz hinzufügen -->
    <section-form :full-width="true" v-if="!loading && noteInvoice">
      <template #form>
        <!-- Liste der Fehler -->
        <error-list :errors="errors" />

        <input-subtitle>Notiz hinzufügen</input-subtitle>

        <input-group>
          <input-container>
            <input-label name="notes" label="Notiz"></input-label>
            <input-textarea
              name="notes"
              v-model="form_notes.notes"
              placeholder="Notiz"
              ref="notes"
            ></input-textarea>
            <input-error :message="errors.notes" />
          </input-container>
        </input-group>
      </template>

      <template #actions>
        <!-- Befehle -->
        <button-group>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="addNotesToInvoice">
              Notiz hinzufügen
            </input-button>
          </smooth-scroll>
          <smooth-scroll href="#app-layout-start">
            <input-button type="button" @click.prevent="cancelForm">
              Abbrechen
            </input-button>
          </smooth-scroll>
        </button-group>
        <!-- ENDS Befehle -->
      </template>
    </section-form>
    <!-- ENDS Notiz hinzufügen -->

    <section-border></section-border>

    <invoice-show
      :full-width="true"
      :invoice="invoice"
      :invoice_items="invoice_items"
      route-invoice-display-pdf="admin.invoice.display.pdf"
      route-reminder-display-pdf="admin.reminder_invoice.display.pdf"
      route-contract-show="admin.contract.edit"
      route-invoice-show="admin.invoice.edit"
    ></invoice-show>
  </admin-layout>
</template>
<script>
import { defineComponent } from "vue";

import AdminLayout from "@/Pages/Application/Admin/Shared/Layout.vue";
import Breadcrumb from "@/Pages/Components/Breadcrumb.vue";

import SectionBorder from "@/Pages/Components/Content/SectionBorder.vue";
import SectionForm from "@/Pages/Components/Content/SectionForm.vue";

import InvoiceShow from "@/Pages/Application/Shared/InvoiceShow.vue";

import ButtonGroup from "@/Pages/Components/Form/ButtonGroup.vue";
import InputButton from "@/Pages/Components/Form/InputButton.vue";
import InputDangerButton from "@/Pages/Components/Form/InputDangerButton.vue";

import InputLoading from "@/Pages/Components/Form/InputLoading.vue";

import ErrorList from "@/Pages/Components/Form/ErrorList.vue";
import InputSubtitle from "@/Pages/Components/Form/InputSubtitle.vue";
import InputGroup from "@/Pages/Components/Form/InputGroup.vue";
import InputContainer from "@/Pages/Components/Form/InputContainer.vue";
import InputLabel from "@/Pages/Components/Form/InputLabel.vue";
import InputTextarea from "@/Pages/Components/Form/InputTextarea.vue";
import InputError from "@/Pages/Components/Form/InputError.vue";

import SmoothScroll from "@/Pages/Components/SmoothScroll.vue";

export default defineComponent({
  name: "Admin_InvoiceForm",

  components: {
    AdminLayout,
    Breadcrumb,
    SectionBorder,
    SectionForm,
    InvoiceShow,
    ButtonGroup,
    InputButton,
    InputDangerButton,
    InputLoading,
    ErrorList,
    InputSubtitle,
    InputGroup,
    InputContainer,
    InputLabel,
    InputTextarea,
    InputError,
    SmoothScroll,
  },

  props: {
    invoice: {
      type: Object,
      default: () => ({}),
    },
    invoice_items: {
      type: Object,
      default: () => ({}),
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      loading: false,
      loadingText: null,
      //
      invoiceShowing: true,
      deletingInvoice: false,
      unpayingInvoice: false,
      payingInvoice: false,
      remindingInvoice: false,
      cancellingInvoice: false,
      noteInvoice: false,
      //
      form_notes: {
        notes: this.invoice.notes,
      },
    };
  },

  methods: {
    showDeletingInvoice() {
      this.deletingInvoice = true;
      this.invoiceShowing = false;
    },

    showInvoiceUnpaidAgain() {
      this.unpayingInvoice = true;
      this.invoiceShowing = false;
    },

    showInvoiceWasPaid() {
      this.payingInvoice = true;
      this.invoiceShowing = false;
    },

    showInvoiceReminder() {
      this.remindingInvoice = true;
      this.invoiceShowing = false;
    },

    showInvoiceCancel() {
      this.cancellingInvoice = true;
      this.invoiceShowing = false;
    },

    showInvoiceNote() {
      this.noteInvoice = true;
      this.invoiceShowing = false;
    },

    cancelForm() {
      this.deletingInvoice = false;
      this.unpayingInvoice = false;
      this.payingInvoice = false;
      this.remindingInvoice = false;
      this.cancellingInvoice = false;
      this.noteInvoice = false;
      this.invoiceShowing = true;
    },

    deleteInvoice() {
      this.loading = true;
      this.loadingText = "Diese Rechnung wird gelöscht!";
      //
      this.$inertia.put(
        this.route("admin.invoice.action.deleting", this.invoice.id),
        {},
        {
          onSuccess: () => {
            this.loading = false;
            this.cancelForm();
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },

    payInvoice() {
      this.loading = true;
      this.loadingText = "Diese Rechnung wurde bezahlt!";
      //
      this.$inertia.put(
        this.route("admin.invoice.action.paying", this.invoice.id),
        {},
        {
          onSuccess: () => {
            this.loading = false;
            this.cancelForm();
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },

    unpayInvoice() {
      this.loading = true;
      this.loadingText = "Diese Rechnung wird wieder auf unbezahlt gesetzt!";
      //
      this.$inertia.put(
        this.route("admin.invoice.action.unpaying", this.invoice.id),
        {},
        {
          onSuccess: () => {
            this.loading = false;
            this.cancelForm();
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },

    remindInvoice() {
      this.loading = true;
      this.loadingText = "Für diese Rechnung wird eine Mahnung erstellt!";
      //
      this.$inertia.put(
        this.route("admin.invoice.action.reminding", this.invoice.id),
        {},
        {
          onSuccess: () => {
            this.loading = false;
            this.cancelForm();
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },

    cancelInvoice() {
      this.loading = true;
      this.loadingText =
        "Für diese Rechnung wird eine Korrekturrechnung erstellt!";
      //
      this.$inertia.put(
        this.route("admin.invoice.action.cancelling", this.invoice.id),
        {},
        {
          onSuccess: () => {
            this.loading = false;
            this.cancelForm();
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },

    addNotesToInvoice() {
      this.loading = true;
      this.loadingText =
        "Für diese Rechnung wird eine Rechnungsnotiz hinzugefügt!";
      //
      this.$inertia.put(
        this.route("admin.invoice.action.add_note", this.invoice.id),
        this.form_notes,
        {
          onSuccess: () => {
            this.loading = false;
            this.cancelForm();
          },
          onError: () => {
            this.loading = false;
          },
        }
      );
    },
  },
});
</script>

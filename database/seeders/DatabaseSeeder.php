<?php

namespace Database\Seeders;

use App\Models\Administration;
use App\Models\Blog;
use App\Models\BlogAuthor;
use App\Models\BlogCategory;
use App\Models\BlogImage;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Chat;
use App\Models\ChatType;
use App\Models\ChatUserType;
use App\Models\ContentType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceStatus;
use App\Models\InvoiceType;
use App\Models\Newsletter;
use App\Models\NewsletterMember;
use App\Models\PersonCompany;
use App\Models\Salutation;
use App\Models\User;
use App\Models\Webinar;
use App\Models\WebinarImage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        // nur in der Testumgebung
        //$this->call(TestData::class);
        // nur einmal pro Anwendung mit truncate
        $this->call(CreateWebinarImages::class);
        $this->call(WebinarData::class);
        $this->call(CreateBlogCategories::class);
        $this->call(CreateBlogImages::class);
        $this->call(CreateBlogAuthors::class);
        $this->call(CreateBlogWithMarkdownFormat::class);
        $this->call(CreateChatTypes::class);
        $this->call(CreateChatUserTypes::class);
        $this->call(CreateCountries::class);
        $this->call(CreateCurrency::class);
        $this->call(CreateInvoiceStatus::class);
        $this->call(CreateInvoiceType::class);
        $this->call(CreateBookingTypes::class);
        $this->call(CreateContentyTypes::class);
        $this->call(CreateSalutations::class);
        $this->call(NewsletterData::class);
        //
        $this->call(FirstInvoice::class);
    }
}

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create Administrator
        $user = User::create([
            'first_name' => 'Oliver',
            'last_name' => 'Reinking',
            'email' => 'oliver@codingjungle.de',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'is_admin' => true,
            'is_customer' => true,
        ]);
        //
        $person_company = PersonCompany::factory()->create([
            'is_natural_person' => false,
            'name' => 'KreativSchreiber, eine Web-Anwendung von Oliver Reinking',
            'contactperson_salutation_id' => Salutation::SALUTATION_MALE,
            'contactperson_last_name' => 'Oliver',
            'contactperson_first_name' => 'Reinking',
            'contactperson_email' => 'oliver@codingjungle.de',
        ]);
        // Create Administration
        Administration::create([
            'admin_id' => $person_company->id,
        ]);
        // Create Customer
        Customer::create([
            'customer_id' => $person_company->id,
        ]);
        //
        $user->admin_id = $person_company->id;
        $user->customer_id = $person_company->id;
        $user->save();
    }
}

class FirstInvoice extends Seeder
{
    public function run()
    {
        $net_price = 30;
        $tax_rate = 0;
        $value_added_tax = 0;
        $gross_price = 30;
        //
        $user = User::Find(1);
        $customer = $user->customer;
        $person_company = $customer->person_company;
        //
        $invoice = Invoice::create([
            'currency_id' => Currency::CURRENCY_EURO,
            'person_company_id' => $person_company->id,
            'invoice_status_id' => InvoiceStatus::INVOICE_STATUS_CREATED,
            'invoice_type_id' => InvoiceType::INVOICE_TYPE_INVOICE,
            'invoice_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14),
            'sum_net_price' => $net_price,
            'sum_value_added_tax' => $value_added_tax,
            'sum_gross_price' => $gross_price,
            'reminder_date' => null,
            'reminder_due_date' => null,
            //
            'person_company_number' => $person_company->person_company_number,
            'contactperson_salutation_id' => $person_company->contactperson_salutation_id,
            'contactperson_first_name' => $person_company->contactperson_first_name,
            'contactperson_last_name' => $person_company->contactperson_last_name,
            'billing_address' => $person_company->billing_address,
            'billing_address_line_2' => $person_company->billing_address_line_2,
            'billing_street' => $person_company->billing_street,
            'billing_country_id' => $person_company->billing_country_id,
            'billing_postcode' => $person_company->billing_postcode,
            'billing_city' => $person_company->billing_city,
            //
            'our_company_name' => config('kreativschreiber.rechnung.company_name'),
            'our_address' => config('kreativschreiber.rechnung.address'),
            'our_footer_line_1' => config('kreativschreiber.rechnung.footer_line_1'),
            'our_footer_line_2' => config('kreativschreiber.rechnung.footer_line_2'),
            'our_footer_line_3' => config('kreativschreiber.rechnung.footer_line_3'),
            'our_footer_line_4' => config('kreativschreiber.rechnung.footer_line_4'),
        ]);
        // erstelle einen Rechnungsposten für die Rechnung
        $invoice_item = InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'service_date' => Carbon::now(),
            'service_description' => 'KreativSchreiber-Punkte sind eine Währung, die verwendet wird, um Blog- und Werbetexte in der Anwendung <b>KreativSchreiber</b> zu bestellen. Jeder Punkt entspricht einem Wort.',
            'quantity' => 5000,
            'quantity_text' => 'Punkte',
            'net_price' => $net_price,
            'tax_rate' => $tax_rate,
            'value_added_tax' => $value_added_tax,
            'gross_price' => $gross_price,
        ]);
        // erstelle jetzt noch den Datensatz in bookings
        Booking::createNewBooking(
            $person_company->id,
            BookingType::BOOKING_TYPE_PUNKTEGUTSCHRIFT,
            5000,
            0,
            $invoice->id,
            null
        );
    }
}

class CreateCurrency extends Seeder
{
    public function run()
    {
        Currency::truncate();
        // Create Currency
        Currency::create([
            'id' => Currency::CURRENCY_EURO,
            'name' => 'Euro',
            'symbol' => '€',
        ]);
    }
}

class CreateInvoiceStatus extends Seeder
{
    public function run()
    {
        InvoiceStatus::truncate();
        // Create InvoiceStatus
        InvoiceStatus::create([
            'id' => InvoiceStatus::INVOICE_STATUS_CREATED,
            'name' => 'Rechnung wurde erstellt',
            'is_paid' => false,
        ]);
        // Create InvoiceStatus
        InvoiceStatus::create([
            'id' => InvoiceStatus::INVOICE_STATUS_IN_REMINDER,
            'name' => 'Rechnung befindet sich in Mahnung',
            'is_paid' => false,
        ]);
        // Create InvoiceStatus
        InvoiceStatus::create([
            'id' => InvoiceStatus::INVOICE_STATUS_PAID,
            'name' => 'Rechnung wurde bezahlt',
            'is_paid' => true,
        ]);
        // Create InvoiceStatus
        InvoiceStatus::create([
            'id' => InvoiceStatus::INVOICE_STATUS_UNPAID_AGAIN,
            'name' => 'Rechnung ist wieder unbezahlt',
            'is_paid' => false,
        ]);
        // Create InvoiceStatus
        InvoiceStatus::create([
            'id' => InvoiceStatus::INVOICE_STATUS_CANCELLED,
            'name' => 'Rechnung wurde storniert',
            'is_paid' => true,
        ]);
    }
}

class CreateInvoiceType extends Seeder
{
    public function run()
    {
        InvoiceType::truncate();
        // Create InvoiceType
        InvoiceType::create([
            'id' => InvoiceType::INVOICE_TYPE_INVOICE,
            'name' => 'Rechnung an das Unternehmen',
        ]);
        // Create InvoiceType
        InvoiceType::create([
            'id' => InvoiceType::INVOICE_TYPE_REIMBURSEMENT,
            'name' => 'Erstattung an das Unternehmen',
        ]);
        // Create InvoiceType
        InvoiceType::create([
            'id' => InvoiceType::INVOICE_TYPE_CORRECTION_INVOICE,
            'name' => 'Korrekturrechnung',
        ]);
    }
}

class CreateBookingTypes extends Seeder
{
    public function run()
    {
        BookingType::truncate();
        // Create BookingType
        BookingType::create([
            'id' => BookingType::BOOKING_TYPE_TEXTERSTELLUNG,
            'name' => 'Texterstellung',
            'sign' => -1,
        ]);
        // Create BookingType
        BookingType::create([
            'id' => BookingType::BOOKING_TYPE_PUNKTEAUFFÜLLUNG,
            'name' => 'Punkteauffüllung',
            'sign' => 1,
        ]);
        // Create BookingType
        BookingType::create([
            'id' => BookingType::BOOKING_TYPE_PUNKTEGUTSCHRIFT,
            'name' => 'Punktegutschrift',
            'sign' => 1,
        ]);
        // Create BookingType
        BookingType::create([
            'id' => BookingType::BOOKING_TYPE_PUNKTESTORNO,
            'name' => 'Punktestorno',
            'sign' => -1,
        ]);
    }
}

class CreateContentyTypes extends Seeder
{
    public function run()
    {
        ContentType::truncate();
        // Create ContentType
        ContentType::create([
            'id' => ContentType::CONTENT_TYPE_WERBETEXT,
            'name' => 'Werbetext',
        ]);
        // Create ContentType
        ContentType::create([
            'id' => ContentType::CONTENT_TYPE_BLOGTEXT,
            'name' => 'Blogtext',
        ]);
    }
}

class CreateSalutations extends Seeder
{
    public function run()
    {
        Salutation::truncate();
        // Create Salutation
        Salutation::create([
            'id' => 1,
            'name' => 'Herr',
        ]);
        // Create Salutation
        Salutation::create([
            'id' => 2,
            'name' => 'Frau',
        ]);
        // Create Salutation
        Salutation::create([
            'id' => 3,
            'name' => 'Weitere',
        ]);
    }
}

class CreateCountries extends Seeder
{
    public function run()
    {
        Country::truncate();
        // Create Country
        Country::create([
            'id' => 1,
            'name' => 'Deutschland',
        ]);
        // Create Country
        Country::create([
            'id' => 2,
            'name' => 'Frankreich',
        ]);
        // Create Country
        Country::create([
            'id' => 3,
            'name' => 'Schweiz',
        ]);
        // Create Country
        Country::create([
            'id' => 4,
            'name' => 'Dänemark',
        ]);
        // Create Country
        Country::create([
            'id' => 5,
            'name' => 'Niederlande',
        ]);
        // Create Country
        Country::create([
            'id' => 6,
            'name' => 'Belgien',
        ]);
        // Create Country
        Country::create([
            'id' => 7,
            'name' => 'Italien',
        ]);
        // Create Country
        Country::create([
            'id' => 8,
            'name' => 'Polen',
        ]);
        // Create Country
        Country::create([
            'id' => 9,
            'name' => 'Spanien',
        ]);
        // Create Country
        Country::create([
            'id' => 10,
            'name' => 'Portugal',
        ]);
        // Create Country
        Country::create([
            'id' => 11,
            'name' => 'Monaco',
        ]);
        // Create Country
        Country::create([
            'id' => 12,
            'name' => 'Österreich',
        ]);
        // Create Country
        Country::create([
            'id' => 13,
            'name' => 'Griechenland',
        ]);
        // Create Country
        Country::create([
            'id' => 14,
            'name' => 'Finnland',
        ]);
        // Create Country
        Country::create([
            'id' => 15,
            'name' => 'Luxemburg',
        ]);
        // Create Country
        Country::create([
            'id' => 16,
            'name' => 'Liechtenstein',
        ]);
        // Create Country
        Country::create([
            'id' => 17,
            'name' => 'Vereinigtes Königreich',
        ]);
        // Create Country
        Country::create([
            'id' => 18,
            'name' => 'Irland',
        ]);
        // Create Country
        Country::create([
            'id' => 19,
            'name' => 'Tschechien',
        ]);
        // Create Country
        Country::create([
            'id' => 20,
            'name' => 'Türkei',
        ]);
    }
}

class CreateWebinarImages extends Seeder
{
    public function run()
    {
        WebinarImage::truncate();
        // Create WebinarImage
        WebinarImage::create([
            'id' => 1,
            'name' => 'Mann am Schreibtisch',
            'url' => '/images/webinarimages/Webinar_Mann_Schreibtisch.jpg',
        ]);
        // Create WebinarImage
        WebinarImage::create([
            'id' => 2,
            'name' => 'Laptops',
            'url' => '/images/webinarimages/Webinar_Laptops.jpg',
        ]);
        // Create WebinarImage
        WebinarImage::create([
            'id' => 3,
            'name' => 'Laptop A',
            'url' => '/images/webinarimages/Webinar_Laptop_A.jpg',
        ]);
        // Create WebinarImage
        WebinarImage::create([
            'id' => 4,
            'name' => 'Laptop B',
            'url' => '/images/webinarimages/Webinar_Laptop_B.jpg',
        ]);
        // Create WebinarImage
        WebinarImage::create([
            'id' => 5,
            'name' => 'Laptop C',
            'url' => '/images/webinarimages/Webinar_Laptop_C.jpg',
        ]);
        // Create WebinarImage
        WebinarImage::create([
            'id' => 6,
            'name' => 'Laptop D',
            'url' => '/images/webinarimages/Webinar_Laptop_D.jpg',
        ]);
    }
}

class CreateBlogCategories extends Seeder
{
    public function run()
    {
        BlogCategory::truncate();
        // Create BlogCategory
        BlogCategory::create([
            'id' => 1,
            'name' => 'KreativSchreiber',
        ]);
        // Create BlogCategory
        BlogCategory::create([
            'id' => 2,
            'name' => 'Tipps und Tricks',
        ]);
        // Create BlogCategory
        BlogCategory::create([
            'id' => 3,
            'name' => 'Erfolgsgeschichten',
        ]);
        // Create BlogCategory
        BlogCategory::create([
            'id' => 4,
            'name' => 'Werbetexte',
        ]);
        // Create BlogCategory
        BlogCategory::create([
            'id' => 5,
            'name' => 'Blogtexte',
        ]);
    }
}

class CreateBlogImages extends Seeder
{
    public function run()
    {
        BlogImage::truncate();
        // Create BlogImage
        BlogImage::create([
            'id' => 1,
            'name' => 'moderne Bibliothek',
            'url' => '/images/blogimages/Blog_Bibliothek_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 2,
            'name' => 'Karteikartenschrank',
            'url' => '/images/blogimages/Blog_Karteikartenschrank_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 3,
            'name' => 'Plan',
            'url' => '/images/blogimages/Blog_Plan_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 4,
            'name' => 'Computerbildschirm mit Code',
            'url' => '/images/blogimages/Blog_Screen_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 5,
            'name' => 'Sonne',
            'url' => '/images/blogimages/Blog_Sonne_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 6,
            'name' => 'Autobahnkreuz',
            'url' => '/images/blogimages/Blog_Autobahnkreuz_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 7,
            'name' => 'Containerhafen',
            'url' => '/images/blogimages/Blog_Containerhafen_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 8,
            'name' => 'Idee',
            'url' => '/images/blogimages/Blog_Idee_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 9,
            'name' => 'Posts',
            'url' => '/images/blogimages/Blog_Posts_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 10,
            'name' => 'Schrankwand',
            'url' => '/images/blogimages/Blog_Schrankwand_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 11,
            'name' => 'Tasse',
            'url' => '/images/blogimages/Blog_Tasse_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 12,
            'name' => 'Warenlager',
            'url' => '/images/blogimages/Blog_Warenlager_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 13,
            'name' => '4 Personen',
            'url' => '/images/blogimages/Blog_Vier_Personen_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 14,
            'name' => '2 Personen',
            'url' => '/images/blogimages/Blog_Zwei_Personen_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 15,
            'name' => 'Laptop auf Tisch',
            'url' => '/images/blogimages/Blog_Laptop_auf_Tisch_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 16,
            'name' => 'Laptop auf Beinen',
            'url' => '/images/blogimages/Blog_Laptop_auf_Beinen_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 17,
            'name' => 'Read more',
            'url' => '/images/blogimages/Blog_Read_More_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 18,
            'name' => 'Laptop auf dem Bett',
            'url' => '/images/blogimages/Blog_Latop_auf_dem_Bett_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 19,
            'name' => 'Laptop auf dem Schreibtisch',
            'url' => '/images/blogimages/Blog_Latop_auf_dem_Schreibtisch_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 20,
            'name' => 'Schreibutensilien',
            'url' => '/images/blogimages/Blog_Schreibutensilien_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 21,
            'name' => 'Texter',
            'url' => '/images/blogimages/Blog_Copywriter_Alien_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 22,
            'name' => 'Texter',
            'url' => '/images/blogimages/Blog_Copywriter_Man_Purple_Room_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 23,
            'name' => 'Texter',
            'url' => '/images/blogimages/Blog_Copywriter_Man_Red_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 24,
            'name' => 'Texter',
            'url' => '/images/blogimages/Blog_Copywriter_Salvadore_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 25,
            'name' => 'Texter',
            'url' => '/images/blogimages/Blog_Copywriter_Woman_Desk_480x360.jpg',
        ]);
        // Create BlogImage
        BlogImage::create([
            'id' => 26,
            'name' => 'Texter',
            'url' => '/images/blogimages/Blog_Copywriter_Woman_Standing_480x360.jpg',
        ]);
          // Create BlogImage
          BlogImage::create([
            'id' => 27,
            'name' => 'Architektur',
            'url' => '/images/blogimages/Blog_Architecture_Zaha_Hadid_480x360.jpg',
        ]);
    }
}

class CreateBlogAuthors extends Seeder
{
    public function run()
    {
        BlogAuthor::truncate();
        // Create BlogAuthor
        BlogAuthor::create([
            'id' => 1,
            'name' => 'Oliver Reinking',
            'info' => 'Oliver Reinking ist Mathematiker und Softwareentwickler mit dem Schwerpunkt Web-Anwendungen.<br />
            Er wurde 1963 in Lübeck geboren und lebt heute in Zweibrücken.<br />
            In seiner Freizeit entwickelt er Web-Anwendungen mit Laravel, Vue.js und Tailwind CSS.<br />
            Er hat auch mehrere Sachbücher veröffentlicht, die sich mit der Nutzung dieser Technologien beschäftigen.<br />
            Ende 2022 hat Oliver beschlossen, die Web-Anwendung KreativSchreiber zur Erstellung von Werbe- und Blogtexten mit Hilfe des ChatGPT zu entwickeln.<br />
            Er hofft, dass KreativSchreiber Unternehmen dabei helfen wird, ihre Online-Präsenz zu stärken und ihre Marketingkampagnen zu verbessern.',
        ]);
    }
}

class CreateChatTypes extends Seeder
{
    public function run()
    {
        ChatType::truncate();
        // Create ChatType
        ChatType::create([
            'id' => ChatType::ChatType_normaleNachricht,
            'name' => 'normale Chat-Nachricht',
        ]);
    }
}

class CreateChatUserTypes extends Seeder
{
    public function run()
    {
        ChatUserType::truncate();
        // Create ChatUserType
        ChatUserType::create([
            'id' => ChatUserType::ChatUserType_Customer,
            'name' => 'Kunde',
        ]);
        // Create ChatUserType
        ChatUserType::create([
            'id' => ChatUserType::ChatUserType_Administrator,
            'name' => 'Administrator',
        ]);
    }
}

// Blogartikel im Markdown-Format
class CreateBlogWithMarkdownFormat extends Seeder
{
    public function run()
    {
        // für den ersten Artikel setze markdown_on auf true
        $blog_author_id = 1;
        $blog_image_id = 21;
        $blog_category_id = 1;
        $title = "Die Anwendung KreativSchreiber";
        $summary = "Unsere Anwendung bietet professionelle Unterstützung bei der Erstellung von Blog- und Werbetexten für Unternehmen, Werbeagenturen und Einzelpersonen. Nutzen Sie unseren Service für erfolgreiche Blog-Beiträge und Werbekampagnen.";
        $blog_date = Carbon::now()->subDays(28);
        $reading_time = 3;
        //
        Blog::create([
            'blog_author_id' => $blog_author_id,
            'blog_image_id' => $blog_image_id,
            'blog_category_id' => $blog_category_id,
            'title' => $title,
            'summary' => $summary,
            'blog_date' => $blog_date,
            'content' => null,
            'reading_time' => $reading_time,
            'markdown_on' => true,
            'audio_on' => true,
            'audio_url' => '/audio/blogs/blog_1.mp3',
            'audio_duration' => 87,
        ]);
        // für den zweiten Artikel setze markdown_on auf true
        $blog_author_id = 1;
        $blog_image_id = 22;
        $blog_category_id = 5;
        $title = "Die Bedeutung von Blogs";
        $summary = "Ein Blog ist eine Plattform, auf der Unternehmen ihre Gedanken, Meinungen und Neuigkeiten mit ihren Lesern teilen können und hilft dabei, Traffic auf der Unternehmenswebsite zu generieren, das Vertrauen der Leser zu stärken und das Suchmaschinenranking zu verbessern. Regelmäßige Veröffentlichung von interessanten und relevanten Inhalten ist entscheidend. Ein Blog ist ein wichtiges Marketinginstrument für Unternehmen.";
        $blog_date = Carbon::now()->subDays(21);
        $reading_time = 3;
        //
        Blog::create([
            'blog_author_id' => $blog_author_id,
            'blog_image_id' => $blog_image_id,
            'blog_category_id' => $blog_category_id,
            'title' => $title,
            'summary' => $summary,
            'blog_date' => $blog_date,
            'content' => null,
            'reading_time' => $reading_time,
            'markdown_on' => true,
            'audio_on' => true,
            'audio_url' => '/audio/blogs/blog_2.mp3',
            'audio_duration' => 185,
        ]);
        // für den dritten Artikel setze markdown_on auf true
        $blog_author_id = 1;
        $blog_image_id = 23;
        $blog_category_id = 4;
        $title = "Bedeutung von Werbetexten in Online-Shops";
        $summary = "Werbetexte in Online-Shops sind wichtig, um das Interesse der Kunden zu wecken und sie zum Kauf zu bewegen. Sie sollten die Vorteile und USPs eines Produkts hervorheben und zeigen, wie es das Leben der Kunden verbessern kann. Sie sollten gut strukturiert, leicht verständlich, kurz und prägnant sein und einen ansprechenden Schreibstil und eine gute Lesbarkeit aufweisen.";
        $blog_date = Carbon::now()->subDays(14);
        $reading_time = 3;
        //
        Blog::create([
            'blog_author_id' => $blog_author_id,
            'blog_image_id' => $blog_image_id,
            'blog_category_id' => $blog_category_id,
            'title' => $title,
            'summary' => $summary,
            'blog_date' => $blog_date,
            'content' => null,
            'reading_time' => $reading_time,
            'markdown_on' => true,
            'audio_on' => true,
            'audio_url' => '/audio/blogs/blog_3.mp3',
            'audio_duration' => 89,
        ]);
         // für den vierten Artikel setze markdown_on auf true
         $blog_author_id = 1;
         $blog_image_id = 27;
         $blog_category_id = 5;
         $title = "Wer war Zaha Hadid?";
         $summary = "Der KreativSchreiber hat diesen Text geschrieben. Er handelt von der Architektin Zaha Hadid und zeigt, dass der KreativSchreiber hochwertige Texte liefern kann.";
         $blog_date = Carbon::now()->subDays(7);
         $reading_time = 3;
         //
         Blog::create([
             'blog_author_id' => $blog_author_id,
             'blog_image_id' => $blog_image_id,
             'blog_category_id' => $blog_category_id,
             'title' => $title,
             'summary' => $summary,
             'blog_date' => $blog_date,
             'content' => null,
             'reading_time' => $reading_time,
             'markdown_on' => true,
             'audio_on' => false,
             'audio_url' => null,
             'audio_duration' => null,
         ]);
    }
}

class WebinarData extends Seeder
{
    public function run()
    {
        // Lege 1 Webinar an
        $event_date = Carbon::now()->addMinutes(rand(1000, 1000000));
        $event_start = "16:00 Uhr";
        $webinar_image_id = rand(1, 6);
        //
        $description = "Willkommen zu unserem Webinar über die revolutionäre Anwendung <b>KreativSchreiber</b> von Oliver Reinking!<br />";
        $description .= "In diesem Webinar wirst du lernen, wie du die Anwendung KreativSchreiber nutzen kannst, um professionelle Werbe- und Blogtexte zu erstellen, die deine Online-Präsenz stärken und Ihre Marketingkampagnen verbessern.<br />";
        $description .= "<br />";
        $description .= "Oliver Reinking, Mathematiker und Softwareentwickler mit jahrelanger Erfahrung im Bereich Web-Anwendungen, wird dir in diesem Webinar alle Details zur Anwendung vorstellen. <br />";
        $description .= "Er wird dir zeigen, wie du die leistungsstarken Funktionen von ChatGPT nutzen kannst, um hochwertige Texte zu erstellen, die deine Zielgruppe ansprechen und deine Markenbotschaft vermitteln.<br />";
        $description .= "<br />";
        $description .= "Dieses Webinar ist der perfekte Einstieg in die Welt der professionellen Texterstellung und eine großartige Gelegenheit, mehr über unsere Anwendung <b>KreativSchreiber</b> zu erfahren. <br />";
        $description .= "Melde dich jetzt an und lerne, wie du deine Online-Präsenz mit der Anwendung stärken kannst.<br />";
        //
        Webinar::create([
            'company_id' => Administration::ADMIN_KREATIVSCHREIBER_ID,
            'webinar_image_id' => $webinar_image_id,
            'event_date' => $event_date,
            'event_start' => $event_start,
            'title' => 'Erstelle professionelle Werbe- und Blogtexte mit unserer Anwendung KreativSchreiber',
            'description' => $description,
            'access' => config('app.url') . '/webinar/1',
        ]);
    }
}

class NewsletterData extends Seeder
{
    public function run()
    {
        Newsletter::truncate();
        // Create Newsletter
        Newsletter::create([
            'id' => Newsletter::Newsletter_Platform,
            'name' => 'Plattform ' . config('kreativschreiber.platform.name'),
            'description' => 'In diesem Newsletter berichten wir über die Plattform ' . config('kreativschreiber.platform.name') . '.',
        ]);
        //
        NewsletterMember::factory()->times(200)->create(
            [
                'newsletter_id' => Newsletter::Newsletter_Platform,
            ]
        );
    }
}

class TestData extends Seeder
{
    public function run()
    {
        // Lege 1500 Anwender an
        User::factory()->times(1500)->create();
        // --------------------
        // durchlaufe alle User
        // --------------------
        // Der Anwender sollte kein Administrator sein!
        $users = User::where('is_admin', false)->get();
        //
        foreach ($users as $user) {
            // -------------------------------------
            // Ist User einer Person zugeordnet?
            // Ist User also ein Kunde
            // -------------------------------------
            $zufall_person = random_int(1, 100);
            //
            if ($zufall_person < 96) {
                //
                $person_company = PersonCompany::factory()->create([
                    'is_natural_person' => false,
                    'name' => $user->full_name,
                    'contactperson_salutation_id' => Salutation::SALUTATION_DIVERS,
                    'contactperson_last_name' => $user->last_name,
                    'contactperson_first_name' => $user->first_name,
                    'contactperson_phone' => null,
                    'contactperson_email' => $user->email,
                ]);
                //
                $user->is_customer = true;
                $user->customer_id = $person_company->id;
                $user->save();
            }
        }
        // Lege 2000 Chatnachrichten an
        Chat::factory()->times(2000)->create();
    }
}

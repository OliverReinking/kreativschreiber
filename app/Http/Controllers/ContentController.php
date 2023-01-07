<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreateContentAdvertising;
use App\Http\Requests\RequestCreateContentBlog;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Content;
use App\Models\ContentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ContentController extends Controller
{
    // ====================
    // APPLICATION CUSTOMER
    // ====================
    public function customer_content_index($filter_read = "all")
    {
        $user = Auth::user();
        //
        $customer_id = $user->customer_id;
        //
        $contents = Content::select(
            'contents.id as id',
            'contents.creation_date as creation_date',
            'contents.summary as summary',
            'content_types.name as content_type_name',
        )
            ->join('content_types', 'content_types.id', '=', 'contents.content_type_id')
            ->filterContent(Request::only('search'))
            ->where('contents.person_company_id', '=', $customer_id)
            //
            ->where(function ($q) use ($filter_read) {
                if ($filter_read == "advertising") {
                    $q->where('contents.content_type_id', '=', ContentType::CONTENT_TYPE_WERBETEXT);
                }
                if ($filter_read == "blog") {
                    $q->where('contents.content_type_id', '=', ContentType::CONTENT_TYPE_BLOGTEXT);
                }
            })
            //
            ->orderBy('creation_date', 'desc')
            ->paginate(10)
            ->withQueryString();
        //
        $filterContentsText = null;
        //
        if ($filter_read == "advertising") {
            $filterContentsText = "Es werden nur Werbetexte angezeigt.";
        }
        if ($filter_read == "blog") {
            $filterContentsText = "Es werden nur Blogtexte angezeigt.";
        }
        //
        return Inertia::render('Application/Customer/ContentList', [
            'filters' => Request::all('search'),
            'filterContentsText' => $filterContentsText,
            'contents' => $contents,
        ]);
    }
    //
    public function customer_content_show(Content $content)
    {
        $user = Auth::user();
        //
        $customer = $user->customer;
        //
        if (!$user->can('customer_crud_content', $content)) {
            $message = "Du besitzt leider nicht die notwendigen Kompetenzen, um diesen Content anzuzeigen.";
            return Inertia::render('Application/Customer/NoPermission', [
                'message' => $message,
            ]);
        }
        //
        if ($content->content_type_id == ContentType::CONTENT_TYPE_WERBETEXT) {
            // übernehme Werte aus content nach customer
            $customer->adv_offer = $content->adv_offer;
            $customer->adv_number_of_words = $content->adv_number_of_words;
            $customer->adv_writing_style_persuasive = $content->adv_writing_style_persuasive;
            $customer->adv_writing_style_emotional = $content->adv_writing_style_emotional;
            $customer->adv_writing_style_enlightening = $content->adv_writing_style_enlightening;
            $customer->adv_writing_style_humorous = $content->adv_writing_style_humorous;
            $customer->adv_writing_style_provocative = $content->adv_writing_style_provocative;
            $customer->adv_gender_female = $content->adv_gender_female;
            $customer->adv_gender_male = $content->adv_gender_male;
            $customer->adv_gender_divers = $content->adv_gender_divers;
            $customer->adv_age_strata_children = $content->adv_age_strata_children;
            $customer->adv_age_strata_young = $content->adv_age_strata_young;
            $customer->adv_age_strata_adults = $content->adv_age_strata_adults;
            $customer->adv_age_strata_seniors = $content->adv_age_strata_seniors;
            $customer->adv_interest_groups = $content->adv_interest_groups;
            $customer->adv_professional_groups = $content->adv_professional_groups;
            $customer->adv_lifestyle = $content->adv_lifestyle;
            //
            $customer->save();
            //
            return Inertia::render('Application/Customer/ContentAdvertisingShow', [
                'content' => $content,
            ]);
        }
        //
        if ($content->content_type_id == ContentType::CONTENT_TYPE_BLOGTEXT) {
            // übernehme Werte aus content nach customer
            $customer->blog_topic = $content->blog_topic;
            $customer->blog_number_of_words = $content->blog_number_of_words;
            $customer->blog_writing_style_personal = $content->blog_writing_style_personal;
            $customer->blog_writing_style_objective = $content->blog_writing_style_objective;
            $customer->blog_writing_style_opinionated = $content->blog_writing_style_opinionated;
            $customer->blog_writing_style_entertaining = $content->blog_writing_style_entertaining;
            $customer->blog_writing_style_creative = $content->blog_writing_style_creative;
            $customer->blog_gender_female = $content->blog_gender_female;
            $customer->blog_gender_male = $content->blog_gender_male;
            $customer->blog_gender_divers = $content->blog_gender_divers;
            $customer->blog_age_strata_children = $content->blog_age_strata_children;
            $customer->blog_age_strata_young = $content->blog_age_strata_young;
            $customer->blog_age_strata_adults = $content->blog_age_strata_adults;
            $customer->blog_age_strata_seniors = $content->blog_age_strata_seniors;
            $customer->blog_interest_groups = $content->blog_interest_groups;
            $customer->blog_professional_groups = $content->blog_professional_groups;
            $customer->blog_lifestyle = $content->blog_lifestyle;
            //
            $customer->save();
            //
            return Inertia::render('Application/Customer/ContentBlogShow', [
                'content' => $content,
            ]);
        }
        //
        $message = "Der Text kann nicht angezeigt werden, da der Formattyp unbekannt ist.";
        return Inertia::render('Application/Customer/NoPermission', [
            'message' => $message,
        ]);
    }
    //
    public function customer_content_advertising_create()
    {
        $user = Auth::user();
        //
        $customer = $user->customer;
        //
        $content = new Content;
        //
        $content->offer = $customer->adv_offer;
        //
        $content->number_of_words = $customer->adv_number_of_words;
        //
        $content->writing_style_persuasive = $customer->adv_writing_style_persuasive;
        $content->writing_style_emotional = $customer->adv_writing_style_emotional;
        $content->writing_style_enlightening = $customer->adv_writing_style_enlightening;
        $content->writing_style_humorous = $customer->adv_writing_style_humorous;
        $content->writing_style_provocative = $customer->adv_writing_style_provocative;
        //
        $content->age_strata_children = $customer->adv_age_strata_children;
        $content->age_strata_young = $customer->adv_age_strata_young;
        $content->age_strata_adults = $customer->adv_age_strata_adults;
        $content->age_strata_seniors = $customer->adv_age_strata_seniors;
        //
        $content->gender_female = $customer->adv_gender_female;
        $content->gender_male = $customer->adv_gender_male;
        $content->gender_divers = $customer->adv_gender_divers;
        //
        $content->interest_groups = $customer->adv_interest_groups;
        //
        $content->professional_groups = $customer->adv_professional_groups;
        //
        $content->lifestyle = $customer->adv_lifestyle;
        //
        return Inertia::render('Application/Customer/ContentAdvertisingForm', [
            'content' => $content,
        ]);
    }
    //
    public function customer_content_advertising_store(RequestCreateContentAdvertising $request)
    {
        $user = Auth::user();
        //
        $customer_id = $user->customer_id;
        //
        $offer = $request->offer;
        //
        $number_of_words = (int) $request->number_of_words;
        // prüfe, ob der Kunden genügend KreativSchreiber-Punkte besitzt
        $check = Booking::checkPoints($number_of_words, $customer_id);
        //
        if ($check->errorOn) {
            return Redirect::route('customer.content.advertising.create')
                ->with([
                    'error' => $check->errorMessage,
                ]);
        }
        //
        $writing_style_persuasive = $request->writing_style_persuasive;
        $writing_style_emotional = $request->writing_style_emotional;
        $writing_style_enlightening = $request->writing_style_enlightening;
        $writing_style_humorous = $request->writing_style_humorous;
        $writing_style_provocative = $request->writing_style_provocative;
        // ermittle die Anzahl der gewünschten Schreibstile
        $count_writing_style = 0;
        $writing_styles = null;
        if ($writing_style_persuasive) {
            if ($count_writing_style == 0) {
                $writing_styles .= "überzeugend";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und überzeugend";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_emotional) {
            if ($count_writing_style == 0) {
                $writing_styles .= "emotioanl";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und emotional";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_enlightening) {
            if ($count_writing_style == 0) {
                $writing_styles .= "aufklärend";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und aufklärend";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_humorous) {
            if ($count_writing_style == 0) {
                $writing_styles .= "provokativ";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und provokativ";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_provocative) {
            if ($count_writing_style == 0) {
                $writing_styles .= "humorvoll";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und humorvoll";
            }
            $count_writing_style += 1;
        }
        // validiere count_writing_style
        if ($count_writing_style == 0) {
            return Redirect::route('customer.content.advertising.create')
                ->with([
                    'error' => 'Du musst mindestens einen Schreibstil auswählen.',
                ]);
        }
        //
        $gender_female = $request->gender_female;
        $gender_male = $request->gender_male;
        $gender_divers = $request->gender_divers;
        // ermittle die Anzahl der gewünschten Geschlechter
        $count_gender = 0;
        if ($gender_female) {
            $count_gender += 1;
        }
        if ($gender_male) {
            $count_gender += 1;
        }
        if ($gender_divers) {
            $count_gender += 1;
        }
        // validiere count_gender
        if ($count_gender > 1) {
            return Redirect::route('customer.content.advertising.create')
                ->with([
                    'error' => 'Du darfst maximal ein Geschlecht auswählen.',
                ]);
        }
        //
        $age_strata_children = $request->age_strata_children;
        $age_strata_young = $request->age_strata_young;
        $age_strata_adults = $request->age_strata_adults;
        $age_strata_seniors = $request->age_strata_seniors;
        // ermittle die Anzahl der gewünschten Altersschichten
        $count_age_strata = 0;
        if ($age_strata_children) {
            $count_age_strata += 1;
        }
        if ($age_strata_young) {
            $count_age_strata += 1;
        }
        if ($age_strata_adults) {
            $count_age_strata += 1;
        }
        if ($age_strata_seniors) {
            $count_age_strata += 1;
        }
        // validiere count_age_strata
        if ($count_age_strata > 1) {
            return Redirect::route('customer.content.advertising.create')
                ->with([
                    'error' => 'Du darfst maximal eine Altersschicht auswählen.',
                ]);
        }
        //
        $interest_groups = $request->interest_groups;
        //
        $professional_groups = $request->professional_groups;
        //
        $lifestyle = $request->lifestyle;
        // Baue Prompt zusammen
        $prompt = "Erstelle einen Werbetext<br />";
        //
        $prompt .= "Angebot: " . $offer . "<br />";
        //
        if ($count_writing_style == 1) {
            $prompt .= "Bitte verwende für den Werbetext folgenden Schreibstil: " . $writing_styles . "<br />";
        }
        if ($count_writing_style > 1) {
            $prompt .= "Bitte verwende für den Werbetext folgende Schreibstile: " . $writing_styles . "<br />";
        }
        //
        if ($gender_female && !$gender_male && !$gender_divers) {
            $prompt .= "Dieser Werbetext richtet sich an Frauen.<br />";
        }
        //
        if (!$gender_female && $gender_male && !$gender_divers) {
            $prompt .= "Dieser Werbetext richtet sich an Männer.<br />";
        }
        //
        if (!$gender_female && !$gender_male && $gender_divers) {
            $prompt .= "Dieser Werbetext richtet sich an Menschen mit dem Geschlecht divers.<br />";
        }
        //
        if ($age_strata_children && !$age_strata_young && !$age_strata_adults && !$age_strata_seniors) {
            $prompt .= "Dieser Werbetext richtet sich an Kinder.<br />";
        }
        //
        if (!$age_strata_children && $age_strata_young && !$age_strata_adults && !$age_strata_seniors) {
            $prompt .= "Dieser Werbetext richtet sich an Jugendliche.<br />";
        }
        //
        if (!$age_strata_children && !$age_strata_young && $age_strata_adults && !$age_strata_seniors) {
            $prompt .= "Dieser Werbetext richtet sich an Erwachsende.<br />";
        }
        //
        if (!$age_strata_children && !$age_strata_young && !$age_strata_adults && $age_strata_seniors) {
            $prompt .= "Dieser Werbetext richtet sich an Senioren.<br />";
        }
        //
        if ($interest_groups) {
            $prompt .= "Erstelle den Werbetext für die folgende Interessengruppe: " . $interest_groups . "<br />";
        }
        //
        if ($professional_groups) {
            $prompt .= "Erstelle den Werbetext für die folgende Berufsgruppe: " . $professional_groups . "<br />";
        }
        //
        if ($lifestyle) {
            $prompt .= "Erstelle den Werbetext für den folgende Lifestyle: " . $lifestyle . "<br />";
        }
        // ----------------------
        // erstelle den Werbetext
        // ----------------------
        $result = Content::createAdvertisementText($prompt, $number_of_words);
        //
        // ermittle die Anzahl der Wörter
        $word_count = str_word_count(Wandle_Sonderzeichen($result->content));
        // ermittle die Anzahl der Wörter, die mit dem Kunden abgerechnet werden.
        $word_count_transaction = $number_of_words;
        if ($word_count < $number_of_words) {
            $word_count_transaction = $word_count;
        }
        //
        $content = Content::Create([
            'person_company_id' => $customer_id,
            'content_type_id' => ContentType::CONTENT_TYPE_WERBETEXT,
            'creation_date' => Carbon::now(),
            'number_of_words' => $number_of_words,
            'prompt' => $prompt,
            'summary' => $result->summary,
            'content' => $result->content,
            //
            'adv_offer' => $offer,
            'adv_number_of_words' => $number_of_words,
            'adv_writing_style_persuasive' => $writing_style_persuasive,
            'adv_writing_style_emotional' => $writing_style_emotional,
            'adv_writing_style_enlightening' => $writing_style_enlightening,
            'adv_writing_style_humorous' => $writing_style_humorous,
            'adv_writing_style_provocative' => $writing_style_provocative,
            'adv_gender_female' => $gender_female,
            'adv_gender_male' => $gender_male,
            'adv_gender_divers' => $gender_divers,
            'adv_age_strata_children' => $age_strata_children,
            'adv_age_strata_young' => $age_strata_young,
            'adv_age_strata_adults' => $age_strata_adults,
            'adv_age_strata_seniors' => $age_strata_seniors,
            'adv_interest_groups' => $interest_groups,
            'adv_professional_groups' => $professional_groups,
            'adv_lifestyle' => $lifestyle,
        ]);
        // erstelle jetzt noch den Datensatz in bookings
        Booking::createNewBooking(
            $customer_id,
            BookingType::BOOKING_TYPE_TEXTERSTELLUNG,
            $word_count_transaction,
            $content->id,
            0,
            null
        );
        //
        $success = "Der Werbetext wurde erstellt und es wurden " . formatNumber($word_count) . " Wörter verwendet.<br />";
        $success .= "Du hattest eine Länge von " . formatNumber($number_of_words) . " Wörtern vorgegeben.<br />";
        $success .= "Deinem Punktekonto wurden daher " . formatNumber($word_count_transaction) . " KreativSchreiber-Punkte abgezogen.<br />";
        //
        return Redirect::route('customer.content.show', $content->id)
            ->with(['success' => $success]);
    }
    //
    public function customer_content_blog_create()
    {
        $user = Auth::user();
        //
        $customer = $user->customer;
        //
        $content = new Content;
        //
        $content->topic = $customer->blog_topic;
        //
        $content->number_of_words = $customer->blog_number_of_words;
        //
        $content->writing_style_personal = $customer->blog_writing_style_personal;
        $content->writing_style_objective = $customer->blog_writing_style_objective;
        $content->writing_style_opinionated = $customer->blog_writing_style_opinionated;
        $content->writing_style_entertaining = $customer->blog_writing_style_entertaining;
        $content->writing_style_creative = $customer->blog_writing_style_creative;
        //
        $content->age_strata_children = $customer->blog_age_strata_children;
        $content->age_strata_young = $customer->blog_age_strata_young;
        $content->age_strata_adults = $customer->blog_age_strata_adults;
        $content->age_strata_seniors = $customer->blog_age_strata_seniors;
        //
        $content->gender_female = $customer->blog_gender_female;
        $content->gender_male = $customer->blog_gender_male;
        $content->gender_divers = $customer->blog_gender_divers;
        //
        $content->interest_groups = $customer->blog_interest_groups;
        //
        $content->professional_groups = $customer->blog_professional_groups;
        //
        $content->lifestyle = $customer->blog_lifestyle;
        //
        return Inertia::render('Application/Customer/ContentBlogForm', [
            'content' => $content,
        ]);
    }
    //
    public function customer_content_blog_store(RequestCreateContentBlog $request)
    {
        $user = Auth::user();
        //
        $customer_id = $user->customer_id;
        //
        $topic = $request->topic;
        //
        $number_of_words = (int) $request->number_of_words;
        // prüfe, ob der Kunden genügend KreativSchreiber-Punkte besitzt
        $check = Booking::checkPoints($number_of_words, $customer_id);
        //
        if ($check->errorOn) {
            return Redirect::route('customer.content.blog.create')
                ->with([
                    'error' => $check->errorMessage,
                ]);
        }
        //
        $writing_style_personal = $request->writing_style_personal;
        $writing_style_objective = $request->writing_style_objective;
        $writing_style_opinionated = $request->writing_style_opinionated;
        $writing_style_entertaining = $request->writing_style_entertaining;
        $writing_style_creative = $request->writing_style_creative;
        // ermittle die Anzahl der gewünschten Schreibstile
        $count_writing_style = 0;
        $writing_styles = null;
        if ($writing_style_personal) {
            if ($count_writing_style == 0) {
                $writing_styles .= "persönlich";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und persönlich";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_objective) {
            if ($count_writing_style == 0) {
                $writing_styles .= "objektiv";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und j";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_opinionated) {
            if ($count_writing_style == 0) {
                $writing_styles .= "meinungsstark";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und meinungsstark";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_entertaining) {
            if ($count_writing_style == 0) {
                $writing_styles .= "unterhaltend";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und unterhaltend";
            }
            $count_writing_style += 1;
        }
        if ($writing_style_creative) {
            if ($count_writing_style == 0) {
                $writing_styles .= "kreativ";
            }
            if ($count_writing_style > 0) {
                $writing_styles .= " und kreativ";
            }
            $count_writing_style += 1;
        }
        // validiere count_writing_style
        if ($count_writing_style == 0) {
            return Redirect::route('customer.content.blog.create')
                ->with([
                    'error' => 'Du musst mindestens einen Schreibstil auswählen.',
                ]);
        }
        //
        $gender_female = $request->gender_female;
        $gender_male = $request->gender_male;
        $gender_divers = $request->gender_divers;
        // ermittle die Anzahl der gewünschten Geschlechter
        $count_gender = 0;
        if ($gender_female) {
            $count_gender += 1;
        }
        if ($gender_male) {
            $count_gender += 1;
        }
        if ($gender_divers) {
            $count_gender += 1;
        }
        // validiere count_gender
        if ($count_gender > 1) {
            return Redirect::route('customer.content.blog.create')
                ->with([
                    'error' => 'Du darfst maximal ein Geschlecht auswählen.',
                ]);
        }
        //
        $age_strata_children = $request->age_strata_children;
        $age_strata_young = $request->age_strata_young;
        $age_strata_adults = $request->age_strata_adults;
        $age_strata_seniors = $request->age_strata_seniors;
        // ermittle die Anzahl der gewünschten Altersschichten
        $count_age_strata = 0;
        if ($age_strata_children) {
            $count_age_strata += 1;
        }
        if ($age_strata_young) {
            $count_age_strata += 1;
        }
        if ($age_strata_adults) {
            $count_age_strata += 1;
        }
        if ($age_strata_seniors) {
            $count_age_strata += 1;
        }
        // validiere count_age_strata
        if ($count_age_strata > 1) {
            return Redirect::route('customer.content.blog.create')
                ->with([
                    'error' => 'Du darfst maximal eine Altersschicht auswählen.',
                ]);
        }
        //
        $interest_groups = $request->interest_groups;
        //
        $professional_groups = $request->professional_groups;
        //
        $lifestyle = $request->lifestyle;
        // Baue Prompt zusammen
        $prompt = "Erstelle einen Artikel.<br />";
        //
        $prompt .= "Thema des Artikels: " . $topic . "<br />";
        //
        if ($count_writing_style == 1) {
            $prompt .= "Bitte verwende für den Blogtext folgenden Schreibstil: " . $writing_styles . "<br />";
        }
        if ($count_writing_style > 1) {
            $prompt .= "Bitte verwende für den Blogtext folgende Schreibstile: " . $writing_styles . "<br />";
        }
        //
        if ($gender_female && !$gender_male && !$gender_divers) {
            $prompt .= "Dieser Blogtext richtet sich an Frauen.<br />";
        }
        //
        if (!$gender_female && $gender_male && !$gender_divers) {
            $prompt .= "Dieser Blogtext richtet sich an Männer.<br />";
        }
        //
        if (!$gender_female && !$gender_male && $gender_divers) {
            $prompt .= "Dieser Blogtext richtet sich an Menschen mit dem Geschlecht divers.<br />";
        }
        //
        if ($age_strata_children && !$age_strata_young && !$age_strata_adults && !$age_strata_seniors) {
            $prompt .= "Dieser Blogtext richtet sich an Kinder.<br />";
        }
        //
        if (!$age_strata_children && $age_strata_young && !$age_strata_adults && !$age_strata_seniors) {
            $prompt .= "Dieser Blogtext richtet sich an Jugendliche.<br />";
        }
        //
        if (!$age_strata_children && !$age_strata_young && $age_strata_adults && !$age_strata_seniors) {
            $prompt .= "Dieser Blogtext richtet sich an Erwachsende.<br />";
        }
        //
        if (!$age_strata_children && !$age_strata_young && !$age_strata_adults && $age_strata_seniors) {
            $prompt .= "Dieser Blogtext richtet sich an Senioren.<br />";
        }
        //
        if ($interest_groups) {
            $prompt .= "Erstelle den Blogtext für die folgende Interessengruppe: " . $interest_groups . "<br />";
        }
        //
        if ($professional_groups) {
            $prompt .= "Erstelle den Blogtext für die folgende Berufsgruppe: " . $professional_groups . "<br />";
        }
        //
        if ($lifestyle) {
            $prompt .= "Erstelle den Blogtext für den folgende Lifestyle: " . $lifestyle . "<br />";
        }
        // ---------------------
        // erstelle den Blogtext
        // ---------------------
        $result = Content::createBlogText($prompt, $number_of_words);
        //$result = collect();
        //$result->summary = "Zusammenfassung";
        //$result->content = "Content";
        //
        //Log::info('customer_content_blog_store', [
        //    'result->content_max_tokens' => $result->content_max_tokens,
        //    'result->content_total_tokens' => $result->content_total_tokens,
        //    'prompt' => $prompt,
        //]);
        //Log::info('customer_content_blog_store', [
        //    'result->summary' => $result->summary,
        //]);
        //Log::info('customer_content_blog_store', [
        //    'result->content' => $result->content,
        //]);
        // ermittle die Anzahl der Wörter
        $word_count = str_word_count(Wandle_Sonderzeichen($result->content));
        //
        //Log::info('customer_content_blog_store', [
        //    'word_count' => $word_count,
        //]);
        // ermittle die Anzahl der Wörter, die mit dem Kunden abgerechnet werden.
        $word_count_transaction = $number_of_words;
        if ($word_count < $number_of_words) {
            $word_count_transaction = $word_count;
        }
        //
        $content = Content::Create([
            'person_company_id' => $customer_id,
            'content_type_id' => ContentType::CONTENT_TYPE_BLOGTEXT,
            'creation_date' => Carbon::now(),
            'number_of_words' => $number_of_words,
            'prompt' => $prompt,
            'summary' => $result->summary,
            'content' => $result->content,
            //
            'blog_topic' => $topic,
            'blog_number_of_words' => $number_of_words,
            'blog_writing_style_personal' => $writing_style_personal,
            'blog_writing_style_objective' => $writing_style_objective,
            'blog_writing_style_opinionated' => $writing_style_opinionated,
            'blog_writing_style_entertaining' => $writing_style_entertaining,
            'blog_writing_style_creative' => $writing_style_creative,
            'blog_gender_female' => $gender_female,
            'blog_gender_male' => $gender_male,
            'blog_gender_divers' => $gender_divers,
            'blog_age_strata_children' => $age_strata_children,
            'blog_age_strata_young' => $age_strata_young,
            'blog_age_strata_adults' => $age_strata_adults,
            'blog_age_strata_seniors' => $age_strata_seniors,
            'blog_interest_groups' => $interest_groups,
            'blog_professional_groups' => $professional_groups,
            'blog_lifestyle' => $lifestyle,
        ]);
        // erstelle jetzt noch den Datensatz in bookings
        Booking::createNewBooking(
            $customer_id,
            BookingType::BOOKING_TYPE_TEXTERSTELLUNG,
            $word_count_transaction,
            $content->id,
            0,
            null
        );
        //
        $success = "Der Blogtext wurde erstellt und es wurden " . formatNumber($word_count) . " Wörter verwendet.<br />";
        $success .= "Du hattest eine Länge von " . formatNumber($number_of_words) . " Wörtern vorgegeben.<br />";
        $success .= "Deinem Punktekonto wurden daher " . formatNumber($word_count_transaction) . " KreativSchreiber-Punkte abgezogen.<br />";
        //
        return Redirect::route('customer.content.show', $content->id)
            ->with(['success' => $success]);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenAI;

class Content extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $casts = [
        'creation_date' => 'datetime',
    ];

    public function getCreationDateAttribute($value)
    {
        if ($value == null) {
            return Carbon::now()->format('Y-m-d H:i');
            //return null;
        }
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function scopeFilterContent($query, array $filters)
    {
        if (isset($filters['search']) && trim($filters['search'] !== '')) {
            $search = $filters['search'];
            $query->where('contents.summary', 'like', '%' . $search . '%');
        }
        //
        return $query;
    }

    // Eine Text (contents) gehört zu genau einer Person / einem Unternehmen (person_companies)
    public function person_company()
    {
        return $this->belongsTo('App\Models\PersonCompany', 'person_company_id', 'id');
    }

    // Ein Text (contents) gehört zu genau einem Texttyp (content_types)
    public function content_type()
    {
        return $this->belongsTo('App\Models\ContentType', 'content_type_id', 'id');
    }

    public static function createAdvertisementText(
        $prompt,
        int $number_of_words
    ) {
        set_time_limit(0);
        //
        $content = collect();
        //
        $content->errorOn = false;
        $content->errorMessage = null;
        $content->content = null;
        $content->content_max_tokens = 0;
        $content->content_total_tokens = 0;
        $content->summary = null;
        $content->summary_max_tokens = 0;
        $content->summary_total_tokens = 0;
        //
        $api_key = config('kreativschreiber.api_keys.open_ai');
        $client_content = OpenAI::client($api_key);
        // erstelle den Werbetext
        $number_of_words_correction = round($number_of_words * 110 / 100, 2);
        $prompt_content = $prompt . "Verwende hierfür mindestens " . $number_of_words_correction . " Wörter.<br />";
        // ermittle content_max_tokens
        $content->content_max_tokens = round($number_of_words * 40 / 10 + 100, 2);
        //
        //Log::info('createAdvertisementText', [
        //    'number_of_words_correction' => $number_of_words_correction,
        //    'prompt_contents' => $prompt_content,
        //    'content->content_max_tokens' => $content->content_max_tokens,
        //]);
        //
        $result_content = $client_content->completions()->create([
            "model" => "text-davinci-003",
            "temperature" => 0.7,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => $content->content_max_tokens,
            'prompt' => $prompt_content,
        ]);
        //
        $content->content = trim($result_content['choices'][0]['text']);
        //
        $content->content_total_tokens = $result_content['usage']['total_tokens'];
        // erstelle eine Zusammenfassung des Werbetextes
        $content->summary = substr($content->content, 0, 200) . "...";
        //
        return $content;
    }
//
    public static function createBlogText(
        $prompt,
        int $number_of_words
    ) {
        set_time_limit(0);
        //
        $content = collect();
        //
        $content->errorOn = false;
        $content->errorMessage = null;
        $content->content = null;
        $content->content_max_tokens = 0;
        $content->content_total_tokens = 0;
        $content->summary = null;
        //
        $api_key = config('kreativschreiber.api_keys.open_ai');
        $client_content = OpenAI::client($api_key);
        // erstelle den Blogtext
        $number_of_words_correction = round($number_of_words * 110 / 100, 2);
        $prompt_content = $prompt . "Verwende hierfür mindestens " . $number_of_words_correction . " Wörter.<br />";
        // ermittle content_max_tokens
        $content->content_max_tokens = round($number_of_words * 40 / 10 + 100, 2);
        //
        //Log::info('createBlogText', [
        //    'number_of_words_correction' => $number_of_words_correction,
        //    'prompt_contents' => $prompt_content,
        //    'content->content_max_tokens' => $content->content_max_tokens,
        //]);
        //
        $result_content = $client_content->completions()->create([
            "model" => "text-davinci-003",
            "temperature" => 0.7,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => $content->content_max_tokens,
            'prompt' => $prompt_content,
        ]);
        //
        $content->content = trim($result_content['choices'][0]['text']);
        //
        $content->content_total_tokens = $result_content['usage']['total_tokens'];
        // erstelle eine Zusammenfassung des Blogtextes
        $content->summary = substr($content->content, 0, 200) . "...";
        //
        return $content;
    }
}

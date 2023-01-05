<?php

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

//
if (!function_exists('transformToQuarterYear')) {
    function transformToQuarterYear(Carbon $date)
    {
        //
        return 'Q' . $date->quarter . ' ' . $date->year;
    }
}
//
if (!function_exists('transformToDecimal')) {
    function transformToDecimal(float $number = null, int $decimals = 2)
    {
        // Rückgabeformat NNNNN.NN, falls $decimals 2 ist
        // kein 1000er-Trennzeichen verwenden!
        $value = 0;
        //
        $dec_point = '.';
        $thousands_sep = '';
        //
        try {
            $value = number_format($number, $decimals, $dec_point, $thousands_sep);
        } catch (Exception $e) {
            Log::error('transformToDecimal', [
                'number' => $number,
                'message' => $e->getMessage(),
            ]);
            $value = 0;
        }
        //
        return $value;
    }
}
//
if (!function_exists('determineValueFromArrayKey')) {
    function determineValueFromArrayKey(array $array = null, string $key)
    {
        $value = null;
        //
        if (Arr::exists($array, $key)) {
            $value = $array[$key];
        }
        //
        return $value;
    }
}
//
if (!function_exists('formatNumber')) {
    function formatNumber(float $number = null, $decimals = 0)
    {
        $dec_point = ',';
        $thousands_sep = '.';

        if (App::isLocale('en')) {
            $dec_point = '.';
            $thousands_sep = ',';
        }

        if ($number == '' || $number == null)
            return 0;

        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
}

//
if (!function_exists('formatDateTimeLocale')) {
    function formatDateTimeLocale($date = '')
    {
        $format = 'd.m.Y H:i';

        if (App::isLocale('en')) {
            $format = 'd/m/Y H:i';
        }

        if ($date == '' || $date == null)
            return;

        return date($format, strtotime($date));
    }
}

//
if (!function_exists('formatDateLocale')) {
    function formatDateLocale($date = '')
    {
        $format = 'd.m.Y';

        if (App::isLocale('en')) {
            $format = 'd/m/Y';
        }

        if ($date == '' || $date == null)
            return;

        return date($format, strtotime($date));
    }
}

//
if (!function_exists('changeBooleanToNumber')) {
    function changeBooleanToNumber($value = null)
    {
        $number = 0;
        if ($value === true || $value === "true" || $value === 1 || $value === "1") {
            $number = 1;
        }
        //dd("30: ", $value, $number);
        return $number;
    }
}

//
if (!function_exists('Wandle_Sonderzeichen')) {
    function Wandle_Sonderzeichen($strInput = '')
    {
        $strInput = str_replace("&", "", $strInput);
        $strInput = str_replace("Ä", "AE", $strInput);
        $strInput = str_replace("Ü", "UE", $strInput);
        $strInput = str_replace("Ö", "ÖE", $strInput);
        $strInput = str_replace("ä", "ae", $strInput);
        $strInput = str_replace("ü", "ue", $strInput);
        $strInput = str_replace("ö", "oe", $strInput);
        $strInput = str_replace("ß", "ss", $strInput);
        //
        $strInput = str_replace("é", "e", $strInput);
        $strInput = str_replace("è", "e", $strInput);
        $strInput = str_replace("ê", "e", $strInput);
        //
        $strInput = str_replace("à", "a", $strInput);
        $strInput = str_replace("à", "a", $strInput);
        $strInput = str_replace("â", "a", $strInput);
        //
        $strInput = str_replace("í", "i", $strInput);
        $strInput = str_replace("ì", "i", $strInput);
        $strInput = str_replace("î", "i", $strInput);
        //
        $strInput = str_replace("ó", "o", $strInput);
        $strInput = str_replace("ò", "o", $strInput);
        $strInput = str_replace("ô", "o", $strInput);
        //
        $strInput = str_replace("ú", "u", $strInput);
        $strInput = str_replace("ú", "u", $strInput);
        $strInput = str_replace("û", "u", $strInput);
        //
        htmlentities($strInput, ENT_QUOTES);
        //
        return $strInput;
    }
}

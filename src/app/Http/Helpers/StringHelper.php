<?php

namespace App\Http\Helpers;

use \Illuminate\Support\Facades\Crypt;

/**
 * @class StringHelper
 * Add any functions to work with strings. Which can use in blade files as well
 * in foo.blade.php > {!! StringHelper::wordTruncate($string, $wordCount) !!}
 * @author skaushalye
 */
class StringHelper {
    
    public static function uppercase($string) {
        return strtoupper($string);
    }
    
    public static function lowercase($string) {
        return strtolower($string);
    }
    
    public static function wordTruncate($para, $wordCount = 10) {
        $chunks = array_chunk(explode(' ', $para), $wordCount); // Make groups of 3 words
        if(isset($chunks[0]) && $chunks[0] != ""){
            return implode(' ', $chunks[0])."...";
        } else {
            return $para;
        }
    }
    
    public static function getCurrencySymbol($currencyCode){
        switch($currencyCode){
            case 'GBP':
                return "£";
                break;
            case 'USD':
                return "$";
                break;
            default :
                return "£";
                break;
        }
    }
    
    /**
     * Encrypt given string
     * @param string $string
     * @return string
     */
    public static function encryptString($string)
    {
        $encrypted = Crypt::encrypt($string);
        return $encrypted;
    }
    
    /**
     * Decrypt given encrypted string
     * @param string $encrypted
     * @return string
     */
    public static function dencryptedString($encrypted)
    {
        $decrypted_string = Crypt::decrypt($encrypted);
        return $decrypted_string;
    }
}

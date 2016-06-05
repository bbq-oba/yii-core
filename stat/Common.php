<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/24
 * Time: 0:06
 */

namespace app\stat;


use app\stat\Intl\Data\Provider\LanguageDataProvider;
use yii\base\Exception;

class Common
{
    const REFERRER_TYPE_DIRECT_ENTRY = 1;
    const REFERRER_TYPE_SEARCH_ENGINE = 2;
    const REFERRER_TYPE_WEBSITE = 3;
    const REFERRER_TYPE_CAMPAIGN = 6;

    public static function stringEndsWith($haystack, $needle)
    {
        if ('' === $needle) {
            return true;
        }

        $lastCharacters = substr($haystack, -strlen($needle));

        return $lastCharacters === $needle;
    }





    public static function sanitizeInputValue($value)
    {
        $value = self::sanitizeLineBreaks($value);
        $value = self::sanitizeString($value);
        return $value;
    }
    public static function sanitizeLineBreaks($value)
    {
        return str_replace(array("\n", "\r"), '', $value);
    }
    /**
     * Sanitize a single input value
     *
     * @param $value
     * @return string
     */
    private static function sanitizeString($value)
    {
        // $_GET and $_REQUEST already urldecode()'d
        // decode
        // note: before php 5.2.7, htmlspecialchars() double encodes &#x hex items
        $value = html_entity_decode($value, self::HTML_ENCODING_QUOTE_STYLE, 'UTF-8');

        $value = self::sanitizeNullBytes($value);

        // escape
        $tmp = @htmlspecialchars($value, self::HTML_ENCODING_QUOTE_STYLE, 'UTF-8');

        // note: php 5.2.5 and above, htmlspecialchars is destructive if input is not UTF-8
        if ($value != '' && $tmp == '') {
            // convert and escape
            $value = utf8_encode($value);
            $tmp = htmlspecialchars($value, self::HTML_ENCODING_QUOTE_STYLE, 'UTF-8');
            return $tmp;
        }
        return $tmp;
    }

    public static function getCampaignParameters()
    {
        $return = array(
            'pk_cpn,pk_campaign,piwik_campaign,utm_campaign,utm_source,utm_medium',
            'pk_kwd,pk_keyword,piwik_kwd,utm_term',
        );

        foreach ($return as &$list) {
            if (strpos($list, ',') !== false) {
                $list = explode(',', $list);
            } else {
                $list = array($list);
            }
            $list = array_map('trim', $list);
        }

        return $return;
    }

    public static function unsanitizeInputValue($value)
    {
        return htmlspecialchars_decode($value, self::HTML_ENCODING_QUOTE_STYLE);
    }

    public static function unsanitizeInputValues($value)
    {
        if (is_array($value)) {
            $result = array();
            foreach ($value as $key => $arrayValue) {
                $result[$key] = self::unsanitizeInputValues($arrayValue);
            }
            return $result;
        } else {
            return self::unsanitizeInputValue($value);
        }
    }
    /**
     * Returns the language and region string, based only on the Browser 'accepted language' information.
     * * The language tag is defined by ISO 639-1
     * * The region tag is defined by ISO 3166-1
     *
     * @param string $browserLanguage Browser's accepted langauge header
     * @param array $validLanguages array of valid language codes. Note that if the array includes "fr" then it will consider all regional variants of this language valid, such as "fr-ca" etc.
     * @return string 2 letter ISO 639 code 'es' (Spanish) or if found, includes the region as well: 'es-ar'
     */
    const LANGUAGE_CODE_INVALID = 'xx';
    public static function extractLanguageAndRegionCodeFromBrowserLanguage($browserLanguage, $validLanguages = array())
    {
        $validLanguages = self::checkValidLanguagesIsSet($validLanguages);

        if (!preg_match_all('/(?:^|,)([a-z]{2,3})([-][a-z]{2})?/', $browserLanguage, $matches, PREG_SET_ORDER)) {
            return self::LANGUAGE_CODE_INVALID;
        }
        foreach ($matches as $parts) {
            $langIso639 = $parts[1];
            if (empty($langIso639)) {
                continue;
            }

            // If a region tag is found eg. "fr-ca"
            if (count($parts) == 3) {
                $regionIso3166 = $parts[2]; // eg. "-ca"

                if (in_array($langIso639 . $regionIso3166, $validLanguages)) {
                    return $langIso639 . $regionIso3166;
                }

                if (in_array($langIso639, $validLanguages)) {
                    return $langIso639 . $regionIso3166;
                }
            }
            // eg. "fr" or "es"
            if (in_array($langIso639, $validLanguages)) {
                return $langIso639;
            }
        }
        return self::LANGUAGE_CODE_INVALID;
    }
    /**
     * @param $validLanguages
     * @return array
     */
    protected static function checkValidLanguagesIsSet($validLanguages)
    {
        /** @var LanguageDataProvider $dataProvider */
        $dataProvider = new LanguageDataProvider();

        if (empty($validLanguages)) {
            $validLanguages = array_keys($dataProvider->getLanguageList());
            return $validLanguages;
        }
        return $validLanguages;
    }

    /**
     * Convert hexadecimal representation into binary data.
     * !! Will emit warning if input string is not hex!!
     *
     * @see http://php.net/bin2hex
     *
     * @param string $str Hexadecimal representation
     * @return string
     */
    public static function hex2bin($str)
    {
        return pack("H*", $str);
    }
    /**
     * Returns the browser language code, eg. "en-gb,en;q=0.5"
     *
     * @param string|null $browserLang Optional browser language, otherwise taken from the request header
     * @return string
     */
    public static function getBrowserLanguage($browserLang = null)
    {
        static $replacementPatterns = array(
            // extraneous bits of RFC 3282 that we ignore
            '/(\\\\.)/', // quoted-pairs
            '/(\s+)/', // CFWcS white space
            '/(\([^)]*\))/', // CFWS comments
            '/(;q=[0-9.]+)/', // quality

            // found in the LANG environment variable
            '/\.(.*)/', // charset (e.g., en_CA.UTF-8)
            '/^C$/', // POSIX 'C' locale
        );

        if (is_null($browserLang)) {
            $browserLang = self::sanitizeInputValues(@$_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if (empty($browserLang) && self::isPhpCliMode()) {
                $browserLang = @getenv('LANG');
            }
        }

        if (empty($browserLang)) {
            // a fallback might be to infer the language in HTTP_USER_AGENT (i.e., localized build)
            $browserLang = "";
        } else {
            // language tags are case-insensitive per HTTP/1.1 s3.10 but the region may be capitalized per ISO3166-1;
            // underscores are not permitted per RFC 4646 or 4647 (which obsolete RFC 1766 and 3066),
            // but we guard against a bad user agent which naively uses its locale
            $browserLang = strtolower(str_replace('_', '-', $browserLang));

            // filters
            $browserLang = preg_replace($replacementPatterns, '', $browserLang);

            $browserLang = preg_replace('/((^|,)chrome:.*)/', '', $browserLang, 1); // Firefox bug
            $browserLang = preg_replace('/(,)(?:en-securid,)|(?:(^|,)en-securid(,|$))/', '$1', $browserLang, 1); // unregistered language tag

            $browserLang = str_replace('sr-sp', 'sr-rs', $browserLang); // unofficial (proposed) code in the wild
        }

        return $browserLang;
    }
    public static $isCliMode = null;

    /**
     * Returns true if PHP was invoked from command-line interface (shell)
     *
     * @since added in 0.4.4
     * @return bool true if PHP invoked as a CGI or from CLI
     */
    public static function isPhpCliMode()
    {
        if (is_bool(self::$isCliMode)) {
            return self::$isCliMode;
        }

        if(PHP_SAPI == 'cli'){
            return true;
        }

        if(self::isPhpCgiType() && (!isset($_SERVER['REMOTE_ADDR']) || empty($_SERVER['REMOTE_ADDR']))){
            return true;
        }

        return false;
    }

    /**
     * Returns true if PHP is executed as CGI type.
     *
     * @since added in 0.4.4
     * @return bool true if PHP invoked as a CGI
     */
    public static function isPhpCgiType()
    {
        $sapiType = php_sapi_name();

        return substr($sapiType, 0, 3) === 'cgi';
    }


    /**
     * Undo the damage caused by magic_quotes; deprecated in php 5.3 but not removed until php 5.4
     *
     * @param string
     * @return string  modified or not
     */
    private static function undoMagicQuotes($value)
    {
        static $shouldUndo;

        if (!isset($shouldUndo)) {
            $shouldUndo = version_compare(PHP_VERSION, '5.4', '<') && get_magic_quotes_gpc();
        }

        if ($shouldUndo) {
            $value = stripslashes($value);
        }

        return $value;
    }
    // Flag used with htmlspecialchar. See php.net/htmlspecialchars.
    const HTML_ENCODING_QUOTE_STYLE = ENT_QUOTES;
    /**
     * Sanitize a single input value
     *
     * @param $value
     * @return string
     */

    /**
     * @param string $value
     * @return string Null bytes removed
     */
    public static function sanitizeNullBytes($value)
    {
        return str_replace(array("\0"), '', $value);
    }

    public static function sanitizeInputValues($value, $alreadyStripslashed = false)
    {
        if (is_numeric($value)) {
            return $value;
        } elseif (is_string($value)) {
            $value = self::sanitizeString($value);

            if (!$alreadyStripslashed) {
                // a JSON array was already stripslashed, don't do it again for each value

                $value = self::undoMagicQuotes($value);
            }
        } elseif (is_array($value)) {
            foreach (array_keys($value) as $key) {
                $newKey = $key;
                $newKey = self::sanitizeInputValues($newKey, $alreadyStripslashed);
                if ($key != $newKey) {
                    $value[$newKey] = $value[$key];
                    unset($value[$key]);
                }

                $value[$newKey] = self::sanitizeInputValues($value[$newKey], $alreadyStripslashed);
            }
        } elseif (!is_null($value)
            && !is_bool($value)
        ) {
            throw new Exception("The value to escape has not a supported type. Value = " . var_export($value, true));
        }
        return $value;
    }
    public static function mb_strtolower($string)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($string, 'UTF-8');
        }

        return strtolower($string);
    }

}
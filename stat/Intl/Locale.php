<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace app\stat\Intl;

class Locale
{
    /**
     * @param string|array $locale
     */
    public static function setLocale($locale)
    {
        if(!is_array($locale)){
            $locale = array($locale);
        }
        
        $newLocale = array();
        foreach($locale as $localePart){
            $newLocale[] = $localePart;
            
            $localeVariant = str_replace('UTF-8', 'UTF8', $localePart);
            if($localeVariant != $localePart){
                $newLocale[] = $localeVariant;
            }
        }
        
        setlocale(LC_ALL, $newLocale);
        setlocale(LC_CTYPE, '');
        // Always use english for numbers. otherwise the decimal separator might get localized when casting a float to string
        setlocale(LC_NUMERIC, array('en_US.UTF-8', 'en-US'));
    }

    public static function setDefaultLocale()
    {
        self::setLocale(array('en_US.UTF-8', 'en-US'));
    }
}
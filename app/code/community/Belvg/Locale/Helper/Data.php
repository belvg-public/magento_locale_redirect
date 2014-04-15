<?php

/**
 * BelVG LLC.
 * @category   Belvg
 * @package    Belvg_Locale
 * @author Pavel Novitsky <pavel@belvg.com>
 */
class Belvg_Locale_Helper_Data extends Mage_Core_Helper_Data
{

    /**
     * Check HTTP_ACCEPT_LANGUAGE header, split locales according to the quality
     * @return array
     */
    public function getLocaleQuality()
    {
        $locales = array();

        if ($acceptLanguage = Mage::helper('core/http')->getHttpAcceptLanguage()) {
            // break up string into pieces (languages and q factors)
            $pattern = '/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i';
            preg_match_all($pattern, $acceptLanguage, $parsedLocales);

            if (count($parsedLocales[1])) {
                // create a list like "en" => 0.8
                $locales = array_combine($parsedLocales[1], $parsedLocales[4]);

                // set default to 1 for any without q factor
                foreach ($locales as $locale => $val) {
                    if ($val === '') {
                        $locales[$locale] = 1;
                    }
                }
            }

            $locales[$this->getDefaultLanguage()] = 0.01;
        } else {
            $locales[$this->getDefaultLanguage()] = 1;
        }

        // sort list based on value
        arsort($locales, SORT_NUMERIC);

        return $locales;
    }

    /**
     * Return language for the store from configuration
     *
     * @param mixed $$store
     * @return string
     */
    public function getDefaultLanguage($store = NULL)
    {
        $locale = Mage::getStoreConfig('general/locale/code', $store);
        $lang = substr($locale, 0, 2);
        return strtolower($lang);
    }

}

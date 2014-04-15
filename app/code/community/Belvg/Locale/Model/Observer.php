<?php

/**
 * BelVG LLC.
 * @category   Belvg
 * @package    Belvg_Locale
 * @author Pavel Novitsky <pavel@belvg.com>
 */
class Belvg_Locale_Model_Observer
{

    /**
     * Use language according to the customer's browser HTTP_ACCEPT_LANGUAGE header
     * @param Varien_Event_Observer $observer
     */
    public function checkLocale(Varien_Event_Observer $observer)
    {
        $session = $this->_getSession();

        // if HTTP_ACCEPT_LANGUAGE was not processed diring active session nor store was defined before
        if (!$session->hasLanguageChecked() && !Mage::getModel('core/cookie')->get('store')) {
            $helper = Mage::helper('locale');
            /* @var $helper Belvg_Locale_Helper_Data */

            // get list of possible locales
            $localesQuality = $helper->getLocaleQuality();

            $stores = Mage::app()->getStores(FALSE, TRUE);
            $storeLangs = array();
            $url = NULL;

            // collect store codes
            foreach ($stores as $store) {
                if (!$store->getIsActive()) {
                    continue;
                }

                $storeLangs[$helper->getDefaultLanguage($store)] = $store->getCode();
            }

            // loop available locales and find sutable for the browser
            foreach ($localesQuality as $locale => $code) {
                $localeCode = substr($locale, 0, 2);

                // if locale was found in store languages — prepare redirect url
                if (isset($storeLangs[$localeCode])) {
                    // no need to redirect user if current store is already in use
                    if ($storeLangs[$localeCode] == Mage::app()->getStore()->getCode()) {
                        break;
                    }

                    // generate redirect url
                    $params = array(
                            '_current' => TRUE,
                            '_use_rewrite' => TRUE,
                            '_store_to_url' => TRUE,
                            '_store' => Mage::app()->getStore($storeLangs[$localeCode])->getId()
                    );
                    $url = Mage::getUrl('', $params);
                    break;
                }
            }

            if ($url) {
                // flag this method as processed and redirect to the store
                $session->setLanguageChecked(TRUE);
                Mage::app()->getResponse()->setRedirect($url);
            }
        }
    }

    /**
     * Get frontend customer session
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

}

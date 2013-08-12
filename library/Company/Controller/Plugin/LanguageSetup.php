<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Language Setup plugin
 * 
 * Sets up the language
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Controller_Plugin_LanguageSetup extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var array list of supported language
     */
    protected $_languages = array('de', 'en');
    
    /**
     * Initializes the language
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        // get language
        $lang = $request->getParam('lang');
        
        // check language
        if (!in_array($lang, $this->_languages))
        {
            // redirect
            $url = Zend_Controller_Action_HelperBroker::getStaticHelper('url')->url(array('lang' => 'de'));
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector'); 
            $redirector->gotoUrl($url);
        }
        
        // check for foreign language
        if ($lang == 'de')
        {
            return;
        }
        
        // get module dirs
        $moduleDirs = Zend_Controller_Front::getInstance()->getControllerDirectory();
        
        // get translate object
        $translate = Zend_Registry::get('Zend_Translate'); /* @var $translate Zend_Translate_Adapter_Array */
        
        // get messages
        $translations = $translate->getMessages();
        
        // loop through module dirs
        foreach ($moduleDirs as $moduleDir)
        {
            // build locales filename
            $localesFile = str_replace('/controllers', '/locales', $moduleDir) . '/' . $lang . '.php';
            
            // check for file existance
            if (file_exists($localesFile))
            {
                // combine translations
                $translations = array_merge($translations, include $localesFile);
            }
        }
        
        // sort translations
        ksort($translations);
        
        // add translations
        $translate->addTranslation($translations, $lang);
        
        // change locale
        $translate->setLocale($lang);
        
        // add Zend_Validate translator
        $translator = new Zend_Translate(
            array(
                'adapter' => 'array',
                'content' => APPLICATION_PATH . '/modules/default/locales/Zend_Validate',
                'locale'  => $lang,
                'scan'    => Zend_Translate::LOCALE_DIRECTORY
            )
        );
        
        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }
}

<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Module bootstrap
 * 
 * Handles the bootstrapping for the our modules
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * Setup the translate files
     *
     * @param array $options options for autoloader resources
     */
    protected function _initTranslate(array $options = array())
    {
        // make sure that locale and translate ressources have been set up
        $this->getApplication()->bootstrap('locale');
        $this->getApplication()->bootstrap('translate');
    
        // build locales filename
        $localesFile = APPLICATION_PATH . '/modules/' . strtolower($this->_moduleName) . '/locales/' . Zend_Registry::get('Zend_Locale')->getLanguage() . '.php';
    
        // check for file existance
        if (file_exists($localesFile))
        {
            // combine translations
            $translations = array_merge(Zend_Registry::get('Zend_Translate')->getMessages(), include $localesFile);
    
            // sort translations
            ksort($translations);
    
            // add translations
            Zend_Registry::get('Zend_Translate')->addTranslation($translations, Zend_Registry::get('Zend_Locale')->getLanguage());
        }
    }
    
    /*
     * Setup the acl resource
     * 
     * @param array $options options for autoloader resources
     */
    protected function _initAcl(array $options = array())
    {
        // build acl file name
        $file = APPLICATION_PATH . '/modules/' . strtolower($this->_moduleName) . '/configs/acl.ini';
        
        // check acl file existance
        if (!file_exists($file))
        {
            return;
        }
        
        // get acl
        $acl = Zend_Registry::get('acl'); /* @var $acl Company_Acl */
        
        // add ini file
        $acl->addIniFile($file);
    }
}
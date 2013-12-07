<?php
/**
 * ZF2 migration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace Application\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

/**
 * Compatibility listener
 *
 * Prepares configuration needed by ZF1 classes
 *
 * @package    Application
 */
class CompatibilityListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     * @param  integer               $priority
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            array($this, 'setupZF1Compatibility'),
            100
        );
    }

    /**
     * Detach all our listeners from the event manager
     *
     * @param  EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Listen to the "dispatch" event to setup ZF1 compatibility
     *
     * @param  MvcEvent $e
     *
     * @return null
     */
    public function setupZF1Compatibility(EventInterface $e)
    {
        // load application config data
        $config = new \Zend_Config_Ini(
            PROJECT_PATH
            . '/application.zf1/modules/default/configs/application.ini',
            APPLICATION_ENV
        );

        // get cache options
        $cacheOptions = $config->resources->cachemanager->database->toArray();

        // initialize cache
        $cache = \Zend_Cache::factory(
            $cacheOptions['frontend']['name'],
            $cacheOptions['backend']['name'],
            $cacheOptions['frontend']['options'],
            $cacheOptions['backend']['options']
        );

        // pass cache to registry
        \Zend_Registry::set('cache', $cache);

        // get db options
        $dbOptions = $config->resources->db->toArray();

        // initialize db 
        $db = \Zend_Db::factory($dbOptions['adapter'], $dbOptions['params']);

        // set default db adapter
        \Zend_Db_Table::setDefaultAdapter($db);

        // set request and response for front controller
        \Zend_Controller_Front::getInstance()->setRequest(
            new \Zend_Controller_Request_Http()
        );
        \Zend_Controller_Front::getInstance()->setResponse(
            new \Zend_Controller_Response_Http()
        );
        \Zend_Controller_Front::getInstance()->setDispatcher(
            new \Zend_Controller_Dispatcher_Standard()
        );

        // initialize translations
        $translations = array();

        // get application config
        $applicationConfig = $e->getApplication()->getServiceManager()->get(
            'ApplicationConfig'
        );

        // loop through modules
        foreach ($applicationConfig['modules'] as $module) {
            // build locales filename
            $localesFile = PROJECT_PATH . '/module/' . $module . '/language/'
                . $e->getRouteMatch()->getParam('lang') . '.php';

            // check for file existance
            if (file_exists($localesFile)) {
                // combine translations
                $translations = array_merge(
                    $translations, include $localesFile
                );

                // sort translations
                ksort($translations);
            }
        }

        // initialize Zend_Translate
        $translator = new \Zend_Translate(array(
            'adapter' => 'Array',
            'content' => $localesFile,
            'locale'  => $e->getRouteMatch()->getParam('lang'),
        ));
        $translator->addTranslation(
            $translations, $e->getRouteMatch()->getParam('lang')
        );

        // add Zend_Translate to Zend\Form
        \Zend_Form::setDefaultTranslator($translator);

        // add namespace for static filters
        \Zend_Filter::addDefaultNamespaces('Company_Filter');
        \Zend_Validate::addDefaultNamespaces('Company_Validate');
    }
}

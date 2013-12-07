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
namespace User\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

/**
 * Authorization listener
 *
 * Listens on user level
 *
 * @package    Application
 */
class AuthorizationListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Listen to the "render" event and add the acl to the navigation
     *
     * @param  MvcEvent $e
     *
     * @return null
     */
    public function addAclToNavigation(EventInterface $e)
    {
        // get service manager, view manager and acl service
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewManager    = $serviceManager->get('viewmanager');
        $auth           = $serviceManager->get('User\Authentication');
        $acl            = $serviceManager->get('User\Acl');
        $role           = $auth->hasIdentity()
            ? $auth->getIdentity()->getGroup()
            : 'guest';

        // set navigation plugin and set acl and role
        $plugin = $viewManager->getRenderer()->plugin('navigation');
        $plugin->setRole($role);
        $plugin->setAcl($acl);
    }

    /**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     * @param  integer               $priority
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH, array($this, 'checkAcl'), 100
        );
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_RENDER, array($this, 'addAclToNavigation'), -100
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
     * Listen to the "dispatch" event and check the user rights
     *
     * @param  MvcEvent $e
     *
     * @return null
     */
    public function checkAcl(MvcEvent $e)
    {
        // get route match, params and objects
        $routeMatch       = $e->getRouteMatch();
        $serviceManager   = $e->getApplication()->getServiceManager();
        $controllerLoader = $serviceManager->get('ControllerLoader');
        $auth             = $serviceManager->get('User\Authentication');
        $acl              = $serviceManager->get('User\Acl');

        // try to load current controller
        try {
            $controller = $controllerLoader->get(
                $routeMatch->getParam('controller')
            );
        } catch (\Exception $exception) {
            return;
        }

        // get role, resource and privilege
        $role = $auth->hasIdentity() ? $auth->getIdentity()->getGroup()
            : 'guest';
        $resource
                   =
            $routeMatch->getParam('module') . '-' . $routeMatch->getParam(
                '__CONTROLLER__'
            );
        $privilege = $routeMatch->getParam('action');

        // check for default / application
        if (strstr($resource, 'application_')) {
            $resource = str_replace('application_', 'default_', $resource);
        }

        // check acl
        if (!$acl->isAllowed($role, $resource, $privilege)) {
            // change response for redirect
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine(
                'Location', '/de/user/index/forbidden'
            );
            $response->setStatusCode(302);
            $response->sendHeaders();

            return $response;
        }
    }
}

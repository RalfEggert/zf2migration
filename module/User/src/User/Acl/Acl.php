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
namespace User\Acl;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl as ZendAcl;

/**
 * Acl
 *
 * Extends ACL
 *
 * @package    Application
 */
class Acl extends ZendAcl
{
    /**
     * Create ACL instance
     */
    public function __construct($config)
    {
        // add roles
        $this->addRole('guest');
        $this->addRole('reader', 'guest');
        $this->addRole('editor', 'reader');
        $this->addRole('admin');

        // loop through role data
        foreach ($config as $role => $resources) {
            // loop through resource data
            foreach ($resources as $resource => $rules) {
                // check for resource
                if (!$this->hasResource($resource)) {
                    $this->addResource($resource);
                }

                // loop trough rules
                foreach ($rules as $rule => $privileges)
                {
                    // add rule with privileges
                    $this->$rule($role, $resource, $privileges);
                }
            }
        }
    }
}

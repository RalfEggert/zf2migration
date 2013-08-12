<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Acl
 * 
 * Extends the standard ACL
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Acl extends Zend_Acl
{
    /**
	 * Add ini file
	 * 
	 * @param  string $file ini file name
     * @return void
     */
    public function addIniFile($file)
    {
        if (empty($file) || !file_exists($file))
        {
            return;
        }
        
        // get config
        $config = new Zend_Config_Ini($file);
        
        // add roles to acl
        if (isset($config->roles))
        {
            foreach ($config->roles as $role)
            {
                $this->addRole($role->name, !empty($role->parent) ? $role->parent : null);
            }
        }
        
        // add resources to acl
        if (isset($config->resources))
        {
            foreach ($config->resources as $resource)
            {
                $this->addResource($resource);
            }
        }
        
        // add rules to acl
        if (isset($config->rules))
        {
            foreach ($config->rules as $role => $resources)
            {
                foreach ($resources as $resource => $privileges)
                {
                    if (empty($resource) || 'null' == $resource)
                    {
                        $resource = null;
                    }
                    
                    foreach ($privileges as $privilege => $rules)
                    {
                        if (empty($rules))
                        {
                            $rules = null;
                        }
                        elseif (!is_array($rules))
                        {
                            $rules = explode('|', $rules);
                        }
                        
                        $this->$privilege($role, $resource, $rules);
                    }
                }
            }
        }
    }
    
}

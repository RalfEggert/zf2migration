<?php
/**
 * ZF2 migration
 *
 * Front-Controller file
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application.zf1'));

// Define path to project directory
defined('PROJECT_PATH') || define(
    'PROJECT_PATH', realpath(dirname(__FILE__) . '/..')
);

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// add include path
set_include_path(get_include_path() . ':' . PROJECT_PATH . '/library.zf1');

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();

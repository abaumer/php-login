<?php

/**
 * A simple, clean and secure PHP Login Script
 *
 * MVC FRAMEWORK VERSION
 * Check GitHub for other versions
 * Check develop branch on GitHub for bleeding edge versions
 *
 * A simple PHP Login Script embedded into a small framework.
 * Uses PHP sessions, the most modern password-hashing and salting
 * and gives all major functions a proper login system needs.
 *
 * @package php-login
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Load application config (error reporting, database credentials etc.)
require 'application/config/config.php';

// The auto-loader to load the php-login related internal stuff automatically
require 'application/config/autoload.php';

// The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// start our app
$app = new Application();
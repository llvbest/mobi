<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT',dirname(__FILE__).DIRECTORY_SEPARATOR );
define('IDEAL',dirname(__FILE__).DIRECTORY_SEPARATOR .'ideal'.DIRECTORY_SEPARATOR );
define('APP',dirname(__FILE__).DIRECTORY_SEPARATOR .'application'.DIRECTORY_SEPARATOR );

include IDEAL.'framework.php';

App::gi()->start();
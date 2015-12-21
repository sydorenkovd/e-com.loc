<?php
date_default_timezone_set('Europe/Kiev');
if(!isset($_SESSION)) {
    session_start();
}
const ENVIRONMENT = 1;
if(ENVIRONMENT == 1 ){
    ini_set('display_errors', 'On');
    error_reporting(-1);
} else {
    ini_set('display_erros', 'Off');
    error_reporting(0);
}
// directory separator
const DS = DIRECTORY_SEPARATOR;
require_once('inc'. DS . 'config.php');
require_once('library/SSD' . DS . 'Autoloader.php');

spl_autoload_register(['SSD\Autoloader', 'load']);
use SSD\Core;
$core = new Core();
$core->run();
<?php


// site domain name with http
defined("SITE_URL")
	|| define("SITE_URL", "http://".$_SERVER['SERVER_NAME']);

// root path
defined("ROOT_PATH")
	|| define("ROOT_PATH", realpath(dirname(__FILE__) . DS."..".DS));
	
// library folder
const CLASSES_DIR = "library";
const CLASSES_PATH = ROOT_PATH . DS . CLASSES_DIR;
const PLUGIN_PATH = ROOT_PATH . DS . 'plugin';

// pages directory
defined("PAGES_DIR")
	|| define("PAGES_DIR", "pages");

// modules folder
defined("MOD_DIR")
	|| define("MOD_DIR", "mod");
	
// inc folder
defined("INC_DIR")
	|| define("INC_DIR", "inc");
	
// templates folder
defined("TEMPLATE_DIR")
	|| define("TEMPLATE_DIR", "template");
	
// emails path
defined("EMAILS_PATH")
	|| define("EMAILS_PATH", ROOT_PATH.DS."emails");
// catalog images directory
defined("CATALOGUE_DIR")
|| define("CATALOGUE_DIR", "media".DS."catalogue");
// catalogue images path
defined("CATALOGUE_PATH")
	|| define("CATALOGUE_PATH", ROOT_PATH . DS . CATALOGUE_DIR);

//SMTP
const SMTP_USE = false;
const SMTP_HOST = '';
const SMTP_USERNAME = '';
const SMTP_PASSWORD = '';
const SMTP_PORT = '';
const SMTP_SSL = '';

//database

const DB_HOST = 'localhost';
const DB_NAME = '';
const DB_USER = 'root';
const DB_PASSWORD = '';



// add all above directories to the include path
set_include_path(implode(PATH_SEPARATOR, array(
//	realpath(ROOT_PATH.DS.CLASSES_DIR),
//	realpath(ROOT_PATH.DS.PAGES_DIR),
//	realpath(ROOT_PATH.DS.MOD_DIR),
	realpath(ROOT_PATH.DS.INC_DIR),
    realpath(CLASSES_PATH),
//	realpath(ROOT_PATH.DS.TEMPLATE_DIR),
	get_include_path()
)));
<?php
//phpinfo();exit;

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
defined('BASE_PATH') or define('BASE_PATH', dirname(__FILE__));
require_once 'App.php';
require_once 'helpers/BannersHelper.php';
require_once 'helpers/VisitorHelper.php';

App::site();

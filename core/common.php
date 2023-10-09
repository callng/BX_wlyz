<?php

use core\lib\Config;
use core\lib\Route;

error_reporting(0);
ini_set("display_errors", 0);
header("Content-type: text/html;charset=utf-8");
define("BX_ROOT", substr(dirname(__FILE__), 0, -4));
const DS = DIRECTORY_SEPARATOR;
require_once BX_ROOT . "core/lib/Load.php";
spl_autoload_register(["\\core\\lib\\Load", "autoload"]);
require_once BX_ROOT . "core/function.inc.php";
require_once BX_ROOT . "core/version.php";
if (!ini_get("magic_quotes_gpc")) {
    if (!empty($_GET)) {
        $_GET = addslashes_deep($_GET);
    }
    if (!empty($_POST)) {
        $_POST = addslashes_deep($_POST);
    }
    $_COOKIE = addslashes_deep($_COOKIE);
    $_REQUEST = addslashes_deep($_REQUEST);
}
Config::set(require BX_ROOT . 'config/config.php');
date_default_timezone_set(Config::get('default_timezone'));
$bx_route_files = Config::get('route_config_file');
foreach ($bx_route_files as $i) {
    Route::addRule(include BX_ROOT . "config/" . $i . ".php");
}
Route::init();
Route::load();

function curl_get_contents($url, $timeout = 2){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
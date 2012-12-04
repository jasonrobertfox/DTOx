<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
ini_set('xdebug.collect_params', 0);
set_time_limit(60);
ini_set('memory_limit', '32M');
define('DEAFULT_TIMEZONE', 'America/New_York');
date_default_timezone_set(DEAFULT_TIMEZONE);

$projectRoot = __DIR__ . "/../..";

$vendorAutoload = $projectRoot . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    $loader = include $vendorAutoload;
}

$source = $projectRoot . DIRECTORY_SEPARATOR . 'src';
$path = array(
    $projectRoot, $source
);
set_include_path(implode(PATH_SEPARATOR, $path) . PATH_SEPARATOR . get_include_path());
unset($projectRoot);

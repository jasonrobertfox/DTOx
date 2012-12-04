#!/usr/bin/env php
# app/console
<?php

$projectRoot = __DIR__ . "/..";
$vendorAutoload = $projectRoot . DIRECTORY_SEPARATOR . 'vendor/autoload.php';


// $applicationModule = $projectRoot . DIRECTORY_SEPARATOR . 'module/Application/src';
$path = array(
    $projectRoot//, $applicationModule
);
set_include_path(implode(PATH_SEPARATOR, $path) . PATH_SEPARATOR . get_include_path());

require $vendorAutoload;

use DTOBuilder\GreetCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new GreetCommand);
$application->run();
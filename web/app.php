<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2013, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
    'twig.path' => array(__DIR__.'/../views', __DIR__.'/../views/layouts')
    )
);

$app->get(
    '/',
    function () use ($app) {
        return $app['twig']->render('home.html.twig');
    }
);
$app['debug'] = true;
$app['exception_handler']->disable();
$app->run();

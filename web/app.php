<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2013, Jason Fox (jasonrobertfox.com)
 * @license     This source file is the property of Jason Fox and may not be redistributed in part or its entirty without the expressed written consent of Jason Fox.
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

// TODO: This hack should be pulled out somewhere.
function isValid($dtoInfo)
{
    return property_exists($dtoInfo, 'name')
    && property_exists($dtoInfo, 'namespace')
    && property_exists($dtoInfo, 'vars')
    && count($dtoInfo->vars) > 0;
}

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

$app->post(
    '/dto/',
    function (Request $request) use ($app) {
        $dtoInfo = json_decode($request->getContent());

        $returnData = new \StdClass();
        if (isValid($dtoInfo)) {
            $variablesArray = array();
            $testDataArray = array();
            foreach ($dtoInfo->vars as $var) {
                $variablesArray[$var->name] = $var->type;
                $testDataArray[$var->name] = $var->testData;
            }
            $generator = new DTOx\Generator\DTO($dtoInfo->name, $dtoInfo->namespace, $variablesArray);
            $returnData->dto = $generator->generate();
            $generator = new DTOx\TestGenerator\DTOUnit($dtoInfo->name, $dtoInfo->namespace, $testDataArray);
            $returnData->test = $generator->generate();
        }
        return $app->json($returnData);
    }
);
$app['debug'] = true;
$app['exception_handler']->disable();
$app->run();

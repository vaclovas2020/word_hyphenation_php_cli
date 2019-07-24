<?php


use Core\AppContainer;
use Exception\ApiException;

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/Core/AutoLoader.php');
Core\AutoLoader::register(true);
$container = new AppContainer(
    array(
        'document_root' => "{$_SERVER['DOCUMENT_ROOT']}/",
        'allowed_api_methods' => array('GET', 'POST', 'PUT', 'DELETE')
    )
);
$container->getApiObject('API\WordsController', 'words');
$container->getApiObject('API\PatternsController', 'patterns');
try {
    $container->getRouter()->route();
} catch (ApiException $e) {
    $container->getRouter()->getResponse()->sendErrorJson($e->getMessage(), $e->getHttpStatus());
}
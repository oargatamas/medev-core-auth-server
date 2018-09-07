<?php


use MedevAuth\Application\Auth\MedevSuiteAuthService;
use MedevAuth\Services\Auth\OAuth\GrantType\Password\PasswordGrant;
use MedevAuth\Services\Auth\OAuth\GrantType\RefreshToken\RefreshTokenGrant;
use MedevSlim\Core\ErrorHandlers\APIExceptionHandler;
use MedevSlim\Core\ErrorHandlers\NotAllowedHandler;
use MedevSlim\Core\ErrorHandlers\NotFoundHandler;
use MedevSlim\Core\ErrorHandlers\PHPRuntimeHandler;
use Medoo\Medoo;


$application = new Slim\App(["settings" => ["displayErrorDetails" => true]]);

$container = $application->getContainer();


$container["errorHandler"] = function () use ($container) {
    return new APIExceptionHandler($container->get('settings')['displayErrorDetails']);
};

$container["phpErrorHandler"] = function () {
    return new PHPRuntimeHandler();
};
$container["notFoundHandler"] = function () {
    return new NotFoundHandler();
};
$container["notAllowedHandler"] = function () {
    return new NotAllowedHandler();
};


$container["database"] = function ($container) {
    $db = new Medoo(
        ['database_type' => 'mysql',
        'database_name' => 'medevsuite_auth',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',]
    );

    return $db;
};


$authorization = new MedevSuiteAuthService($application);

$authorization->register("/oauth");

$authorization->addGrantType(new PasswordGrant($container, true));

$authorization->addGrantType(new RefreshTokenGrant($container));




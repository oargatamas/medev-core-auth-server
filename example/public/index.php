<?php


use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\Services\Auth\User\UserService;
use MedevAuthExample\Sample\ProtectedResourceService;
use MedevSlim\Core\View\TwigView;


include(__DIR__ . "/../../vendor/autoload.php");

$application = \MedevSlim\Core\Application\MedevApp::fromJsonFile(__DIR__."/../config/config.json");
$config = $application->getConfiguration();

$container = $application->getContainer();
TwigView::inject($container);

$authServer = new OAuthService($application);
$authServer->registerService("");

$userService = new UserService($application);
$userService->registerService("/user");


$protectedService = new ProtectedResourceService($application);
$protectedService->registerService("/api");


$session = $config["authorization"]["session"];
session_set_cookie_params($session["lifetime"],$session["path"],$session["domain"],true,true);

session_start();
$application->run();




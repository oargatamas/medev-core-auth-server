<?php


use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuthExample\Sample\ProtectedResourceService;
use MedevSlim\Core\View\TwigView;


include(__DIR__ . "/../../vendor/autoload.php");

$application = \MedevSlim\Core\Application\MedevApp::fromJsonFile(__DIR__."/../config/config.json");

$container = $application->getContainer();
TwigView::inject($container);

$authServer = new OAuthService($application);
$authServer->registerService("");


$protectedService = new ProtectedResourceService($application);
$protectedService->registerService("/api");

session_start();
$application->run();


/*
session_start();

echo session_id()."<br/>";

if(isset($_SESSION["AuthParams"])){
    $_SESSION["AuthParams"] += 1;
}else{
    $_SESSION["AuthParams"] = 0;
}

echo $_SESSION["AuthParams"];
*/




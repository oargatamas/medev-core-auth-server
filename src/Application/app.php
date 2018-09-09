<?php


use MedevAuth\Application\Auth\MedevSuiteAuthService;
use MedevAuth\Services\Auth\OAuth\GrantType\Password\PasswordGrant;
use MedevAuth\Services\Auth\OAuth\GrantType\RefreshToken\RefreshTokenGrant;


$application = new Slim\App(["settings" => ["displayErrorDetails" => true]]);

$container = $application->getContainer();



require_once __DIR__."/Setup/database.php";
require_once __DIR__."/Setup/errorhandlers.php";
require_once __DIR__."/Setup/logging.php";


$container["logger"]->debug("Initialising OAuth Service.");
$authorization = new MedevSuiteAuthService($application);
$authorization->register("/oauth");

$authorization->addGrantType(new PasswordGrant($container, true));
$authorization->addGrantType(new RefreshTokenGrant($container));



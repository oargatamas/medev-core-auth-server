<?php


use MedevAuth\Application\Auth\MedevSuiteAuthService;
use MedevAuth\Services\Auth\OAuth\GrantType\Password\PasswordGrant;
use MedevAuth\Services\Auth\OAuth\GrantType\RefreshToken\RefreshTokenGrant;


$application = new Slim\App();

$container = $application->getContainer();


$authorization = new MedevSuiteAuthService($application);

$authorization->addGrantType(new PasswordGrant($container, true));
$authorization->addGrantType(new RefreshTokenGrant($container));


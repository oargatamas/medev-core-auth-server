<?php


use MedevAuth\Services\Auth\OAuth\OAuthService;

$application = new Slim\App();

$container = $application->getContainer();

$authorization = new OAuthService($application);


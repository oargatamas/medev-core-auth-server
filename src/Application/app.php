<?php



use MedevAuth\Application\Auth\MedevSuiteCustomAuthService;
use MedevAuth\Services\Auth\OAuth\GrantType\Password\PasswordGrant;
use MedevAuth\Services\Auth\OAuth\GrantType\RefreshToken\RefreshTokenGrant;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\Token\JWT\JWS\Middleware\JWSRequestValidator;
use Slim\Http\Request;
use Slim\Http\Response;


$application = new Slim\App(["settings" => ["displayErrorDetails" => true]]);

$container = $application->getContainer();

require_once __DIR__."/Setup/logging.php";
require_once __DIR__."/Setup/database.php";
require_once __DIR__."/Setup/errorhandlers.php";


/*
$container["logger"]->debug("Initialising OAuth Service.");

$authorization = new MedevSuiteCustomAuthService($application);
$authorization->register("/oauth");

$container["logger"]->debug("Registering grant types.");
$authorization->addGrantType(new PasswordGrant($container, true));
//$authorization->addGrantType(new RefreshTokenGrant($container));
$container["logger"]->debug("OAuth service up and running.");


*/

//Todo remove it after testing
$application->get("/protected",function(Request $request, Response $response, $args){
    return $response->withStatus(200)->withJson(["message" => "Success"]) ;
});
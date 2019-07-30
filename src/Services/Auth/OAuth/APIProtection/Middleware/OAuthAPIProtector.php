<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 15.
 * Time: 12:03
 */

namespace MedevAuth\Services\Auth\OAuth\APIProtection\Middleware;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\Token\AccessToken\ParseAccessToken;
use MedevAuth\Services\Auth\OAuth\Actions\Token\ValidateToken;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Logging\ComponentLogger;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class OAuthAPIProtector
 * @package MedevAuth\Services\Auth\OAuth\APIProtection
 */
class OAuthAPIProtector implements ComponentLogger
{

    /**
     * @var APIService
     */
    private $service;

    /**
     * OAuthAPIProtector constructor.
     * @param APIService $service
     */
    public function __construct(APIService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->info("Validating client access");

        if ($request->hasHeader("Authorization")) {
            $this->info("Authorization data provided in request header. Extracting access token from request");
            $accessTokenString = str_replace("Bearer ", "", $request->getHeader("Authorization")[0]);
        }else{
            $this->info("Authorization header not found. Extracting token from ".GrantAccess::COOKIE_ACCESS_TOKEN." cookie.");
            $accessTokenString = $request->getCookieParam(GrantAccess::COOKIE_ACCESS_TOKEN,"");
        }

        if(!$accessTokenString){
            throw new UnauthorizedException("Authorization data not provided for the request.");
        }


        $this->info("Access token: " . $accessTokenString);


        $parsedToken = (new ParseAccessToken($this->service))->handleRequest(["token" => $accessTokenString]);

        (new ValidateToken($this->service))->handleRequest(["token" => $parsedToken]);

        $this->info("Enriching inbound request with access meta data.");
        $authorizedRequest = $request->withAttributes(
            [
                OAuthService::AUTH_TOKEN => $parsedToken
            ]
        );

        $this->info("Authorization successful. Sending request to next stage");
        return $next($authorizedRequest, $response);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function debug($message, $args = [])
    {
        $this->service->debug($message, $args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function info($message, $args = [])
    {
        $this->service->info($message, $args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function warn($message, $args = [])
    {
        $this->service->warn($message, $args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function error($message, $args = [])
    {
        $this->service->error($message, $args);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 15.
 * Time: 12:03
 */

namespace MedevAuth\Services\Auth\OAuth\APIProtection;


use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken\ParseAccessToken;
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
        if(!$request->hasHeader("Authorization")){
            throw new UnauthorizedException("Authorization header not set");
        }

        $this->info("Authorization data provided. Extracting access token from request");
        $accessTokenString = str_replace("Bearer ","",$request->getHeader("Authorization"));
        $this->info("Access token: ". $accessTokenString);

        try{
            $parsedToken = (new ParseAccessToken($this->service))->handleRequest(["token" => $accessTokenString]);


            $this->info("Enriching inbound request with access meta data.");
            $authorizedRequest = $request->withAttributes(
                [
                    "scopes" => $parsedToken->getScopes(),
                    "user_id" => $parsedToken->getUser()->getIdentifier(),
                    "client_id" => $parsedToken->getClient()->getIdentifier()
                ]
            );

            $this->info("Authorization successful. Sending request to next stage");
            return $next($authorizedRequest,$response);
        } catch (\Exception $e){
            $this->error("Authorization failed. ".$e->getMessage().$e->getTraceAsString());
            throw new UnauthorizedException($e->getMessage());
        }
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function debug($message, $args = [])
    {
        $this->service->debug($message,$args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function info($message, $args = [])
    {
        $this->service->info($message,$args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function warn($message, $args = [])
    {
        $this->service->warn($message,$args);
    }

    /**
     * @param string $message
     * @param array $args
     */
    public function error($message, $args = [])
    {
        $this->service->error($message,$args);
    }
}
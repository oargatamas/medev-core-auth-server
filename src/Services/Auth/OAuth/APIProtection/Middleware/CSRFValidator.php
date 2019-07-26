<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 07.
 * Time: 15:36
 */

namespace MedevAuth\Services\Auth\OAuth\APIProtection\Middleware;


use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\BadRequestException;
use Slim\Http\Request;
use Slim\Http\Response;

class CSRFValidator implements ComponentLogger
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
     * @return Response
     * @throws BadRequestException
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->info("Checking state tokens to avoid CSRF attack.");

        $CsrfTokenInCookie = $request->getCookieParam("MDV-CSRF-TOKEN");
        $CsrfTokenInRequest = $request->getParam("state");

        if($CsrfTokenInRequest != $CsrfTokenInCookie){
            throw new BadRequestException("CSRF tokens in request does not match! Aborting connection.");
        }
        $this->info("CSRF validation successful.");

        return $next($request,$response);
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
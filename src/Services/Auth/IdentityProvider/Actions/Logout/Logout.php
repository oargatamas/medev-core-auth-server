<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:03
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Logout;


use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\OAuthRequest;
use MedevAuth\Utils\UrlUtils;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class Logout extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        session_destroy();

        $invalidAccessTokenCookie = SetCookie::create(OAuthRequest::COOKIE_ACCESS_TOKEN)
            ->withValue("")
            ->withHttpOnly(true)
            ->withSecure(true)
            ->withDomain(".".UrlUtils::getTopLevelDomain($_SERVER["HTTP_HOST"]))
            ->withPath("/")
            ->expire();

        return FigResponseCookies::set($response,$invalidAccessTokenCookie);
    }


}
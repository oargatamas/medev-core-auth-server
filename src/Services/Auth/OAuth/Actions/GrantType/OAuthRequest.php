<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 19.
 * Time: 9:41
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType;


use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\Utils\UrlUtils;
use MedevSlim\Core\Action\Servlet\APIServlet;
use MedevSlim\Core\Service\APIService;
use Slim\Http\Response;

abstract class OAuthRequest extends APIServlet
{
    const ACCESS_TOKEN = "access_token";
    const ACCESS_TOKEN_TYPE = "token_type";
    const EXPIRES_IN = "expires_in";
    const REFRESH_TOKEN = "refresh_token";

    const COOKIE_ACCESS_TOKEN = "X-MEDEV-TOKEN";


    public function __construct(APIService $service)
    {
        parent::__construct($service);
    }

    /**
     * @var User
     */
    protected $user;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string[]
     */
    protected $scopes;

    /**
     * @var string
     */
    protected $csrfToken;

    protected function mapTokensToCookie(Response $response, $data){
        $accessTokenCookie = SetCookie::create(self::COOKIE_ACCESS_TOKEN)
            ->withValue($data[self::ACCESS_TOKEN])
            ->withHttpOnly(true)
            ->withSecure(true)
            ->withDomain(".".UrlUtils::getTopLevelDomain($_SERVER["HTTP_HOST"]))
            ->withPath("/")
            ->rememberForever();

        $redirectUri = $this->client->getRedirectUri()."?".http_build_query($data[OAuthService::CSRF_TOKEN],"","&",PHP_QUERY_RFC3986);

        return  FigResponseCookies::set($response->withRedirect($redirectUri),$accessTokenCookie);
    }

    protected function mapTokensToUrl(Response $response, $data){
        $redirectUri = $this->client->getRedirectUri()."?".http_build_query($data,"","&",PHP_QUERY_RFC3986);

        return $response->withRedirect($redirectUri);
    }

    protected function mapTokensToRequestBody(Response $response, $data){
        return $response->withJson($data,200);
    }
}
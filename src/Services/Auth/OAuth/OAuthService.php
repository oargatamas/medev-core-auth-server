<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:21
 */

namespace MedevAuth\Services\Auth\OAuth;



use MedevAuth\Services\Auth\OAuth\Action\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Action\RevokeToken;
use MedevAuth\Services\Auth\OAuth\GrantType\GrantType;
use MedevAuth\Token\JWT\JWS\Middleware\JWSRequestValidator;
use MedevSlim\Core\APIService\APIService;

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

class OAuthService extends APIService
{

    const ACCESS_TOKEN_REPO  = "OauthAccessTokenRepository";
    const REFRESH_TOKEN_REPO = "OauthRefreshTokenRepository";
    const CLIENT_REPO        = "OauthClientRepository";
    const USER_REPO          = "OauthUserRepository";
    const SCOPE_REPO         = "OauthScopeRepository";
    const AUTH_CODE_REPO     = "OauthAuthCodeRepository";


    /**
     * @var GrantType[]
     */
    private $grantTypes;



    public function __construct(App $app)
    {
        $this->grantTypes = [];
        parent::__construct($app);
    }


    protected function registerRoutes(App $app, ContainerInterface $container)
    {

    }


    protected function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container)
    {
        //No middleware needed for this service
    }

    protected function registerContainerComponents(ContainerInterface $container)
    {
    }


    public function addGrantType(GrantType $grantType){
        $this->grantTypes[$grantType->getName()] = $grantType;
    }


    public function hasGrantType($grantType = ""){
        return isset($this->grantTypes[$grantType]);
    }


    public function getGrantType($type){
        //Todo improve error handling
        return $this->grantTypes[$type];
    }


    public function getServiceName()
    {
        return "AuthorizationService";
    }

    protected function getLogger()
    {
        // TODO: Implement getLogger() method.
    }
}
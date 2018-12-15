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

    public static $ACCESS_TOKEN_REPO  = "OauthAccessTokenRepository";
    public static $REFRESH_TOKEN_REPO = "OauthRefreshTokenRepository";
    public static $CLIENT_REPO        = "OauthClientRepository";
    public static $USER_REPO          = "OauthUserRepository";
    public static $SCOPE_REPO         = "OauthScopeRepository";
    public static $AUTH_CODE_REPO     = "OauthAuthCodeRepository";


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
        $app->post("/token",new GrantAccess($container, $this));
        $app->post("/token/revoke/{tokenId}",new RevokeToken($container))->add(new JWSRequestValidator($container->get(OAuthService::$ACCESS_TOKEN_REPO)));
    }


    protected function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container)
    {
        //No middleware needed for this service
    }

    protected function registerContainerComponents(ContainerInterface $container)
    {
        //Not used here
    }


    public function addGrantType(GrantType $grantType){
        $this->grantTypes[$grantType->getName()] = $grantType;
    }


    public function hasGrantType($grantType = ""){
        return isset($this->grantTypes[$grantType]);
    }


    public function getGrantType($type){
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
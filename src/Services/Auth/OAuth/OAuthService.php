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
use MedevSlim\Core\APIService\APIService;
use MedevSlim\Core\APIService\Interfaces\ServiceConfiguration;
use MedevSuite\Application\Auth\OAuth\Token\JWT\Middleware\JWSRequestValidator;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;

class OAuthService extends APIService
{

    /**
     * @var GrantType[]
     */
    private $grantTypes;


    /**
     * OAuthService constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->grantTypes = [];
        parent::__construct($app);
    }


    /**
     * @param App $app
     * @param ContainerInterface $container
     */
    protected function registerRoutes(App $app, ContainerInterface $container)
    {
        $app->post("/token",new GrantAccess($container, $this));
        $app->post("/token/revoke/{tokenId}",new RevokeToken($container))->add(new JWSRequestValidator($container->get("OauthAccessTokenRepository")));
    }

    /**
     * @param RouteGroupInterface $group
     * @param ContainerInterface $container
     */
    protected function registerMiddlewares(RouteGroupInterface $group, ContainerInterface $container)
    {
        //No middleware needed for this service
    }

    protected function registerIOCComponents(ContainerInterface $container)
    {
        // Not used here.
    }

    /**
     * @param GrantType $grantType
     */
    public function addGrantType(GrantType $grantType){
        $this->grantTypes[$grantType->getName()] = $grantType;
    }

    /**
     * @param string $grantType
     * @return bool
     */
    public function hasGrantType($grantType = ""){
        return isset($this->grantTypes[$grantType]);
    }

    /**
     * @param $type
     * @return GrantType
     */
    public function getGrantType($type){
        return $this->grantTypes[$type];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:40
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType\Password;


use MedevAuth\Services\Auth\OAuth\GrantType\GrantType;
use MedevAuth\Services\Auth\OAuth\Repository\OAuthUserRepository;
use MedevAuth\Services\Auth\OAuth\Repository\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PasswordGrant extends GrantType
{

    /**
     * @var TokenRepository
     */
    private $refreshTokenRepository;
    /**
     * @var OAuthUserRepository
     */
    private $userRepository;
    private $grantWithRefreshToken;



    public function __construct(ContainerInterface $container,$grantWithRefreshToken = false)
    {
        $this->grantWithRefreshToken = $grantWithRefreshToken;
        $this->userRepository = $container->get("OauthUserRepository");
        if($grantWithRefreshToken){
            $this->refreshTokenRepository = $container->get("OauthRefreshTokenRepository");
        }
        parent::__construct($container);
    }


    protected function validateCredentials(Request $request)
    {
        $username = $request->getParsedBodyParam("username","");
        $password = $request->getParsedBodyParam("password","");

        return $this->userRepository->IsCredentialsValid($username,$password);
    }

    protected function grantAccess(Response $response, $args = [])
    {
        $data = [];

        $accessToken = $this->accessTokenRepository->generateToken($args);
        $this->accessTokenRepository->persistToken($accessToken);


        $data["token_type"] = "Bearer";
        $data["access_token"] = $accessToken;


        if ($this->grantWithRefreshToken) {

            $refreshToken = $this->refreshTokenRepository->generateToken($args);
            $this->refreshTokenRepository->persistToken($accessToken);

            $data["refresh_token"] = $refreshToken;
        }


        $response->withStatus(200);
        $response->withJson($data);
        return $response;
    }


    public function getName()
    {
        return "password";
    }
}
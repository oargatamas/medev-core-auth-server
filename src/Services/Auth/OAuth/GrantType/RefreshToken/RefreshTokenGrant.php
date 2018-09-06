<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:39
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType\RefreshToken;



use MedevAuth\Services\Auth\OAuth\GrantType\GrantType;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class RefreshTokenGrant extends GrantType
{

    /**
     * @var TokenRepository
     */
    private $refreshTokenRepository;


    public function getName()
    {
        return "refresh_token";
    }

    protected function validateCredentials(Request $request)
    {
        $refreshToken = $request->getParsedBodyParam("refresh_token","");

        return $this->refreshTokenRepository->validateToken($refreshToken);
    }


    protected function grantAccess(Response $response, $args = [])
    {
        $data = [];

        $accessToken = $this->accessTokenRepository->generateToken($args);
        $this->accessTokenRepository->persistToken($accessToken);

        $data["token_type"] = "Bearer";
        $data["access_token"] = $accessToken;

        $response->withStatus(200);
        $response->withJson($data);
        return $response;
    }

    public function setRefreshTokenProvider(TokenRepository $tokenRepository)
    {
        $this->refreshTokenRepository = $tokenRepository;
    }
}
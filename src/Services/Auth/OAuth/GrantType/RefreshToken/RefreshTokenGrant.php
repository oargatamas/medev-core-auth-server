<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:39
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType\RefreshToken;




use MedevAuth\Services\Auth\OAuth\GrantType\GrantType;
use MedevSlim\Core\APIService\Exceptions\APIException;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;


class RefreshTokenGrant extends GrantType
{


    public function __construct(ContainerInterface $container, $provideRefreshTokens = false)
    {
        $requiredParams = [
            "grant_type",
            "client_id",
            "refresh_token"
        ];
        parent::__construct($container, $provideRefreshTokens, $requiredParams);
    }


    /**
     * @param Request $request
     * @return Request
     * @throws APIException
     */
    protected function validateRequest(Request $request)
    {
        $clientId = $request->getParsedBodyParam("client_id");
        $clientSecret = $request->getParsedBodyParam("client_secret");
        $refreshToken = $request->getParsedBodyParam("refresh_token");


        $this->clientRepository->validateClient($clientId,$clientSecret,isset($clientSecret));

        /** @var TokenEntityInterface $token */
        $token = $this->refreshTokenRepository->validateSerializedToken($refreshToken);


        return $request->withAttributes([
            "old_refresh_token" => $token,
            "user_entity" => $token->getUser(),
            "client_entity" => $token->getClient()
        ]);
    }


    public function getName()
    {
        return "refresh_token";
    }
}
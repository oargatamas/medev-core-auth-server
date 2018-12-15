<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:40
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType\Password;


use MedevAuth\Services\Auth\OAuth\GrantType\GrantType;
use MedevAuth\Services\Auth\OAuth\Repository\UserRepositoryInterface;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;

class PasswordGrant extends GrantType
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(ContainerInterface $container, $provideRefreshTokens = false)
    {
        $requiredParams = [
            "grant_type",
            "client_id",
            "client_secret",
            "username",
            "password"
        ];
        parent::__construct($container, $provideRefreshTokens, $requiredParams);
    }


    /**
     * @param Request $request
     * @return Request
     * @throws UnauthorizedException
     */
    protected function validateRequest(Request $request)
    {
        $clientId = $request->getParsedBodyParam("client_id");
        $clientSecret = $request->getParsedBodyParam("client_secret");
        $username = $request->getParsedBodyParam("username");
        $password = $request->getParsedBodyParam("password");


        $client = $this->clientRepository->validateClient($clientId,$clientSecret,isset($clientSecret));

        $user = $this->userRepository->validateUser($username, $password);

        $oldRefreshToken = $this->refreshTokenRepository->getTokenForUser($user);

        return $request->withAttributes([
            "old_refresh_token" => $oldRefreshToken,
            "user_entity" => $user,
            "client_entity" => $client
        ]);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return "password";
    }
}
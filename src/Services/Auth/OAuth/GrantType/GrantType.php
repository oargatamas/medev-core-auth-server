<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:57
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType;



use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\Services\Auth\OAuth\Repository\ClientRepository;
use MedevAuth\Services\Auth\OAuth\Repository\ScopeRepository;
use MedevAuth\Services\Auth\OAuth\Repository\TokenRepository;
use MedevSlim\Core\APIAction\APIAction;
use MedevSlim\Core\APIService\Exceptions\BadRequestException;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class GrantType extends APIAction
{

    /**
     * @var boolean
     */
    protected $provideRefreshTokens;


    /**
     * @var array
     */
    protected $requiredParams;

    /**
     * @var TokenRepository
     */
    protected $accessTokenRepository, $refreshTokenRepository;

    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * @var ScopeRepository
     */
    protected $scopeRepository;


    public function __construct(ContainerInterface $container, $provideRefreshTokens = false, $requiredParams = [])
    {
        $this->clientRepository = $container->get(OAuthService::$CLIENT_REPO);
        $this->accessTokenRepository = $container->get(OAuthService::$ACCESS_TOKEN_REPO);
        $this->scopeRepository = $container->get(OAuthService::$SCOPE_REPO);
        $this->provideRefreshTokens = $provideRefreshTokens;
        if($provideRefreshTokens){
            $this->refreshTokenRepository = $container->get(OAuthService::$REFRESH_TOKEN_REPO);
        }
        $this->requiredParams = $requiredParams;
        parent::__construct($container,[]);
    }

    public abstract function getName();

    protected function onPermissionGranted(Request $request, Response $response, $args)
    {
        if (!$this->hasRequiredPostParams($request)){
            throw new BadRequestException();
        }
        $validatedRequest = $this->validateRequest($request);

        return $this->grantAccess($validatedRequest,$response);
    }

    protected abstract function validateRequest(Request $request);


    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    protected function grantAccess(Request $request, Response $response)
    {
        /** @var OAuthToken $oldRefreshToken */
        $oldRefreshToken = $request->getAttribute("old_refresh_token");
        /** @var User $user */
        $user = $request->getAttribute("user_entity");
        /** @var Client $client */
        $client = $request->getAttribute("client_entity");


        $accessToken = $this->accessTokenRepository->generateToken($client,$user,$this->scopeRepository->getUserScopes($user));
        $this->accessTokenRepository->persistToken($accessToken);

        $data = [];
        $data["token_type"] = "Bearer";
        $data["access_token"] = $accessToken->finalizeToken();
        $data["expires_in"] = $accessToken->getExpiration();

        if($this->provideRefreshTokens){
            $refreshToken = $this->refreshTokenRepository->generateToken($client,$user,$this->scopeRepository->getRefreshTokenScopes());
            $this->refreshTokenRepository->revokeToken($oldRefreshToken->getIdentifier());
            $this->refreshTokenRepository->persistToken($refreshToken);
            $data["refresh_token"] = $refreshToken->finalizeToken();
        }


        return $response->withStatus(200)->withJson($data);
    }

    protected function hasRequiredPostParams(Request $request){
        return $this->hasParams($request->getParsedBody(),$this->requiredParams);
    }

    protected function hasRequiredGetParams(Request $request){
        return $this->hasParams($request->getQueryParams(),$this->requiredParams);
    }

    private function hasParams($array, $requiredParams){
        foreach ($requiredParams as $item){
            if(!property_exists($array, $item)){
                return false;
            }
        }
        return true;
    }
}
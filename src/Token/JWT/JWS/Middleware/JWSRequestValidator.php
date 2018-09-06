<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:50
 */

namespace MedevSuite\Application\Auth\OAuth\Token\JWT\Middleware;

use Exception;
use Lcobucci\JWT\Token\Parser;
use MedevAuth\APIService\Exceptions\UnauthorizedException;
use MedevAuth\Token\JWT\JWS\JWSValidator;
use MedevSuite\Application\Auth\OAuth\Token\JWT\JWS\JWS;
use MedevSuite\Application\Auth\OAuth\Token\JWT\JWS\JWSRepository;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


class JWSRequestValidator
{

    /**
     * @var JWSRepository
     */
    private $jwsRepo;

    public function __construct(ContainerInterface $container)
    {
        $this->jwsRepo = $container->get("OauthAccessTokenRepository");
    }


    public function __invoke(Request $request, Response $response, callable $next)
    {
        try {
            if (!$request->hasHeader("Authorization")) {
                throw new Exception("Authorization header missing");
            }

            $tokenString = substr($request->getHeader("Authorization"), strlen("Bearer "));


            $jws = $this->jwsRepo->deserialize($tokenString);

            //this will throw Exception if the token not valid.
            $this->jwsRepo->validateToken($jws);

            $request->withAttribute("access_token", $jws);
            $request->withAttribute("scopes", $jws->getClaim("scopes"));

            $response = $next($request, $response);
            return $response;


        } catch (\Exception $e) {
            //Todo log error message before printing out the response with 401
            throw new UnauthorizedException();
        }
    }
}
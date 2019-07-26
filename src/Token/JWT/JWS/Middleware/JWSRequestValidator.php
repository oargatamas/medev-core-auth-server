<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 09.
 * Time: 9:50
 */

namespace MedevAuth\Token\JWT\JWS\Middleware;

use MedevAuth\Token\JWT\JWS\Repository\JWSRepository;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;


class JWSRequestValidator
{

    /**
     * @var JWSRepository
     */
    private $jwsRepo;

    public function __construct(JWSRepository $repository)
    {
        $this->jwsRepo = $repository;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     * @throws UnauthorizedException
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {

        if (!$request->hasHeader("Authorization")) {
            throw new UnauthorizedException("Authorization header missing");
        }

        $tokenString = substr($request->getHeader("Authorization"), strlen("Bearer "));

        //this will throw Exception if the token not valid.
        $jws = $this->jwsRepo->validateSerializedToken($tokenString);

        //$request->withAttribute("access_token", $jws); //Todo move key to static field
        $request->withAttribute("scopes", $jws->getScopes()); //Todo move key to static field

        $response = $next($request, $response);
        return $response;
    }
}
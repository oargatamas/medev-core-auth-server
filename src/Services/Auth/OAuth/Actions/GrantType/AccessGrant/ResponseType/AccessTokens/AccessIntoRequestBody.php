<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 18.
 * Time: 9:34
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\ResponseType\AccessTokens;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\ResponseType\HttpResponseGenerator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

class AccessIntoRequestBody extends HttpResponseGenerator
{

    /**
     * @param Response $response
     * @param $data
     * @return ResponseInterface
     */
    protected function mapDataToResponse(Response $response, $data)
    {
        // TODO: Implement mapDataToResponse() method.
    }
}
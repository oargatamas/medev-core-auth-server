<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 18.
 * Time: 9:26
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\ResponseType;


use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

abstract class HttpResponseGenerator
{
    /**
     * @param Response $response
     * @param $data
     * @return ResponseInterface
     */
    public function generateResponse(Response $response, $data){
        //Todo add CSRF mapping here
        return $this->mapDataToResponse($response,$data);
    }

    /**
     * @param Response $response
     * @param $data
     * @return ResponseInterface
     */
    protected abstract function mapDataToResponse(Response $response, $data);
}
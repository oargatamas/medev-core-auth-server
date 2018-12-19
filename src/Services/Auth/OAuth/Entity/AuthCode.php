<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 15:03
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


class AuthCode extends DatabaseEntity
{

    /**
     * @var string
     */
    private $code;
    /**
     * @var Client
     */
    private $client;

    /**
     * @return string
     */
    public function getCode(){
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code){
        $this->code = $code;
    }

    /**
     * @return Client
     */
    public function getClient(){
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client){
        $this->client = $client;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 17:04
 */

namespace MedevAuth\Token\JWT;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use MedevAuth\Services\Auth\OAuth\Entity\GenericToken;

class JWT extends GenericToken
{

    /**
     * @var Token
     */
    protected $jwt;



    /**
     * @param string $serializedToken
     * @return JWT
     */
    public static function fromString($serializedToken){
        $jwt = (new Parser())->parse($serializedToken);

        $token = new JWT();
        $token->setJwt($jwt);

        $token->setIdentifier($jwt->getHeader("jti"));
        $token->setExpiration($jwt->getClaim("exp"));
        $token->setScopes($jwt->getClaim("scopes"));
        //Todo find out how can we add Client, User and Privatekey content from here

        return $token;
    }

    /**
     * @param Token $jwt
     */
    public function setJwt(Token $jwt)
    {
        $this->jwt = $jwt;
    }



    /**
     * @return string
     */
    public function finalizeToken()
    {
        $token = (new Builder())
            ->setId($this->identifier, true)
            ->setSubject($this->user->getIdentifier())
            ->setAudience($this->client->getIdentifier())
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration($this->expiration)
            ->set("scopes", $this->scopes) //Todo Move key to static field
            ->getToken();

        return $token->__toString();
    }


}
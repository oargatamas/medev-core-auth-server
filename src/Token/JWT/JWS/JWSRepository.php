<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 15.
 * Time: 16:02
 */

namespace MedevSuite\Application\Auth\OAuth\Token\JWT\JWS;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use MedevAuth\Token\JWT\JWS\JWSConfiguration;
use MedevAuth\Token\JWT\JWT;
use MedevAuth\Token\TokenEntity;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Container;

abstract class JWSRepository implements TokenRepository
{
    /**
     * @var JWSConfiguration
     */
    private $config;

    public function __construct(ContainerInterface $container, JWSConfiguration $config)
    {
        $this->config = $config;
        parent::__construct($container);
    }

    public function generateToken($args = [])
    {
        $token = new Builder();

        //Setting public claims
        $token->setHeader("jti", $this->config->getJTI());
        $token->set("sub", $this->config->getSUB());
        $token->set("iss", $this->config->getISS());
        $token->set("aud", $this->config->getAUD());
        $token->set("iat", $this->config->getIAT());
        $token->set("exp", $this->config->getEXP());
        $token->set("nbf", $this->config->getNBF());

        //Private claims will be set by the final implementation
        foreach ($this->getPrivateClaims($args) as $key => $value) {
            $token->set($key, $value);
        }

        return $this->applySignature($token);
    }

    protected abstract function getPrivateClaims($args = []);


    protected function applySignature(Builder $token)
    {
        $signer = new Sha256();
        $keychain = new Keychain();

        $token->sign($signer, $keychain->getPrivateKey($this->config->getPrivateKey()));

        $token = $token->getToken();

        return $token;
    }


    public function deserialize($jwsString)
    {
        return (new Parser())->parse($jwsString);
    }

    public function validateToken(Token $token)
    {
        if (!$this->isSignatureValid($token)) {
            throw new \Exception("Invalid token signature");
        }

        if ($this->isTokenBlacklisted($token->getHeader("jti"))) {
            throw new \Exception("Token is blacklisted");
        }

        return $token;
    }

    public function isSignatureValid(Token $token)
    {
        $signer = new Sha256();
        $keychain = new Keychain();

        return $token->verify($signer, $keychain->getPublicKey($this->config->getPublicKey()));
    }

    public abstract function isTokenBlacklisted(Token $token);
}
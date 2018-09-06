<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevSuite\Application\Auth\OAuth\Token;


use Lcobucci\JWT\Token;

interface TokenRepository
{
    public function generateToken($args = []);

    public function persistToken(Token $token);

    public function revokeToken(Token $token);

    public function validateToken($serializedToken);
}
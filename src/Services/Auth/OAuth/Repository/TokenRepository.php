<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 10.
 * Time: 10:21
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;




use Lcobucci\JWT\Token;


interface TokenRepository
{

    public function generateToken($args = []);

    public function persistToken(Token $token);

    public function revokeToken($tokenId);

    public function validateToken(Token $token);
}
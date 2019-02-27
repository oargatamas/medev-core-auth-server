<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 9:43
 */

namespace MedevAuth\Utils;


use Lcobucci\JWT\Signer\Key;
use MedevAuth\Services\Auth\OAuth\Exceptions\OAuthException;

/**
 * Class CryptUtils
 * @package MedevAuth\Utils
 */
class CryptUtils
{
    /**
     * @param $keyconfig
     * @return Key
     * @throws OAuthException
     */
    public static function getKeyFromConfig($keyconfig){

        if(!isset($keyconfig["path"])){
            throw new OAuthException("Key configuration not set properly. Key or Passphrase definition is missing in the application config.");
        }

        $path = "file://".$_SERVER["DOCUMENT_ROOT"].$keyconfig["path"];
        $passphrase = $keyconfig["passphrase"] ?? null;

        return new Key($path,$passphrase);
    }
}
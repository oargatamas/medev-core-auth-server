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
        //Todo improve it to find a keys from the config root.
        $content = $keyconfig["key"];
        $passphrase = $keyconfig["passphrase"];

        if(!isset($keyconfig["key"]) || !isset($keyconfig["passphrase"])){
            throw new OAuthException("Key configuration not set properly. Key or Passphrase definition is missing in the application config.");
        }

        return new Key($content,$passphrase);
    }
}
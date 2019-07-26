<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 04.
 * Time: 14:27
 */

namespace MedevAuth\Utils;


use phpseclib\Crypt\RSA;

/**
 * Class CryptUtils
 * @package MedevAuth\Utils
 */
class CryptUtils
{
    /**
     * @param string[] $config
     * @return RSA
     */
    public static function getRSAKeyFromConfig($config){
        $key = new RSA();

        if(array_key_exists("passphrase",$config)){
            $key->setPassword($config["passphrase"]);
        }

        $key->loadKey($config["content"]);

        return $key;
    }

}
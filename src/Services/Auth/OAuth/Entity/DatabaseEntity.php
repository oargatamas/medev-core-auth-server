<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:57
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


abstract class DatabaseEntity
{
    private $id;

    public function getIdentifier(){
        return $this->id;
    }

    public function setIdentifier($identifier){
        $this->id = $identifier;
    }
}
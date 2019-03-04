<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:57
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\MedooPersistable;

abstract class DatabaseEntity implements MedooPersistable
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @return string
     */
    public function getIdentifier(){
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier){
        $this->identifier = $identifier;
    }
}
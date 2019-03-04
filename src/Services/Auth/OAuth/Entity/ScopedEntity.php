<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 10:50
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


/**
 * Class ScopedEntity
 * @package MedevAuth\Services\Auth\OAuth\Entity
 */
abstract class ScopedEntity extends DatabaseEntity
{
    /**
     * @var string[]
     */
    protected $scopes;

    /**
     * @return string[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param string[] $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * @param string $scope
     */
    public function addScope($scope){
        $this->scopes[] = $scope;
    }
}
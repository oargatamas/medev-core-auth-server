<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 10:53
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;


use MedevAuth\Services\Auth\OAuth\Entity\DatabaseEntity;

/**
 * Interface MedooPersistable
 * @package MedevAuth\Services\Auth\OAuth\Entity\Persistables
 */
interface MedooPersistable
{
    /**
     * @param $storedData
     * @return DatabaseEntity
     */
    public static function fromAssocArray($storedData);

    /**
     * @return string
     */
    public static function getTableName();

    /**
     * @return string[]
     */
    public static function getColumnNames();
}
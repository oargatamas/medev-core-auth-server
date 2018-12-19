<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 10:01
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use Medoo\Medoo;

class SQLRepository
{

    /**
     * @var Medoo
     */
    protected $db;

    /**
     * @return Medoo
     */
    public function getDb(){
        return $this->db;
    }
    /**
     * @param Medoo $db
     */
    public function setDb($db){
        $this->db = $db;
    }
}
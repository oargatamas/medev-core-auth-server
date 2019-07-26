<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 27.
 * Time: 10:49
 */

$options = [ 'cost' => 12];

$password = password_hash("password1234",PASSWORD_BCRYPT,$options);

echo $password;

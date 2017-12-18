<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 17/12/17
 * Time: 21:25
 */
//require ('db_config.php');
class RoleDB
{
    public static function getRoleID($role){
        $db = DB::getDBConnection();

        $query = 'SELECT * from rolemaster 
                  where RoleName = :role';
        $statement = $db->prepare($query);
        $statement->bindValue(':role',$role);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        return $row['RoleId'];
    }
}
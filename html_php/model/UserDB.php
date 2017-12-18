<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 17/12/17
 * Time: 19:16
 */
require ('db_config.php');

class UserDB
{
    public static function addUser($user){
        $db = DB::getDBConnection();

        $roleID = $user->getRoleID();
        $companyID = $user->getCompanyID();
        $userName = $user->getUserName();
        $password = $user->getPassword();

        $query = 'INSERT INTO usermaster(RoleId,CompanyId,UserName,Password) 
               VALUES(:roleID,:companyID,:userName,:password)';

        $statement = $db->prepare($query);
        $statement->bindValue(':roleID',$roleID);
        $statement->bindValue(':companyID',$companyID);
        $statement->bindValue(':userName',$userName);
        $statement->bindValue(':password',$password);
        $statement->execute();
        $statement->closeCursor();
    }
}
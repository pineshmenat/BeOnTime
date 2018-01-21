<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 17/12/17
 * Time: 19:16
 */
//require ('db_config.php');
//include '../model/db_config.php';
class UserDB
{
    public static function addUser($user){
        $db = DB::getDBConnection();

        $roleID = $user->getRoleID();
        $companyID = $user->getCompanyID();
        $userName = $user->getUserName();
        $password = $user->getPassword();
        $firstname = $user->getFirstName();
        $lastname = $user->getLastName();
        $email = $user->getEmail();
        $sin = $user->getSin();
        $address = $user->getAddress();
        $city = $user->getCity();
        $province = $user->getProvince();
        $postalcode = $user->getPostalCode();
        $phone = $user->getPhone();
        $query = //'SET FOREIGN_KEY_CHECKS=0;
                'INSERT INTO usermaster (RoleId,CompanyId,UserName,Password,FirstName,LastName,EMail,SIN,Address,City,
Province, PostalCode,phone) 
               VALUES(:roleID,:companyID,:userName,:password,:firstname,:lastname,:email,:sin,:address,:city,:province,
               :postalcode,:phone)';
               //SET FOREIGN_KEY_CHECKS=1;';

        $statement = $db->prepare($query);
        $statement->bindValue(':roleID',$roleID);
        $statement->bindValue(':companyID',$companyID);
        $statement->bindValue(':userName',$userName);
        $statement->bindValue(':password',$password);
        $statement->bindValue(':firstname',$firstname);
        $statement->bindValue(':lastname',$lastname);
        $statement->bindValue(':email',$email);
        $statement->bindValue(':sin',$sin);
        $statement->bindValue(':address',$address);
        $statement->bindValue(':city',$city);
        $statement->bindValue('province',$province);
        $statement->bindValue(':postalcode',$postalcode);
        $statement->bindValue(':phone',$phone);
        $statement->execute();
        $lastid = $db->lastInsertId();
        $statement->closeCursor();

        return $lastid;
    }

    public static function checkUser($username){
        $db = DB::getDBConnection();

        $query  = 'SELECT * FROM usermaster where UserName=:username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username',$username);
        $statement->execute();
        $cnt = $statement->rowCount();
        $statement->closeCursor();

        if($cnt == 1){
            return true;
        }
        return false;
    }

    public static function updateUser($user){
        $db = DB::getDBConnection();

        $id = $user->getUserId();
        $email = $user->getUserName();
        $address = $user->getAddress();
        $city = $user->getCity();
        $province = $user->getProvince();
        $postal_code = $user->getPostalCode();
        $phone = $user->getPhone();

        $query = 'UPDATE usermaster SET UserName=:email,EMail=:email,Address=:address,City=:city,Province=:province,
                  PostalCode=:postal_code,Phone=:phone where UserId=:id';

        $statement = $db->prepare($query);
        $statement->bindValue(':email',$email);
        $statement->bindValue(':address',$address);
        $statement->bindValue(':city',$city);
        $statement->bindValue(':province',$province);
        $statement->bindValue(':postal_code',$postal_code);
        $statement->bindValue(':phone',$phone);
        $statement->bindValue(':id',$id);

        $statement->execute();
        $statement->closeCursor();
    }
}
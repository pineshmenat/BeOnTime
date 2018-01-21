<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 15/12/17
 * Time: 11:29
 */

require ('db_config.php');
Class CompanyDB{
 public static function addCompany($company){
     $db = DB::getDBConnection();

     $name = $company->getName();
     $email = $company->getEmail();
     $url = $company->getURL();
     $password = $company->getPassword();
     $streetNumber = $company->getStreetNumber();
     $streetName = $company->getStreetName();
     $city = $company->getCity();
     $province = $company->getProvince();
     $postalCode = $company->getPostalCode();
     $country = $company->getCountry();
     $phone = $company->getPhone();

     $query = 'INSERT INTO companymaster(CompanyName,CompanyEmail,CompanyURL,CompanyPassword,
               CompanyStreetNumber,CompanyStreetName,CompanyCity,CompanyState,CompanyPostal,CompanyCountry,CompanyPhone) 
               VALUES(:name,:email,:url,:password,:streetNumber,:streetName,:city,:province,:postalCode,:country,:phone)';

     $statement = $db->prepare($query);
     $statement->bindValue(':name',$name);
     $statement->bindValue(':email',$email);
     $statement->bindValue(':url',$url);
     $statement->bindValue(':password',$password);
     $statement->bindValue(':streetNumber',$streetNumber);
     $statement->bindValue(':streetName',$streetName);
     $statement->bindValue(':city',$city);
     $statement->bindValue(':province',$province);
     $statement->bindValue(':postalCode',$postalCode);
     $statement->bindValue(':country',$country);
     $statement->bindValue(':phone',$phone);
     $statement->execute();
     //get the id of current inserted row
     $lastid = $db->lastInsertId();
     $statement->closeCursor();

     return $lastid;
 }

 public static function getAllEmployeeID($companyId){
$db = DB::getDBConnection();
$query = 'SELECT UserId FROM usermaster
          where CompanyId = :companyId and RoleId=12';
$statement = $db->prepare($query);
$statement->bindValue(":companyId",$companyId);
$statement->execute();
$row = $statement->fetchAll();
$statement->closeCursor();
return $row;
 }

    public static function getAllProvince($companyId){
        $db = DB::getDBConnection();
        $query = 'SELECT DISTINCT Province FROM usermaster
          where CompanyId = :companyId and RoleId=12';
        $statement = $db->prepare($query);
        $statement->bindValue(":companyId",$companyId);
        $statement->execute();
        $row = $statement->fetchAll();
        $statement->closeCursor();
        return $row;
    }

    public static function getAllCities($companyId){
        $db = DB::getDBConnection();
        $query = 'SELECT DISTINCT City FROM usermaster
          where CompanyId = :companyId and RoleId=12';
        $statement = $db->prepare($query);
        $statement->bindValue(":companyId",$companyId);
        $statement->execute();
        $row = $statement->fetchAll();
        $statement->closeCursor();
        return $row;
    }

    public static function getSelectedEmployee($companyId,$employeeId,$province,$city,$firstname,$lastname){
        $db = DB::getDBConnection();
        if($firstname != "0") {
            $firstname = $firstname.'%';
        }
        if($lastname != "0"){
            $lastname = $lastname.'%';
        }
        if($employeeId != "0"){
            $query = 'SELECT * FROM usermaster where UserId=:employeeId and CompanyId=:companyId and RoleId=12';
            $statement = $db->prepare($query);
            $statement->bindValue(":employeeId",$employeeId);
            $statement->bindValue(":companyId",$companyId);
        }
        else{
            if($province != "0" && $city != "0" && !empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province 
                          and City=:city and FirstName like :firstname and LastName like :lastname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":city",$city);
                $statement->bindValue(":firstname",$firstname);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city == "0" && empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":province",$province);
            }
            else if($province == "0" && $city != "0" && empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and City=:city';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":city",$city);
            }
            else if($province == "0" && $city == "0" && !empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and FirstName like :firstname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":firstname",$firstname);
            }
            else if($province == "0" && $city == "0" && empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and LastName like :lastname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city != "0" && empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province 
                          and City=:city';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":city",$city);
            }
            else if($province == "0" && $city != "0" && !empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province 
                          and FirstName like :firstname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":city",$city);
                $statement->bindValue(":firstname",$firstname);
            }
            else if($province == "0" && $city == "0" && !empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and FirstName like :firstname
                          and LastName like :lastname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":firstname",$firstname);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city == "0" && empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province
                          and LastName like :lastname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city == "0" && !empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province
                          and FirstName like :firstname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":firstname",$firstname);
            }
            else if($province == "0" && $city != "0" && empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and City=:city
                          and LastName like :lastname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":city",$city);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city != "0" && !empty($firstname) && empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province
                          and City=:city and FirstName like :firstname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":city",$city);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":firstname",$firstname);
            }
            else if($province == "0" && $city != "0" && !empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12
                          and City=:city and LastName like :lastname and FirstName like :firstname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":city",$city);
                $statement->bindValue(":firstname",$firstname);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city == "0" && !empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12
                          and Province=:province and LastName like :lastname and FirstName like :firstname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":firstname",$firstname);
                $statement->bindValue(":lastname",$lastname);
            }
            else if($province != "0" && $city != "0" && empty($firstname) && !empty($lastname)){
                $query = 'SELECT * FROM usermaster where CompanyId=:companyId and RoleId=12 and Province=:province
                          and City=:city and LastName like :lastname';
                $statement = $db->prepare($query);
                $statement->bindValue(":companyId",$companyId);
                $statement->bindValue(":city",$city);
                $statement->bindValue(":province",$province);
                $statement->bindValue(":lastname",$lastname);
            }
        }
        $statement->execute();
        $emps = $statement->fetchAll();
        $statement->closeCursor();

        return $emps;
    }

    public static function getEmployeeDetails($userId,$companyId){
        $db = DB::getDBConnection();
        $query = 'SELECT * FROM usermaster
          where CompanyId = :companyId and RoleId=12 and UserId = :userId';
        $statement = $db->prepare($query);
        $statement->bindValue(":companyId",$companyId);
        $statement->bindValue(":userId",$userId);
        $statement->execute();
        $row = $statement->fetchAll();
        $statement->closeCursor();
        return $row;
    }

    public static function updateEmployeeDetails($companyId,$employeeId,$firstName,$lastName,$sin,$email,$address,$city,
            $province,$postalCode){
        $db = DB::getDBConnection();
        $query = 'UPDATE usermaster SET FirstName=:firstName,LastName=:lastName,SIN=:sin,Address=:address,City=:city,
                  Province=:province,PostalCode=:postalCode,EMail=:email where CompanyId = :companyId and RoleId=12 and UserId=:employeeId';
        $statement = $db->prepare($query);
        $statement->bindValue(":firstName",$firstName);
        $statement->bindValue(":lastName",$lastName);
        $statement->bindValue(":sin",$sin);
        $statement->bindValue(":address",$address);
        $statement->bindValue(":city",$city);
        $statement->bindValue(":province",$province);
        $statement->bindValue(":postalCode",$postalCode);
        $statement->bindValue(":email",$email);
        $statement->bindValue(":companyId",$companyId);
        $statement->bindValue(":employeeId",$employeeId);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function getCompanyDetails($companyId){
     $db = DB::getDBConnection();
     $query = 'SELECT * FROM companymaster where CompanyId = :companyId';
     $statement = $db->prepare($query);
     $statement->bindValue(':companyId',$companyId);
     $statement->execute();
     $row = $statement->fetch();
     $statement->closeCursor();

     return new Company($row['CompanyName'],$row['CompanyEmail'],$row['CompanyURL'],$row['CompanyPassword'],
         $row['CompanyStreetNumber'],$row['CompanyStreetName'],$row['CompanyCity'],$row['CompanyState'],
         $row['CompanyPostal'],$row['CompanyCountry'],$row['CompanyPhone']);

    }

    public static function updateCompanyDetails($company){
     $db = DB::getDBConnection();
     $id = $company->getId();
     $name = $company->getName();
     $email = $company->getEmail();
     $url = $company->getURL();
     $phone = $company->getPhone();
     $street_number = $company->getStreetNumber();
     $street_name = $company->getStreetName();
     $city = $company->getCity();
     $province = $company->getProvince();
     $postal_code = $company->getPostalCode();
     $country = $company->getCountry();
     $query = 'UPDATE companymaster SET CompanyName=:name,CompanyEmail=:email,CompanyURL=:url,CompanyPhone=:phone,
                CompanyStreetNumber=:street_number,CompanyStreetName=:street_name,CompanyCity=:city,
                CompanyState=:province,CompanyPostal=:postal_code,CompanyCountry=:country where CompanyId=:id';
     $statement = $db->prepare($query);
     $statement->bindValue(':name',$name);
     $statement->bindValue(':email',$email);
     $statement->bindValue(':url',$url);
     $statement->bindValue(':phone',$phone);
     $statement->bindValue(':street_number',$street_number);
     $statement->bindValue(':street_name',$street_name);
     $statement->bindValue(':city',$city);
     $statement->bindValue(':province',$province);
     $statement->bindValue(':postal_code',$postal_code);
     $statement->bindValue(':country',$country);
     $statement->bindValue(':id',$id);

     $statement->execute();
     $statement->closeCursor();
    }
}
?>
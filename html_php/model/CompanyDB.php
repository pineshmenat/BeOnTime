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

     $query = 'INSERT INTO companymaster(CompanyName,CompanyEmail,CompanyURL,CompanyPassword,
               CompanyStreetNumber,CompanyStreetName,CompanyCity,CompanyState,CompanyPostal,CompanyCountry) 
               VALUES(:name,:email,:url,:password,:streetNumber,:streetName,:city,:province,:postalCode,:country)';

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
     $statement->execute();
     $statement->closeCursor();
 }
}
?>
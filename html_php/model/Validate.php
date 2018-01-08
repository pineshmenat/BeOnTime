<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 3/12/17
 * Time: 12:20
 */

class Validate
{
    public static function isFullName($name){
        $valid = true;
        foreach ($name as $chars){
            if(!(ctype_alpha($chars) || $chars == " ")){
                $valid=false;
                break;
            }
        }
        return $valid;
    }

    public static function validateFullName($fullName){
        if(empty($fullName)){
            return "full name cannot be empty";
        }
        else if(!self::isFullName($fullName)){
            return "no characters except alphabetic allowed";
        }
        else {
            return "";
        }
    }

    public static function validateFirstName($firstName){
        if(empty($firstName)){
            return "first name cannot be empty";
        }
        else if(!ctype_alpha($firstName)){
            return "no characters except alphabetic allowed";
        }
        else{
            return "";
        }
    }

    public static function validateLastName($lastName){
        if(empty($lastName)){
            return "last name cannot be empty";
        }
        else if(!ctype_alpha($lastName)){
            return "no characters except alphanumeric allowed";
        }
        else{
            return "";
        }
    }

    public static function validateCompanyName($name){
        if(empty($name)){
            return "company name cannot be empty";
        }
        else if(ctype_alpha($name)){
            return "no characters except alphanumeric allowed";
        }
        else{
            return "";
        }
    }

    public static function validateEmail($email){
        if(empty($email)){
            return "can't be blank";
        }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return "must be a valid email address, like info@beontime.com";
        }
        else{
            return "";
        }
    }

    public static function validatePhoneNumber($phoneNumber){
        if(empty($phoneNumber)){
            return "phone number cannot be empty";
        }
        else if(!preg_match("/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$phoneNumber)){
            return "invalid phone number";
        }
        else{
            return "";
        }
    }

    public static function validateZipCode($zipCode){
        if(empty($zipCode)){
            return "zip code cannot be left empty";
        }
        else if(!preg_match("/[a-zA-Z0-9][a-zA-Z0-9][a-zA-Z0-9]\s*[a-zA-Z0-9][a-zA-Z0-9][a-zA-Z0-9]/",$zipCode)){
            return "invalid zip code";
        }
        else{
            return "";
        }
    }

    public static function validateCity($city){
        if(empty($city)){
            return "City field cannot be empty";
        }
        else if(!ctype_alpha($city)){
            return "City name invalid";
        }
        else{
            return "";
        }
    }

    public static function validateProvince($province){
        if(empty($province)){
            return "Province field cannot be empty";
        }
        else if(!ctype_alpha($province)){
            return "Province name invalid";
        }
        else{
            return "";
        }
    }

    public static function validateStreet($street){
        if(empty($street)){
            return "Street field cannot be empty";
        }
        else if(!preg_match("/[a-zA-Z]/",$street)){
            return "Street name invalid";
        }
        else{
            return "";
        }
    }

    public static function validateHouseNumber($houseNumber){
        if(empty($houseNumber)){
            return "House number cannot be empty";
        }
        else if(!ctype_digit($houseNumber)){
            return "house number invalid";
        }
        else{
            return "";
        }
    }

    public static function validatePassword($password,$repeatPassword){
        if(empty($password)){
            return "can't be blank";
        }
        elseif(strcmp($password,$repeatPassword) != 0){
            return "does not match confirmation";
        }
        else{
            return "";
        }
    }

    public static function validateURL($url){
        if(empty($url)){
            return "can't be blank";
        }
        else if(!filter_var($url,FILTER_VALIDATE_URL)){
            return "invalid url";
        }
        else{
            return "";
        }
}

    public static function validateCountry($country){
        if(empty($country)){
            return "can't be blank";
        }
        else if(!ctype_alpha($country)){
            return "invalid name";
        }
        else{
            return "";
        }
    }

    public static function validateSINNumber($sinNumber){
        if(empty($sinNumber)){
            return "sin number cannot be empty";
        }
        else if(!preg_match("/^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/",$sinNumber)){
            return "invalid sin number";
        }
        else{
            return "";
        }
    }
}
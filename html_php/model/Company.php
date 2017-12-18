<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 15/12/17
 * Time: 10:42
 */

class Company
{
    private $id;
    private $name;
    private $email, $url,$passowrd;
    private $streetNumber,$streetName,$city,$province,$postalCode,$country;
    private $phone;

    public function __construct($name,$email,$url,$password,$streetNumber,$streetName,$city,$province,$postalCode,$country,$phone)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setURL($url);
        $this->setPassword($password);
        $this->setStreetNumber($streetNumber);
        $this->setStreetName($streetName);
        $this->setCity($city);
        $this->setProvince($province);
        $this->setPostalCode($postalCode);
        $this->setCountry($country);
        $this->setPhone($phone);
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getName(){
        return $this->name;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setURL($url){
        $this->url=$url;
    }

    public function getURL(){
        return $this->url;
    }

    public function setPassword($password){
        $this->passowrd=$password;
    }

    public function getPassword(){
        return $this->passowrd;
    }

    public function setStreetNumber($streetNumber){
        $this->streetNumber = $streetNumber;
    }

    public function getStreetNumber(){
        return $this->streetNumber;
    }

    public function setStreetName($streetName){
        $this->streetName = $streetName;
    }

    public function getStreetName(){
        return $this->streetName;
    }

    public function setCity($city){
        $this->city=$city;
    }

    public function getCity(){
        return $this->city;
    }

    public function setProvince($province){
        $this->province=$province;
    }

    public function getProvince(){
        return $this->province;
    }

    public function setPostalCode($postalCode){
        $this->postalCode=$postalCode;
    }

    public function getPostalCode(){
        return $this->postalCode;
    }

    public function setCountry($country){
        $this->country=$country;
    }

    public function getCountry(){
       return $this->country;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
}

?>
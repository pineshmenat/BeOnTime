<?php
/**
 * Created by PhpStorm.
 * User: imsil
 * Date: 17/12/17
 * Time: 17:50
 */

class User
{
    private $roleID;
    private $companyID;
    private $userName;
    private $password;

    public function __construct($roleID,$companyID,$userName,$password)
    {
        $this->setRoleID($roleID);
        $this->setCompanyID($companyID);
        $this->setUserName($userName);
        $this->setPassword($password);
    }

    public function setRoleID($roleID){
        $this->roleID = $roleID;
    }

    public function getRoleID(){
        return $this->roleID;
    }

    public function setCompanyID($companyID){
        $this->companyID = $companyID;
    }

    /**
     * @return mixed
     */
    public function getCompanyID()
    {
        return $this->companyID;
    }

    public function setUserName($userName){
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
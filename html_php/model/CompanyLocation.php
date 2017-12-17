<?php
/**
 * Created by PhpStorm.
 * User: Vaishnavi
 * Date: 2017-12-09
 * Time: 21:38
 */
class CompanyLocation{
    private $companyId, $companyLocationId, $companyName, $address, $city, $province, $postalCode;

    public function getCompanyId()
    {
        return $this->companyId;
    }
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }
    public function getcompanyLocationId()
    {
        return $this->companyLocationId;
    }
    public function setcompanyLocationId($companyLocationId)
    {
        $this->companyLocationId = $companyLocationId;
    }
    public function getCompanyName()
    {
        return $this->companyName;
    }
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function getProvince()
    {
        return $this->province;
    }
    public function setProvince($province)
    {
        $this->province = $province;
    }
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }
}
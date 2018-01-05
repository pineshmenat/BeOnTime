<?php

/**
 * Created by PhpStorm.
 * User: Vaishnavi
 * Date: 2018-01-01
 * Time: 18:12
 */
class ShiftDetails
{
    private $shiftId, $firstname, $lastName, $empDesignationName, $payPerhour, $startTime, $endTime, $shiftStatus;
    private $shiftAddress, $shiftCity, $shiftPostalCode;

    public function getShiftId()
    {
        return $this->shiftId;
    }

    public function setShiftId($shiftId)
    {
        $this->shiftId = $shiftId;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmpDesignationName()
    {
        return $this->empDesignationName;
    }

    public function setEmpDesignationName($empDesignationName)
    {
        $this->empDesignationName = $empDesignationName;
    }

    public function getPayPerhour()
    {
        return $this->payPerhour;
    }

    public function setPayPerhour($payPerhour)
    {
        $this->payPerhour = $payPerhour;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getShiftStatus()
    {
        return $this->shiftStatus;
    }

    public function setShiftStatus($shiftStatus)
    {
        $this->shiftStatus = $shiftStatus;
    }

    public function getShiftAddress()
    {
        return $this->shiftAddress;
    }

    public function setShiftAddress($shiftAddress)
    {
        $this->shiftAddress = $shiftAddress;
    }

    public function getShiftCity()
    {
        return $this->shiftCity;
    }

    public function setShiftCity($shiftCity)
    {
        $this->shiftCity = $shiftCity;
    }

    public function getShiftPostalCode()
    {
        return $this->shiftPostalCode;
    }

    public function setShiftPostalCode($shiftPostalCode)
    {
        $this->shiftPostalCode = $shiftPostalCode;
    }


}
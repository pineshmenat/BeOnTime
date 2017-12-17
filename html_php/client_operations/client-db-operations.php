<?php
require_once "../model/db_config.php";
require_once "../model/CompanyLocation.php";
/**
 * Created by PhpStorm.
 * User: Vaishnavi
 * Date: 2017-12-09
 * Time: 20:32
 */

/*if(isset($_POST)){
//    print_r($_POST['shiftsDateAndTimeArray']);
    echo "---------------";
    var_dump($_POST);
}*/

class ClientSideDB{
    public static function getCompanyName($companyId)
    {
        $db = DB::getDBConnection();
        $sql = "SELECT CompanyName FROM companymaster where CompanyId=:companyId";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':companyId', $companyId);
        $pdoStmt->execute();
        $result = $pdoStmt->fetch();
        $companyName = $result['CompanyName'];
        $pdoStmt->closeCursor();
        return $companyName;
    }
    public static function getCompanyLocations($companyId)
    {
        $locations = [];
        $db = DB::getDBConnection();
        $sql = "SELECT CompanyLocationId, Address, City, PostalCode FROM companylocationmaster where CompanyId=:companyId";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':companyId', $companyId);
        $pdoStmt->execute();
        $result = $pdoStmt->fetchAll();
        foreach ($result as $c){
            $loc = new CompanyLocation();
            $loc->setCompanyId($companyId);
            $loc->setCompanyLocationId($c['CompanyLocationId']);
            $loc->setAddress($c['Address']);
            $loc->setCity($c['City']);
            $loc->setPostalCode($c['PostalCode']);
            $locations[] = $loc;
        }
        $pdoStmt->closeCursor();
        return $locations;
    }
    public static function getEmployeeDesignations()
    {
        $designations = array();
        $db = DB::getDBConnection();
        $sql = "SELECT empDesignationId, empDesignationName FROM employeeDesignationmaster";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->execute();
        $result = $pdoStmt->fetchAll();
        foreach ($result as $d){
            $designations[$d['empDesignationId']] = $d['empDesignationName'];
        }
        $pdoStmt->closeCursor();
        return $designations;
    }

    public static function insertShifts($employeeDesignationId, $companyId, $companyLocationId, $dateStartTime, $dateEndTime)
    {
        $db = Db::getDBConnection();
        $sql = "INSERT INTO shiftmaster(empDesignationId, AssignedBy, AssignedTo, CompanyId, CompanyLocationId, StartTime, EndTime, ShiftStatus) "
            ."VALUES (:employeeDesignationId, :assignedBy, :assignedTo, :companyId, :companyLocationId, :dateStartTime, :dateEndTime, :shiftStatus)";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':employeeDesignationId', $employeeDesignationId);
        $pdoStmt->bindValue(':assignedBy', 10001);
        $pdoStmt->bindValue(':assignedTo', 10007);
        $pdoStmt->bindValue(':companyId', $companyId);
        $pdoStmt->bindValue(':companyLocationId', $companyLocationId);
        $pdoStmt->bindValue(':dateStartTime', $dateStartTime);
        $pdoStmt->bindValue(':dateEndTime', $dateEndTime);
        $pdoStmt->bindValue(':shiftStatus', 'N');
        $pdoStmt->execute();
        $pdoStmt->closeCursor();
    }
}
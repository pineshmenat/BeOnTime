<?php
require_once "../model/db_config.php";
require_once "../model/CompanyLocation.php";
require_once "../model/ShiftDetails.php";
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
        $sql = "SELECT empDesignationId, empDesignationName FROM employeedesignationmaster";
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
        $sql = "INSERT INTO shiftmaster(empDesignationId, CompanyId, CompanyLocationId, StartTime, EndTime, ShiftStatus) "
            ."VALUES (:employeeDesignationId, :companyId, :companyLocationId, :dateStartTime, :dateEndTime, :shiftStatus)";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':employeeDesignationId', $employeeDesignationId);
        $pdoStmt->bindValue(':companyId', $companyId);
        $pdoStmt->bindValue(':companyLocationId', $companyLocationId);
        $pdoStmt->bindValue(':dateStartTime', $dateStartTime);
        $pdoStmt->bindValue(':dateEndTime', $dateEndTime);
        $pdoStmt->bindValue(':shiftStatus', 'N');
        $pdoStmt->execute();
        $pdoStmt->closeCursor();
    }

    public static function getAllShifts($companyId, $companyLocation, $jobDesignation, $startDate, $endDate)
    {
        $shifts = [];
        $db = Db::getDBConnection();
        $sql = "SELECT ShiftId, UserName, FirstName, LastName, empDesignationName, payPerHour, StartTime, EndTime, ShiftStatus, clm.Address, clm.City, clm.PostalCode"
            ." FROM shiftmaster sm"
            ." INNER JOIN companylocationmaster clm ON sm.CompanyLocationId = clm.CompanyLocationId"
            ." LEFT JOIN usermaster um ON sm.AssignedTo = um.UserId"
            ." INNER JOIN employeedesignationmaster edm ON sm.empDesignationId = edm.empDesignationId"
            ." WHERE sm.CompanyId= :companyId";
        if(!empty($companyLocation))    $sql = $sql." and sm.CompanyLocationId=:companyLocation";
        if(!empty($jobDesignation))    $sql = $sql." and sm.empDesignationId=:jobDesignation";
        if(!empty($startDate))    $sql = $sql." and date(sm.StartTime) >= STR_TO_DATE(:startDate,'%M %d,%Y')";
        if(!empty($endDate))    $sql = $sql." and date(sm.EndTime) <= STR_TO_DATE(:endDate,'%M %d,%Y')";
        $sql = $sql." ORDER BY StartTime";

        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':companyId', $companyId);
        if(!empty($companyLocation))    $pdoStmt->bindValue(':companyLocation', $companyLocation);
        if(!empty($jobDesignation))    $pdoStmt->bindValue(':jobDesignation', $jobDesignation);
        if(!empty($startDate))    $pdoStmt->bindValue(':startDate', $startDate);
        if(!empty($endDate))    $pdoStmt->bindValue(':endDate', $endDate);

        $pdoStmt->execute();
        $result = $pdoStmt->fetchAll();
        foreach ($result as $s) {
            $shift = new ShiftDetails();
            $shift->setShiftId($s['ShiftId']);
            $shift->setFirstname($s['FirstName']);
            $shift->setLastName($s['LastName']);
            $shift->setEmpDesignationName($s['empDesignationName']);
            $shift->setPayPerhour($s['payPerHour']);
            $shift->setStartTime($s['StartTime']);
            $shift->setEndTime($s['EndTime']);
            $shift->setShiftStatus($s['ShiftStatus']);
            $shift->setShiftAddress($s['Address']);
            $shift->setShiftCity($s['City']);
            $shift->setShiftPostalCode($s['PostalCode']);
            $shifts[] = $shift;
        }
        $pdoStmt->closeCursor();
        return $shifts;
    }
    public static function updateClientRatingAndReviewForShift($shiftId, $rating, $clientReview)
    {
        $db = Db::getDBConnection();
        $sql = "UPDATE shiftmaster SET StarRating=:starRating, ClientReview=:clientReview WHERE ShiftId=:shiftId";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':starRating', $rating);
        $pdoStmt->bindValue(':clientReview', $clientReview);
        $pdoStmt->bindValue(':shiftId', $shiftId);
        $pdoStmt->execute();
        $pdoStmt->closeCursor();
    }
    public static function deleteShift($shiftId)
    {
        $db = Db::getDBConnection();
        $sql = "DELETE FROM shiftmaster WHERE ShiftId=:shiftId";
        $pdoStmt = $db->prepare($sql);
        $pdoStmt->bindValue(':shiftId', $shiftId);
        $pdoStmt->execute();
        $pdoStmt->closeCursor();
    }
}
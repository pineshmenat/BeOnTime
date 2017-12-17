<?php
require_once "client-db-operations.php";
/**
 * Created by PhpStorm.
 * User: Vaishnavi
 * Date: 2017-12-16
 * Time: 01:14
 */

$shiftsDateArray = $_POST['shiftsDateArray'];
$startTimesArr = $_POST['startTimesArr'];
$endTimesArr = $_POST['endTimesArr'];

$companyId=$_POST['companyId'];
$companyLocationId=$_POST['companyLocationId'];
$employeeDesignationId=$_POST['employeeDesignationId'];

/*print_r($shiftsDateArray);
echo "----";
print_r($startTimesArr);
echo "----";
print_r($endTimesArr);
echo "----";*/

for ($i=0; $i<count($shiftsDateArray); $i++){
    $x = $shiftsDateArray[$i].$startTimesArr[$i];
    $date = date_create_from_format('MdYh:i A', $x);
    $dateStartTime = date_format($date, 'Y-m-d H:i:s');

    $x = $shiftsDateArray[$i].$endTimesArr[$i];
    $date = date_create_from_format('MdYh:i A', $x);
    $dateEndTime = date_format($date, 'Y-m-d H:i:s');

    ClientSideDB::insertShifts($employeeDesignationId, $companyId, $companyLocationId, $dateStartTime, $dateEndTime);
}

echo 'New Shifts created.';
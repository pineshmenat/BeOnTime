<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("location: ../index.html");
}
?>
<?php
header('Content-Type: application/json');
$starttime=$_SESSION['startdate'];
$endtime=$_SESSION['enddate'];
//$city = $_POST['ddlcity'];

$s = $starttime;
$date = strtotime($s);
$startdate=date('Y-m-d H:i:s', $date);

//var_dump($startdate);


$s1 = $endtime;
$date1= strtotime($s1);
$enddate=date('Y-m-d H:i:s', $date1);
//var_dump($enddate);


include "../model/db_config.php";
$db=DB::getDBConnection();
$SQL = "SELECT usermaster.FirstName,(sum(shiftmaster.ActualWorkingEndTime-shiftmaster.ActualWorkingStartTime))/10000 as 'time' FROM shiftmaster inner join usermaster on shiftmaster.AssignedTo=usermaster.UserId where shiftmaster.ActualWorkingStartTime>=:start and shiftmaster. ActualWorkingEndTime<=:end group by AssignedTo";
$pdpstm = $db->prepare($SQL);
$pdpstm->bindValue(':start', $startdate);
$pdpstm->bindValue('end', $enddate);
$pdpstm->execute();
$pdpstm->setFetchMode(PDO::FETCH_OBJ);
  //var_dump($pdpstm);

$resultSet = $pdpstm->fetchAll();
//var_dump($resultSet);
/*foreach($resultSet as $result)
{
    $arr1[]=($result->{'AssignedTo'});
    $arr2[]=($result->{'time'}/10000);
}
var_dump($arr1);
var_dump($arr2);*/

$data=array();
foreach ($resultSet as $row)
{
    $data[]=$row;
}
print json_encode($data);


?>



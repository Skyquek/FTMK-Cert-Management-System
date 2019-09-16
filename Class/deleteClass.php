<?php
include('../connect.php');
$classID = mysqli_real_escape_string($connect, $_GET['classID']);

//delete cert acquire from class attendantID
$sql_checkCertAcquire = "SELECT * FROM 
						certacquire INNER JOIN classattendance 
						ON 
						classattendance.attendantID = certacquire.attendantID 
						AND 
						classattendance.classID = '$classID'";

$query_checkCertAcquire = mysqli_query($connect, $sql_checkCertAcquire);
$result_checkCertAcquire = mysqli_fetch_array($query_checkCertAcquire);

if($result_checkCertAcquire != 0)
{

	//delete cert acquire from class attendantID
	$sql_deleteCertAcquire = "DELETE certacquire
							FROM 
							certacquire INNER JOIN classattendance 
							ON 
							classattendance.attendantID = certacquire.attendantID 
							WHERE 
							classattendance.classID = '$classID'";

	$query_deleteCertAcquire = mysqli_query($connect, $sql_deleteCertAcquire);
	var_dump($query_deleteCertAcquire);

	//delete classattendant with classID
	$sql_deleteatt = "DELETE FROM classattendance WHERE classID = '$classID'";
	$query_deleteatt = mysqli_query($connect, $sql_deleteatt);

	//delete class using classID
	$sql_deleteclass = "DELETE FROM class WHERE classID = '$classID'";
	$query_deleteclass = mysqli_query($connect, $sql_deleteclass);

}
else
{
	//delete classattendant with classID
	$sql_deleteatt = "DELETE FROM classattendance WHERE classID = '$classID'";
	$query_deleteatt = mysqli_query($connect, $sql_deleteatt);

	//delete class using classID
	$sql_deleteclass = "DELETE FROM class WHERE classID = '$classID'";
	$query_deleteclass = mysqli_query($connect, $sql_deleteclass);

}



if ($query_deleteclass)
{
	header("location: /certSystem/trainerdashboard.php");
}

?>
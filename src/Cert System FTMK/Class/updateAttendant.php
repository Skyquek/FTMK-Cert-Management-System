<?php
include('../connect.php');
$attStatus = mysqli_real_escape_string($connect, $_GET['attStatus']);
$noMatric = mysqli_real_escape_string($connect, $_GET['noMatric']);

echo $classID;
$sql_updateatt = "UPDATE classattendance SET attendantStatus = '$attStatus' WHERE noMatric = '$noMatric'";
$query_updateatt = mysqli_query($connect, $sql_updateatt);
if ($query_updateatt)
{
	header("location: editClassAttendance.php?classID=35");
}
?>
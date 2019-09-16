<?php
require_once('../connect.php');
require_once('../session.php');

//classID
$classID = $_GET['classID'];

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

	$matricnumber = mysqli_real_escape_string($connect, $_POST['matricnumber']);
		
	//check if cert and cohort are available
	$student_sql = "SELECT 
					* 
					FROM classattendance 
					WHERE noMatric = '$matricnumber'
					";

	$student_query = mysqli_query($connect, $student_sql);
	$student_row = mysqli_fetch_array($student_query);
							
	if( $student_row[0] == 1)
	{
		echo "student exists";
	}
	else
	{
		echo "Valid";
		//insert into attendance details
		$sql_attendancedetails = "INSERT INTO classattendance (attendantStatus, noMatric, classID) VALUES ('1','$matricnumber','$classID')";
		$query_attendancedetails = mysqli_query($connect, $sql_attendancedetails);

	}
}

?>

<!DOCTYPE html>
<html>
<head>
<style>
body{
background-color: rgb(240,248,255);
font-family: arial;
width: 100%;

}
/* Add a black background color to the top navigation */
.topnav {
  background-color: #333;
  overflow: hidden;
  width: 100%;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;

}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
.topnav a.logout{
	float: right;
}
</style>
</head>
<body>
<div>
	<div class="topnav">
		<a onclick="backtotrainerdashboard()">Back</a>
		<a class="logout" href="logout.php">Log Out</a> 
	</div>
</div>

<div>
	<table>
	<form action="" method="post">

		<tbody>
			<tr>
				<td><h2>Enroll One Student</h2></td>
			</tr>
		</tbody>
	</table>
	<table>
		<tr>
			<td>Enter Matric Number: </td>
			<td>
				<td><input type="text" name="matricnumber" value="" required></td>
			</td>
		</tr>
		<tr>
			<td><input type="submit" value="Add"></td>
		</tr>
	</table>

	</form>
</div>
</body>
</html>


<script>
function backtotrainerdashboard(){
	window.location.href = "/certSystem/trainerdashboard.php";
}
</script>
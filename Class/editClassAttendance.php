<?php
require_once('../session.php');
require_once('../connect.php'); 

$classID = mysqli_real_escape_string($connect, $_GET['classID']);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Take Attendance</title>
<style>
body{
	background-color: rgb(240,248,255);
	font-family: arial;
}
/* Add a black background color to the top navigation */
.topnav {
  background-color: #333;
  overflow: hidden;
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

.attendance_table {
	border-collapse: collapse;
	/*border: 1px solid black;*/
}

.attendance_table td{
	border: 1px solid black;
}

input:focus, select:focus{
        outline: none;

</style>
</head>
<body>
<div>
	<div class="topnav">
		<a onclick="backtotrainerdashboard()">Back</a>
		<a class="logout" href="../logout.php">Log Out</a> 
	</div>
</div>

<h1>Attendance</h1>
<table class="attendance_table">
	<tr>
		<td>Index</td>
		<td>Matric No</td>
		<td>Name</td>
		<td>Attendance</td>
		<td>Confirmation</td>
	</tr>

	<?php
	$sql_studentDetails = "SELECT 
							classattendance.attendantStatus,
							classattendance.noMatric,  
							student.studentName
							FROM 
							classattendance INNER JOIN student
							ON 
							classattendance.noMatric = student.noMatric
              AND classattendance.classID = '$classID'
							";

	$query_studentDetails = mysqli_query($connect, $sql_studentDetails);

	$count = 0;

    while ($row_studentDetails = mysqli_fetch_array($query_studentDetails)) 
    {
    	$count++;
    	echo '<tr>';
    	echo '<td>' . $count . '</td>';
    	echo '<form type="get" action="updateAttendant.php"> ';
    	echo '<td>'.
    	'<h5 name="noMatric" value="'. $row_studentDetails['noMatric'] .'">'. $row_studentDetails['noMatric'] .'</h5>'. 

    	'<input type="hidden" name="noMatric" value="'. $row_studentDetails['noMatric'] .'">'.
    	

    	'<input type="hidden" name="classID" value="'. $classID .'">'.

    	'</td>';
    	echo '<td>'.'<h5 value="'. $row_studentDetails['studentName'] .'">'.$row_studentDetails['studentName'] .'</h5> </td>';

    	echo '<td>
    	<div>
    	<select name="attStatus">';
    	if ($row_studentDetails["attendantStatus"] == 1)
    	{
    		echo '<option value = "1"> Fully Attent Class </option>';
    		echo '<option value = "0"> Not Fully Attented Class Yet </option>';
    	}
    	else
    	{
    		echo '<option value = "0"> Not Fully Attented Class Yet </option>';
    		echo '<option value = "1"> Fully Attent Class </option>';
    	}


    	
    	echo '</div></select></td>
				<td><input type="submit" value="Submit"></td>
			';
    	echo '</form>';
    	echo '</tr>
    		

    	';
	}

	?>
	

</table>

</body>
</html>
<script>
function backtotrainerdashboard(){
	window.location.href = "/certSystem/trainerdashboard.php";
}
</script>
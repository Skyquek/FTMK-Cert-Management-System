<?php
	require_once('session.php');
	require_once('connect.php'); 
	if (isset( $_SESSION['user_id']) == False ) {
		header("Location: index.php");
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Trainer Dashboard</title>
	<style>
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
		  cursor: pointer;
		}

		/* Add a color to the active/current link */
		.topnav a.active {
		  background-color: #4CAF50;
		  color: white;
		}

		.topnav a.logout{
			float: right;
		}
		.topnav a.logout{
			float: right;
		}
		.panel {
		    display: inline-block;
		    background: #ffffff;
		    min-height: 100px;
		    height: 100px;
		    box-shadow:0px 0px 5px 5px #C9C9C9;
		    -webkit-box-shadow:2px 2px 5px 5x #C9C9C9;
		    -moz-box-shadow:2px 2px 5px 5px #C9C9C9;
		    margin: 10px;
		    padding: 10px;
		}
		.panel1 {
		    min-width: 100px;
		    width: 100px;
		}
		.panel2 {
		    min-width: 245px;
		    width: 97%;
		}
	</style>
</head>
<body>
<div>
	<div class="topnav">
		<!--<a onclick="trainerClick()">Profile</a>-->
		<a onclick="createClass()">Create New Class</a>
		<a class="logout" href="logout.php">Log Out</a> 
	</div>
</div>

<div style="margin-left: 10px; margin-top: 10px;">
	<h1>Class Registered</h1>
</div>

<?php
//current user by session
$username = $_SESSION['user_id'];
$sqluserid = "SELECT * FROM user WHERE userName = '$username'";
$query_userid = mysqli_query($connect, $sqluserid);
$row_userid = mysqli_fetch_array($query_userid);

//take current user id
$userid = $row_userid['userID'];

$selectCertname = "";

//Find Class based on user 
$sqlclassid = "SELECT * FROM class WHERE userID = '$userid'";
$query_classid = mysqli_query($connect, $sqlclassid);

//Find Class based on class id
$sql_class = "SELECT * 
				FROM class 
				INNER JOIN certificate
				ON class.certID = certificate.certID 
				INNER JOIN cohort 
				ON class.cohortID = cohort.cohortID
				WHERE
				class.userID = '$userid'
				";

$query_class = mysqli_query($connect, $sql_class);


while($class = mysqli_fetch_array($query_class))
	{
		echo '<div class="panel panel2">';

		//Cert Name and cohort Year
		echo '<div class="row">';
		echo 'CERTIFICATE NAME: ' . $class['certName'];
		echo '<br>';
		echo 'COHORT YEAR: ' . $class['cohortYear'];
		echo '</div>';

		//Button
		//echo '<div class="row" style="text-align: right;">';
		//echo "<a href='Class/addOneStudent.php?classID=" . $class['classID'] . "'><button type='button'>Add One Student</button></a>";
		//echo '</div>';

		echo '<div class="row" style="text-align: right;">';
		echo "<a href='Class/editClassAttendance.php?classID=" . $class['classID'] . "'><button type='button'>Take Attendance</button></a>";
		echo '</div>';

		echo '<div class="row" style="text-align: right;">';
		echo "<a href='Class/deleteClass.php?classID=" . $class['classID'] . "'><button type='button'> Delete Class </button></a>";
		echo '</div>';

		
		echo '</div>';	
	}
?>


</body>
</html>

<script>
$(document).ready(function(){
 $('#registersubmit').click(function(){
	 	$.ajax({
	 		type: "POST",
	 		url:'/certSystem/Class/createClass.php',
	 		data: $('#formregister').serialize(),	
	 	}).done(function(){
	 		alert("You Have Successfully Register");
	 	});
	});
});



function trainerClick(){
	window.location.href = "/certSystem/trainerdashboard.php";
}

function createClass(){
	window.location.href = "/certSystem/Class/createClass.php";
}
</script>



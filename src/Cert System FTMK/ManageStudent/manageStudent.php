<?php
require_once('../connect.php'); 
if ($_SERVER["REQUEST_METHOD"] == "POST"){

	$matric = mysqli_real_escape_string($connect, $_POST['matric']); //student Table noMatric
	$name = mysqli_real_escape_string($connect, $_POST['name']); //student Table studentName
	$class = mysqli_real_escape_string($connect, $_POST['class']); //student Table yearGroup
	$course = mysqli_real_escape_string($connect, $_POST['course']); //student Table deptCode
	$cohort = mysqli_real_escape_string($connect, $_POST['cohort']); //student Table cohortID
	$payment = mysqli_real_escape_string($connect, $_POST['payment']); //payment Table payAmount (need noMatric)

	if($course == ""){
		$course = 'BITI';
	}
	else if ($class == ""){
		$class = 'S1G1';
	}
	else if ($payment == ""){
		$payment = 'unpaid';
	}
	else if ($cohort == ""){
		$cohort = '18/19';
	}

	$sql = "SELECT * FROM student WHERE noMatric='$matric' LIMIT 1";
	$result2 = mysqli_query($connect, $sql);
	$user =  mysqli_fetch_array($result2, MYSQLI_ASSOC);

	if ($user['noMatric'] === $matric) {
  		echo "
  			<script>
  			alert('Student Existed!')
  			</script>
  			";

		}else{
			$sql = "INSERT INTO student (noMatric,studentName,yearGroup,cohortID,courseCode) VALUES ('$matric', '$name', '$class', '$cohort', '$course')";
	  		mysqli_query($connect, $sql);

	  		$sql_payment = "INSERT INTO payment (noMatric,payAmount) VALUES ('$matric','$payment')";
	  		mysqli_query($connect, $sql_payment);
	  	echo "
	  	<script>
	  	alert('Student Sucessfully Added!');
	  	window.location.href = '/certSystem/ManageStudent/manageStudent.php';
	  	</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
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
  cursor: pointer;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.items a:hover {
  color: #f1f1f1;
}

.manageStudBlock{
}
.topnav a.logout{
	float: right;
}

table,html {
	height: 100%;
}

</style>
<body>
<div>
	<div class="topnav">
	  	<a onclick="stdDetailClick()">Student Details</a>
		<a onclick="stdManage()">Student Management</a>
		<a onclick="certManage()">Manage Certificate</a>
		<a onclick="statReport()">Statistic Report</a>
		<a onclick="registerClick()">Manage User</a>
		<a class="logout" href="../logout.php">Log Out</a>
	</div>
</div>

<div class="manageStudBlock" style="width: 100%;">
	
	
	<table>
		<tbody>
			<tr><h1>REGISTER STUDENT</h1></tr>
			<tr><button onclick="showUser()">Show All User</button></tr>
			<form name="studregisterform" action="" onsubmit="return validationForm()" method="post" class="registerForm" id="formregister">
			<tr>
				<td><label for="name"><b>Name: </b></label></td>
				<td><input type="text" placeholder="Enter Student Name" name="name" required></input></td>
			</tr>
			<tr>
				<td><label for="matric"><b>Matric No: </b></label></td>
				<td><input type="text" placeholder="Enter Matric Number" name="matric" required></input></td>
			</tr>
			<tr>
				<td><label for="course"><b>Course: </b></label></td>
				<td>
					<select name="course">
						<option value="BITI">BITI</option>
						<option value="BITE">BITE</option>
						<option value="BITM">BITM</option>
						<option value="BITS">BITS</option>
						<option value="BITZ">BITZ</option>
						<option value="BITC">BITC</option>
						<option value="BITD">BITD</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="class"><b>Class: </b></label></td>
				<td>
					<select name="class">
						<option value="S1G1">S1G1</option>
						<option value="S1G2">S1G2</option>
						<option value="S2G1">S2G1</option>
						<option value="S2G2">S2G2</option>
						<option value="S3G1">S3G1</option>
						<option value="S3G2">S3G2</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="payment"><b>Payment: RM</b></label></td>
				<td><input type="number" placeholder="Enter Amount Paid" name="payment" required></input></td>
			</tr>
			<tr>
				<td><label for="cohort"><b>Cohort: </b></label></td>
				<td>
				<select name="cohort">
					<?php
						include('connect.php');
						$sql_cohort = 'SELECT * FROM cohort';
						$result2 = mysqli_query($connect, $sql_cohort);
						while ($cohortID =  mysqli_fetch_array($result2)){
							echo '<option value="'. $cohortID[0] .'"">'. $cohortID[1] . '</option>';
						}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td><button type="submit" class="register" id="registersubmit">Register</button></td>
			</tr>

			<tr>

			</tr>
		</tbody>
	</table>
	</form>

	<form enctype="multipart/form-data" method="post" action="import_csv.php" style="margin-top: 30px;">
		<table border="1">
		<tr >
		<td colspan="2" align="center"><strong>Import CSV file</strong></td>
		</tr>
		<tr>
		<td align="center">CSV File:</td><td><input type="file" name="file" id="file" accept=".csv"></td></tr>
		<tr >
		<td colspan="2" align="center"><input type="submit" name="submit" value="submit" /></td>
		</tr>
		</table>
	</form>
    </div>
</form>

</div>
</body>
</html>

<script>
function certManage(){
	window.location.href = "/certSystem/ManageCertificate/manageCert.php";
}

function registerClick(){
	window.location.href = "/certSystem/ManageUser/registerUser.php";
} 

function stdDetailClick(){
	window.location.href = "/certSystem/admindashboard.php";
}

function stdManage(){
	window.location.href = "/certSystem/ManageStudent/manageStudent.php";
}

function showUser(){
	window.location.href = "/certSystem/ManageStudent/viewStudent.php";
}

function statReport(){
	window.location.href = "/certSystem/statistic/viewStatistic.php";
}

$(document).ready(
function() {
	$("#frmCSVImport").on(
	"submit",
	function() {

		$("#response").attr("class", "");
		$("#response").html("");
		var fileType = ".csv";
		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
				+ fileType + ")$");
		if (!regex.test($("#file").val().toLowerCase())) {
			$("#response").addClass("error");
			$("#response").addClass("display-block");
			$("#response").html(
					"Invalid File. Upload : <b>" + fileType
							+ "</b> Files.");
			return false;
		}
		return true;
	});
});


function validationForm(){
	var matric = document.forms['studregisterform']['matric'].value;

	var value_0 = matric.substring(0,1);
	var value_1 = matric.substring(1,2);
	var value_2 = matric.substring(2,3);
	var value_3 = matric.substring(3,4);
	var value_4 = matric.substring(4,5);
	var value_5 = matric.substring(5,6);
	var value_6 = matric.substring(6,7);
	var value_7 = matric.substring(7,8);
	var value_8 = matric.substring(8,9);
	var value_9 = matric.substring(9,10);
	//alert(matric.length);

	if(matric.length != 10)
	{
		alert('Please check the length of your input');
		return false;
	}
	else if(Number.isInteger(parseInt(value_0)))
	{
		alert('Your first digit cannot be integer!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_1)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_2)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_3)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_4)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_5)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_6)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_7)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_8)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else if(Number.isInteger(parseInt(value_9)) != true)
	{
		alert('Your matric number format is wrong!');
		return false;
	}
	else{
		return true;
	}
}
</script>
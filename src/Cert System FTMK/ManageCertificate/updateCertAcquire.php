<!DOCTYPE html>
<html>
<head>
	<title>Update Student's Certificate Acquire</title>

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
	  	<a onclick="backButton()">Back</a>
		<a onclick="viewAcquireCert()">View Acquire Certificate</a>
		<a class="logout" href="/certSystem/logout.php">Log Out</a>
	</div>
</div>
</body>
</html>
	<table>
	<tbody>
		<th>
			<h1>Add Student's Cert Acquire</h1>
		</th>
	<form action="" name="certacquireform" onsubmit="return validationForm()" method="post">
		<tr>
			<td><label for="course"><b>Course: </b></label></td>
			<td>
			<select id="courseVal" name="course">
				<?php
					$sql_course = 'SELECT * FROM department';
					$query_course = mysqli_query($connect, $sql_course);
					while ($course =  mysqli_fetch_array($query_course)){
						echo '<option value="'. $course['CourseCode'] .'"">'. $course['CourseCode'] . '</option>';
					}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td><label for="cohort"><b>Cohort: </b></label></td>
			<td>
			<select name="cohort">
				<?php
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
			<td><label for="matric"><b>No Matric: </b></label></td>
			<td>
			<select disabled name="matric">
			</select>
			</td>
		</tr>
		<tr>
			<td><label for="date"><b>Date: </b></label></td>
			<td><input type="date" name="date"></td>
		</tr>
		
		<tr>
			<td><input type="submit" value="Add Certificate Acquire"></td>
		</tr>

	</form>
	</tbody>
</table>



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

		$certCompleteName = mysqli_real_escape_string($connect, $_POST['certCompleteName']);
		$date = mysqli_real_escape_string($connect, $_POST['date']);
		$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);
		$certName = mysqli_real_escape_string($connect, $_POST['certName']);
		
  		$sqlupdate="UPDATE certacquire SET certCompletionName = '$certCompleteName', date = '$date', certID = '$certName'  WHERE noMatric = '$matric'";
		  	mysqli_query($connect, $sqlupdate);

		  	echo '
		  		<script>
		  			alert("Update Successfully");
		  		</script>

		  	';

  		
  	}
?>

<script>
function backButton(){
	window.location.href = "/certSystem/ManageCertificate/manageCert.php";
}

function viewAcquireCert(){
	window.location.href = "/certSystem/ManageCertificate/viewCertAcquire.php";
}

</script>


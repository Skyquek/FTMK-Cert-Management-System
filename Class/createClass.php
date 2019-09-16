<?php
require_once('../connect.php');
require_once('../session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	$certificateID = mysqli_real_escape_string($connect, $_POST['certificate']);
	$cohortclassID = mysqli_real_escape_string($connect, $_POST['cohortclass']);
	$course = mysqli_real_escape_string($connect, $_POST['course']);
	$cohortstudent = mysqli_real_escape_string($connect, $_POST['cohortstudent']);
	$userName = $_SESSION['user_id'];

	//convert userName to userid
	$sql_userid = "SELECT userID FROM user WHERE userName = '$userName'";
	$userid_query = mysqli_query($connect, $sql_userid);
	$userid_row = mysqli_fetch_array($userid_query);
	$userid = $userid_row['userID'];
	
	//check if cert and cohort are available
	$sql_checkclass = "SELECT COUNT(classID) 
							FROM class 
							WHERE certID = '$certificateID' AND cohortID='$cohortclassID'
						";
	$checkclass_query = mysqli_query($connect, $sql_checkclass);
	$checkclass_row = mysqli_fetch_array($checkclass_query);
						
	if( $checkclass_row[0] == 1)
	{
		echo "class exists";
	}
	else
	{
		echo "Class Created";
		$sql_class = "INSERT INTO class (userID, certID, cohortID) VALUES ('$userid','$certificateID','$cohortclassID')";
		$query_class = mysqli_query($connect, $sql_class);
		
		//retrieve class id
		$retrive_classid = "SELECT 
							classID 
							FROM 
							class 
							WHERE 
							certID = '$certificateID' 
							AND 
							cohortID='$cohortclassID'
							";

		$retrieve_classid_query = mysqli_query($connect, $retrive_classid);
		$retrieve_classid_row = mysqli_fetch_array($retrieve_classid_query);
		$new_classid = $retrieve_classid_row['classID'];


		//Enroll Student
		$enroll_students_sql = "SELECT * FROM 
								student INNER JOIN payment
								ON student.noMatric = payment.noMatric   
								AND student.courseCode = '$course' 
								AND student.cohortID = '$cohortstudent'
								AND payment.payAmount >= 400
								";
		$enroll_students_query = mysqli_query($connect, $enroll_students_sql);


		//Disable student to enroll if their matric Number is in other class
		while ($enroll_students_row = mysqli_fetch_array($enroll_students_query))
		{
			$student = $enroll_students_row['noMatric'];

			$sql_checkmatric = "SELECT noMatric FROM classattendance WHERE noMatric = '$student'";
         	$query_checkmatric = mysqli_query($connect, $sql_checkmatric);
			$row_checkmatric =  mysqli_fetch_array($query_checkmatric);

			if ($row_checkmatric['noMatric'] !== $student)
			{
				//Insert into attendance details
				$sql_attendancedetails = "INSERT INTO classattendance (attendantStatus, noMatric, classID) VALUES ('1','$student','$new_classid')";
				$query_attendancedetails = mysqli_query($connect, $sql_attendancedetails);	
			}
			else
			{
				echo '
					<script>
						alert("Found student which already inside other class!");
					</script>
				';
			}

			

		}

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
	<h1>Create Class</h1>
	<table>

	<form action="" method="post">

		<tbody>
			<tr>
				<td>Certificate Name: </td>
				<td>
				<select name="certificate" required>
				<?php
					$sql_certificate = 'SELECT * FROM certificate';
					$resultcertificate = mysqli_query($connect, $sql_certificate);
					while ($certID =  mysqli_fetch_array($resultcertificate)){
						echo '<option value="'. $certID['certID'] .'"">'. $certID['certName'] . '</option>';
					}
				?>
				</select>
			</td>
			</tr>
			<tr>
				<td>Cohort: </td>
				<td>
				<select name="cohortclass" required>
				<?php
					$sql_cohortclass = 'SELECT * FROM cohort';
					$result_cohortclass = mysqli_query($connect, $sql_cohortclass);
					while ($cohort_class =  mysqli_fetch_array($result_cohortclass)){
						echo '<option value="'. $cohort_class[0] .'"">'. $cohort_class[1] . '</option>';
					}
				?>
				</select>
			</td>
			</tr>
			<tr>
				<td><h2>Student Enroll</h2></td>
			</tr>
		</tbody>
	</table>
	<table>
		<tr>
			<td>Course: </td>
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
			<td>Cohort: </td>
			<td>
			<select name="cohortstudent" required>
			<?php
				$sql_cohortstudent = 'SELECT * FROM cohort';
				$result_cohortstudent = mysqli_query($connect, $sql_cohortstudent);
				while ($cohort_student =  mysqli_fetch_array($result_cohortstudent)){
					echo '<option value="'. $cohort_student[0] .'"">'. $cohort_student[1] . '</option>';
				}
			?>
			</select>
		</td>
		</tr>
		<tr>
			<td><input type="submit" value="FINISH"></td>
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
<?php
include('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$course = mysqli_real_escape_string($connect, $_POST['course']);
	$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);
	$matric = mysqli_real_escape_string($connect, $_POST['matric']);
	$date = mysqli_real_escape_string($connect, $_POST['date']);

	//get Attendant_ID and certID based on matric number
	$sql_attendant = "
	SELECT classattendance.attendantID, class.certID
	FROM 
	classattendance INNER JOIN class  
	ON
	classattendance.classID = class.classID
	AND
	classattendance.noMatric = '$matric'
	";


	$query_attendant = mysqli_query($connect, $sql_attendant);
	$row_attendant =  mysqli_fetch_array($query_attendant);
	$attendant_ID = $row_attendant['attendantID'];
	$certificate_ID = $row_attendant['certID'];

	//check if the student is available
	$sql_checkstudent = "SELECT 1
							FROM 
							certacquire 
							WHERE
							noMatric = '$matric' 
						";
	$query_checkstudent = mysqli_query($connect, $sql_checkstudent);
	$row_checkstudent =  mysqli_fetch_array($query_checkstudent);	
	if($row_checkstudent == 0 )
	{
		$sql_insertcertacquire = "
			INSERT INTO certacquire (date, noMatric, attendantID, certID)
			VALUES
			('$date', '$matric', '$attendant_ID', '$certificate_ID') 
		";
		$query_insertcertacquire = mysqli_query($connect, $sql_insertcertacquire);
		if($query_insertcertacquire)
		{
			echo "
			<script>
				alert('Add successful!');
			</script>
			";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Student's Cert Acquire</title>

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

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script>
function backButton(){
	window.location.href = "/certSystem/ManageCertificate/manageCert.php";
}

function viewAcquireCert(){
	window.location.href = "/certSystem/ManageCertificate/viewCertAcquire.php";
}

//onchange cohort
$('select[name=cohort]').on('change', function() {
  var cohort = this.value;
  var course = $('select[name=course]').val();
  $('select[name=matric]').prop('disabled', true);
  test(cohort, course);
});

//onchange course
$('select[name=course]').on('change', function() {
  var course = this.value;
  var cohort = $('select[name=cohort]').val();
  $('select[name=matric]').prop('disabled', true);
  test(cohort, course);
});

function test(cohort, course){
	console.log('cohort',cohort);
	console.log('course',course);
			$.ajax({
				type: "POST",
				url: "process.php",
				data: {cohort:cohort, course:course},
				dataType:'JSON', 
				success: function(response){
					$('select[name=matric] option').remove();
					$.each(response, function(key, value) {
						$('select[name=matric]')
							.append($("<option></option>")
										.attr("value",key)
										.text(value)); 
					});
				$('select[name=matric]').prop('disabled', false);
			}
			
			});
        }


function validationForm(){
	var certacquiredate = document.forms['certacquireform']['date'].value;

	var todaydate = new Date();

	certacquiredate = new Date(certacquiredate);
	
	if(certacquiredate>todaydate)
	{
		alert("You cannot give certificate in the future!");
		return false;
	}
	else{
		return true;
	}
}
</script>


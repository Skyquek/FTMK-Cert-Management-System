<?php
include('../connect.php'); 
if($_GET['noMatric']) {

    $noMatric = $_GET['noMatric'];
    $cohortcertID = $_GET['cohortID'];

    $sql = "SELECT * 
    FROM student INNER JOIN payment
    ON
    student.noMatric = payment.noMatric
    AND
    student.noMatric = '$noMatric' ";

    $result = mysqli_query($connect, $sql);
 	$student =  mysqli_fetch_array($result);

echo '
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

<div class="topnav">
  	<a onclick="backButton()">Back</a>
	<a class="logout" href="/certSystem/logout.php">Log Out</a>
</div>
	<h1>Update Student Details</h1>
	<form action="" method="post" class="registerForm" id="formregister">
	<table>
		<tbody>
			<tr>
				<td><label for="matric"><b>Matric No: </b></label></td>
				<td><input type="text" placeholder="Enter Matric Number" name="matric" value="'. $noMatric .'" disabled="disabled" required></input></td>
			</tr>
			<tr>
				<td><label for="name"><b>Name: </b></label></td>
				<td><input type="text" placeholder="Enter Student Name" value="' . $student['studentName'] . '"name="name" required></input></td>
			</tr>
			<tr>
				<td><label for="cohort"><b>Cohort: </b></label></td>
				<td>
				<select name="cohort">
	';
				$sql_cohort = 'SELECT * FROM cohort';
				$result2 = mysqli_query($connect, $sql_cohort);
				while ($cohortID =  mysqli_fetch_array($result2)){
					if ($cohortID['cohortID']== $student['cohortID'])
					{
						echo '<option value="'. $cohortID[0] .'"" selected>'. $cohortID[1] . '</option>';
					}
					else
					{

						echo '<option value="'. $cohortID[0] .'"">'. $cohortID[1] . '</option>';
					}
				}
					
			echo '</select>
				</td>
			</tr>
			
			
			<tr>
				<td><label for="course"><b>Course Code: </b></label></td>
				<td>
					<select name="course"> 
					';
						$sql_courseCode = 'SELECT courseCode FROM department';
						$result2 = mysqli_query($connect, $sql_courseCode);
						while ($row_coursecode =  mysqli_fetch_array($result2)){
							if ($row_coursecode['courseCode']== $student['courseCode'])
							{
								echo '<option value="'. $row_coursecode['courseCode'] .'"" selected>'. $row_coursecode['courseCode'] . '</option>';
							}
							else
							{
								echo '<option value="'. $row_coursecode['courseCode'] .'"">'. $row_coursecode['courseCode'] . '</option>';
							}
						}
					echo '</select>
				</td>
			</tr>
			<tr>
				<td><label for="section"><b>Class: </b></label></td>
				<td>
					<select name="section">
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
				<td><input type="number" placeholder="Enter Amount Paid" value="'.$student['payAmount'].'" name="payment" required></input></td>
			</tr>
			<tr>
				<td><button type="submit" class="update" id="updateSubmit">Update</button></td>
			</tr>
		</tbody>
	</table>
	</form>

	<script>
		function backButton(){
			window.location.href = "/certSystem/ManageStudent/viewStudent.php";
		}
	</script>
';
}




if ($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$name = mysqli_real_escape_string($connect, $_POST['name']);
		$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);
		$course = mysqli_real_escape_string($connect, $_POST['course']);
		$section = mysqli_real_escape_string($connect, $_POST['section']);
		$payment = mysqli_real_escape_string($connect, $_POST['payment']);


  		$sqlupdate = "UPDATE student SET studentName = '$name', yearGroup = '$section', cohortID = '$cohort', courseCode = '$course' WHERE noMatric = '$noMatric'";

		mysqli_query($connect, $sqlupdate);

		$sql_paymentupdate = "UPDATE payment SET payAmount = '$payment' WHERE noMatric = '$noMatric'";

		mysqli_query($connect, $sql_paymentupdate);

  		
  	}
?>
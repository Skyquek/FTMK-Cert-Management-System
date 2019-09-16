<?php
include('../connect.php');
?>
 
<html>
<style>
.result_certtable {
	border-collapse: collapse;
	margin-top: 20px;
}
.result_certtable td{
	border: 1px solid black;
}
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
	<h1>View Student Details</h1>
	<table style="margin-top: 20px;">
		<form action="" method="post">
		<tbody>
			<tr>
				<td><label for="course"><b>Course Code: </b></label></td>
				<td>
					<select name="course">
						<option value="BITI" selected>BITI</option>
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
				<td>
					<input type="submit" name="" value="Search">
				</td>
			</tr>
			</form>

			<tr>
				<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST"){

					//Already in ID forms
					$course = mysqli_real_escape_string($connect, $_POST['course']);
					$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);

					$sql_selectView = "
					SELECT * 
					FROM 
					student INNER JOIN cohort 
					ON
					student.cohortID = cohort.cohortID 
					AND
					student.courseCode = '$course'
					AND
					student.cohortID = '$cohort'
					INNER JOIN payment
					ON 
					student.noMatric = payment.noMatric
					";

				$query_selectView = mysqli_query($connect, $sql_selectView);

				$count = 0;
				echo "<table class='result_certtable'>";
					echo '<tr>';
				    	echo '<td> Index </td>';
				    	echo '<td> Matric Number</td>';
				    	echo '<td> Student Name </td>';
				    	echo '<td> Year Group </td>';
				    	echo '<td> Cohort Year </td>';
				    	echo '<td> Course Code </td>';
				    	echo '<td> Payment Amount </td>';
				    	echo '<td> Options </td>';
				    echo '</tr>';
				
				if ($query_selectView){
						while ($row_selectView = mysqli_fetch_array($query_selectView)) 
						{
					    	$count++;
					    	$NoMatric = $row_selectView['noMatric'];
					    	echo '<tr>';
					    	echo '<td>' . $count .'</td>';
					    	echo '<td>' . $row_selectView['noMatric'] . '</td>';
					    	echo '<td>' . $row_selectView['studentName'] . '</td>';
					    	echo '<td>' . $row_selectView['yearGroup'] . '</td>';
					    	echo '<td>' . $row_selectView['cohortYear'] . '</td>';
					    	echo '<td>' . $row_selectView['courseCode'] . '</td>';
					    	echo '<td>' . $row_selectView['payAmount'] . '</td>';

					    	//check certacquire and user
					    	$sql_student_certAcquire = "
					    	SELECT 
					    	* 
					    	FROM student INNER JOIN certacquire
					    	ON
					    	student.noMatric = certacquire.noMatric
					    	AND 
					    	student.noMatric = '$NoMatric'
					    	";

					    	$sql_student_attendance ="
					    	SELECT 
					    	*
					    	FROM student INNER JOIN classattendance
					    	ON
					    	student.noMatric = classattendance.noMatric
					    	AND
					    	student.noMatric = '$NoMatric'
					    	";

					    	$sql_student_payment = "
					    	SELECT 
					    	*
					    	FROM student INNER JOIN payment
					    	ON
					    	student.noMatric = payment.noMatric
					    	";

					    	//Query student
					    	$query_student_certAcquire = mysqli_query($connect, $sql_student_certAcquire);
					    	$query_student_attendance = mysqli_query($connect, $sql_student_attendance);
					    	$query_student_payment = mysqli_query($connect, $sql_student_payment);

					    	//array student
					    	$row_student_certAcquire = mysqli_fetch_array($query_student_certAcquire);
					    	$row_student_attendance = mysqli_fetch_array($query_student_attendance);
					    	$row_student_payment = mysqli_fetch_array($query_student_payment);

					    	echo "<td>
						          <a href='updateStudent.php?noMatric=".$row_selectView['noMatric']."&cohortID=".$row_selectView['cohortID']."'><button type='button'>Edit</button></a>";

					    	if (($row_student_certAcquire==0)&&($row_student_attendance==0))
					    	{
					    		//Edit and Remove Button
						    	echo "
						                <a href='removeStudent.php?noMatric=".$row_selectView['noMatric']."'><button type='button'>Remove</button></a>
					                </td>";
					    	}
					    	
				            echo '</tr>';
				            
						}
						echo "</table>";
				}
			    
				}
				?>
			</tr>
		</tbody>
	
	</table>
</html>
<script>
function backButton(){
	window.location.href = "/certSystem/ManageStudent/manageStudent.php";
}

function addcert(){
	window.location.href = "/certSystem/ManageCertificate/addcert.php";
}

function showcert(){
	window.location.href = "/certSystem/ManageCertificate/showCert.php";
}
</script>
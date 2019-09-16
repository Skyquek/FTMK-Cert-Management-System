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
	<table style="margin-top: 20px;">
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
				<td>
					<input type="submit" name="" value="Search">
				</td>
			</tr>
			</form>

			<tr>
				<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST"){

					//Already in ID forms
					$certificate = mysqli_real_escape_string($connect, $_POST['certificate']);
					$cohortclass = mysqli_real_escape_string($connect, $_POST['cohortclass']);

					$sql_selectView = "
					SELECT 
					certacquire.noMatric, certacquire.date, certificate.certName, classattendance.attendantStatus
					FROM 
					certacquire INNER JOIN classattendance
					ON
					certacquire.attendantID = classattendance.attendantID
					INNER JOIN class
					ON
					classattendance.classID = class.classID
					AND
					class.cohortID = '$cohortclass'
					AND
					class.certID = '$certificate'
					INNER JOIN certificate
					ON
					certificate.certID = class.certID
					";

				//print_r($sql_selectView);

				$query_selectView = mysqli_query($connect, $sql_selectView);

				$count = 0;
				echo "<table class='result_certtable'>";
					echo '<tr>';
				    	echo '<td> Index </td>';
				    	echo '<td> Matric Number</td>';
				    	echo '<td> Certificate Name </td>';
				    	echo '<td> Attendance Status </td>';
				    	echo '<td> Date </td>';
				    	echo '<td> Options </td>';
				    echo '</tr>';
				
				if ($query_selectView){
						while ($row_selectView = mysqli_fetch_array($query_selectView)) 
						{
					    	$count++;

					    	echo '<tr>';
					    	echo '<td>' . $count .'</td>';
					    	echo '<td>' . $row_selectView['noMatric'] . '</td>';
					    	echo '<td>' . $row_selectView['certName'] . '</td>';
					    	echo '<td>' . $row_selectView['attendantStatus'] . '</td>';
					    	echo '<td>' . $row_selectView['date'] . '</td>';

					    	//Edit and Remove Button
					    	echo "<td>
					                <!--<a href='updateCertAcquire.php?noMatric=".$row_selectView['noMatric']."'><button type='button'>Edit</button></a>-->
					                <a href='deleteCertAcquire.php?noMatric=".$row_selectView['noMatric']."'><button type='button'>Remove</button></a>
				                </td>";

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
	window.location.href = "/certSystem/ManageCertificate/addcertacquire.php";
}

function addcert(){
	window.location.href = "/certSystem/ManageCertificate/addcert.php";
}

function showcert(){
	window.location.href = "/certSystem/ManageCertificate/showCert.php";
}
</script>
<?php
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	$certName = mysqli_real_escape_string($connect, $_POST['cerName']);
	$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);
	$dept = mysqli_real_escape_string($connect, $_POST['certDept']);
	$certName = strtoupper($certName);

	$sql = "SELECT * FROM certificate WHERE certName='$certName' LIMIT 1";
	$cert_result = mysqli_query($connect, $sql);
	$certificate =  mysqli_fetch_array($cert_result, MYSQLI_ASSOC);

	if ($certificate['certName'] === $certName) {
		
  		echo "
  		<script>
  		alert('Certificate Existed!')
  		</script>
  		";

		}
		else{
			//Add New Cert into cert Table
			$sql_cert = "INSERT INTO certificate (certName) VALUES ('$certName')";
		  	mysqli_query($connect, $sql_cert);

		  	//Get Cert ID
		  	$sql_certID = "SELECT certID FROM certificate WHERE certName='$certName'";
		  	$query_certID = mysqli_query($connect, $sql_certID);
		  	$certID_array = mysqli_fetch_array($query_certID);
		  	$certID = $certID_array['certID'];

		  	$sql_cert_details = "INSERT INTO cohortcertdetails (certID, cohortID, deptCode) VALUES ('$certID', '$cohort', '$dept')";
		  	mysqli_query($connect, $sql_cert_details);
		  	echo "
		  	<script>
		  	alert('Certificate Sucessfully Added')
		  	</script>
		  	";
		}
	}

	

?>
<html>
<table>
<head>
	<title>Add Student's Certificate</title>
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
	  	<a onclick="showcert()">Show All Certificate</a>
		<a class="logout" href="/certSystem/logout.php">Log Out</a>
	</div>
</div>
	<tbody>
		<tr>
			<td><h1>Add Certificate</h1></td>
		</tr>
	<form action="" method="post">
		<tr>
			<td>Cerificate Name: </td>
			<td><input type="text" name="cerName" value="" required></td>
		</tr>
		<tr>
			<td>Cohort: </td>
			<td>
				<select name="cohort" required>
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
			<td>Department: </td>
			<td>
				<select name="certDept" required>
					<?php
					$sql_dept = 'SELECT * FROM department';
					$dept_result = mysqli_query($connect, $sql_dept);
					while ($deptCode =  mysqli_fetch_array($dept_result)){
						echo '<option value="'. $deptCode[0] .'"">'. $deptCode[0] . '</option>';
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="submit" value="Add Certificate"></td>
		</tr>
	</form>
	</tbody>
</table>
</body>
</html>
<script>
function backButton(){
	window.location.href = "/certSystem/ManageCertificate/manageCert.php";
}

function showcert(){
	window.location.href = "/certSystem/ManageCertificate/showCert.php";
}

</script>
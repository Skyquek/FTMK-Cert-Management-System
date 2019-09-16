<?php
include('../connect.php');


if ($_GET['cohortcertID']){
	//This is actually certID
	$certID = $_GET['certID'];
	$cohortcertID = $_GET['cohortcertID'];
	
	$sql_checkCert = "SELECT 
			* 
			FROM cohortcertdetails INNER JOIN certificate
			ON
			cohortcertdetails.certID = certificate.certID
			AND
			cohortcertdetails.cohortcertID = '$cohortcertID'
			";

	$query_checkCert = mysqli_query($connect, $sql_checkCert);
	$row_checkCert =  mysqli_fetch_array($query_checkCert);



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
<script>
function backButton(){
	window.location.href = "/certSystem/ManageCertificate/showCert.php";
}
</script>
<table>
	<tbody>
		<tr>
			<td><h1>Update Certificate</h1></td>
		</tr>
	<form action="" method="post">
		<tr>
			<td><label for="certID"><b>Cert ID: </b></label></td>
			<td><input type="text" name="certID"'. 'value="'. $certID . '" disabled="disabled" required></input></td>
		</tr>
		<tr>
			<td>Cerificate Name: </td>
			<td><input type="text" name="cerName" value="'. $row_checkCert["certName"]. '" required></td>
		</tr>
		<tr>
			<td>Cohort: </td>
			<td>
				<select name="cohort">';
				
				$sql_cohort = 'SELECT * FROM cohort';
				$result2 = mysqli_query($connect, $sql_cohort);
				while ($cohortID =  mysqli_fetch_array($result2)){
					if ($row_checkCert['cohortID']==$cohortID[0])
					{
						echo '<option value="'. $cohortID[0] .'"" selected>'. $cohortID[1] . '</option>';
					}
					else
					{
						echo '<option value="'. $cohortID[0] .'"">'. $cohortID[1] . '</option>';
					}
				}
				
				echo "

					</select>
							</td>
						</tr>
						<tr>
							<td>Department: </td>
							<td>
								<select name='certDept' required>
								'";
									
									$sql_dept = 'SELECT * FROM department';
									$dept_result = mysqli_query($connect, $sql_dept);
									while ($deptCode =  mysqli_fetch_array($dept_result)){
										if ($row_checkCert['deptCode']==$deptCode[0])
										{
											echo '<option value="'. $deptCode[0] .'"" selected>'. $deptCode[0] . '</option>';
										}
										else
										{
											echo '<option value="'. $deptCode[0] .'"">'. $deptCode[0] . '</option>';
										}
										
									}
								echo "
								</select>
							</td>
						</tr>
						<tr>
							<td><input type='submit' value='Update Certificate'></td>
						</tr>
					</form>
					</tbody>
				</table>
				";

}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	
	$certName = mysqli_real_escape_string($connect, $_POST['cerName']);
	$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);
	$dept = mysqli_real_escape_string($connect, $_POST['certDept']);
	$certName = strtoupper($certName);

	//Update Certificate Name
	$sql_certname = "UPDATE certificate SET certName = '$certName' WHERE certID = '$certID'";
  	$query_certname=mysqli_query($connect, $sql_certname);

  	//Get Cert ID
  	$sql_certID = "UPDATE cohortcertdetails SET certID = '$certID', cohortID = '$cohort',deptCode = '$dept' WHERE cohortcertID = '$cohortcertID'";
  	$query_certID = mysqli_query($connect, $sql_certID);

  	if ($query_certname && $query_certID){
  		echo "
	  	<script>
	  	alert('Certificate Sucessfully Updated')
	  	window.location.href = '/certSystem/ManageCertificate/showCert.php';
	  	</script>
	  	";
  	}
  	
		
	}


?>

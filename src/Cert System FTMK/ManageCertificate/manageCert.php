<?php
include('../navbar.php');
include('../connect.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Manage Certificate</title>
</head>
<body>
	<table style="margin-top: 20px;">
		<tbody>
			<tr>
				<td><button onclick="addcohort()">Add Cohort</button></td>
				<!--<td><button onclick="showcert()">Show All Certificate</button></td>-->
				<td><button onclick="addcert()">Add Certificate</button></td>
				<td><button onclick="updatecertacquire()">Add Student Certificate Acquisition</button></td>
			</tr>
			<tr>
				
			</tr>
		</tbody>
	</table>
</body>
</html>
<script>
function addcert(){
	window.location.href = "/certSystem/ManageCertificate/addcert.php";
}

function showcert(){
	window.location.href = "/certSystem/ManageCertificate/showCert.php";
}

function addcohort(){
	window.location.href = "/certSystem/ManageCertificate/addcohort.php";
}

function updatecertacquire(){
	window.location.href = "/certSystem/ManageCertificate/addcertacquire.php";
}

</script>
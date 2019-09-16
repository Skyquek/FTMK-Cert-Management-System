<?php
include('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "GET"){

	$certID = mysqli_real_escape_string($connect, $_GET['certID']);
	$cohortCertID = mysqli_real_escape_string($connect, $_GET['cohortCertID']);

	$sql_delcohortcertdetails = "
	DELETE FROM cohortcertdetails WHERE certID = '$certID'
	";

	$sql_delcert = "
	DELETE FROM certificate WHERE certID = '$certID'
	";

	$query_delcohortcertdetails = mysqli_query($connect, $sql_delcohortcertdetails);
	$query_delcert = mysqli_query($connect, $sql_delcert);
	
	echo "
	<script>
		alert('Delete Successfully');
		window.location.href = '/certSystem/ManageCertificate/showCert.php';
	</script>
	";
		
	}
?>


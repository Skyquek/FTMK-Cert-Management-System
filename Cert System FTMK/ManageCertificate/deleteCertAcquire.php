<?php
include('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "GET"){

	$matric = mysqli_real_escape_string($connect, $_GET['noMatric']);
	//echo $matric;
	//get attendanceID
	$sql_delatt = "
	DELETE FROM certacquire WHERE noMatric = '$matric'
	";

	$query_delatt = mysqli_query($connect, $sql_delatt);
	echo "
	<script>
		alert('Delete Successfully');
		window.location.href = '/certSystem/ManageCertificate/viewCertAcquire.php';
	</script>
	";
	//header("location: viewCertAcquire.php");	
}
?>


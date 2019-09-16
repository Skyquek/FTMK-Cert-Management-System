<?php
include('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "GET"){

	$userid = mysqli_real_escape_string($connect, $_GET['userid']);
	if ($userid=='3')
	{
		echo "
		<script>
			alert('Cannot Delete Main Admin');
			window.location.href = '/certSystem/ManageUser/manageUser.php'
		</script>
		";
	}
	else{
		//check if user have class
		$sql_checkuser = "
		SELECT * FROM class WHERE userID = '$userid'
		";
		$query_checkuser = mysqli_query($connect, $sql_checkuser);
		$row_checkuser = mysqli_fetch_array($query_checkuser);
		if($row_checkuser == 0)
		{
			$sql_delatt = "
			DELETE FROM user WHERE userID = '$userid'
			";

			$query_delatt = mysqli_query($connect, $sql_delatt);
			echo "
			<script>
				alert('Delete Successfully');
				window.location.href = '/certSystem/ManageUser/manageUser.php'
			</script>
			";
		}
		else
		{
			echo "
			<script>
				alert(' Delete Fail! This User have class! ');
				window.location.href = '/certSystem/ManageUser/manageUser.php'
			</script>
			";
		}
	}
		
}
?>


<?php
/****************************************************
This is to insert user into the database. 
****************************************************/
	include('registerUser.html');
	require_once('../connect.php');

	if ($_SERVER["REQUEST_METHOD"] == "POST"){

		$loginid = mysqli_real_escape_string($connect, $_POST['loginid']);
		$name = mysqli_real_escape_string($connect, $_POST['name']);
		$password = mysqli_real_escape_string($connect, $_POST['password']);
		$role = mysqli_real_escape_string($connect, $_POST['role']);
		$password = md5($password);
		$sql = "SELECT * FROM user WHERE userName='$loginid' LIMIT 1";
		$result = mysqli_query($connect, $sql);
		$user =  mysqli_fetch_array($result, MYSQLI_ASSOC);

		if ($user['loginid'] === $loginid) {
      		echo "
      		<script>
      		alert('Login ID existed!')
      		</script>
      		";
      				
  		}else{
  			$query = "INSERT INTO user (userName,userPassword,name,role) VALUES ('$loginid', '$password','$name',  '$role')";
		  	mysqli_query($connect, $query);
		  	echo "
      		<script>
      		alert('User Created!')
      		</script>
      		";
		  	//header('location: ../admindashboard.php');
  		}


  	}
?>
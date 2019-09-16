<?php
require_once('connect.php');
require_once('session.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	if ( ! empty( $_POST ) ) {
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Getting submitted user data from database
        
        $loginid = mysqli_real_escape_string($connect, $_POST['username']);
		$password = mysqli_real_escape_string($connect, md5($_POST['password']));

		$sql = "SELECT * FROM user WHERE userName = '$loginid' and userPassword = '$password' ";

		$result = mysqli_query($connect,$sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		//echo $row['role'];
	    $count = mysqli_num_rows($result);

	    // If result matched $myusername and $mypassword, table row must be 1 row
		if($count == 1){
			if ($row['role'] == 'admin'){
				$_SESSION['user_id'] = $row['userName'];
				header("location: admindashboard.php");
			}else{
				$_SESSION['user_id'] = $row['userName'];
				header("location: trainerdashboard.php");	
			}
		}else {
			$error = "Your Login Name or Password is invalid";
			echo $error;
		}

    }
}

}
?>


<html>
<head>
<title>login</title>
<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
<div id="header"><h1>Login To Certificate Management System:</h1></div>
	<div class="container">
		<div class="imgContainer">
			<image src="images/login.png" alt="Avatar" class="avatar"/>
		</div>
		<div>
			<form action="index.php" method="post">
				<label for="username"><b>Login ID: </b></label>
				<input type="text" placeholder="Enter Username" name="username" required></input>
				
				<label for="password"><b>Password:</b></label>
				<input type="password" placeholder="Enter Password" name="password" required></input>
				
				<button type="submit" class="login">Login</button>
				<!--<button type="submit" class="loginAdmin">Admin Login</button>-->

			</form>
		</div>
	</div>
</body>
</html>

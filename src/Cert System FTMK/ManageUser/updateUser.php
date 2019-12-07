<!DOCTYPE html>
<html>
<head>
	<title>Update User</title>

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
		<a class="logout" href="/certSystem/logout.php">Log Out</a>
	</div>
</div>
</body>
</html>
<?php
include('../connect.php');

if($_GET['userid']) {
    $userid = $_GET['userid'];
    $sql_getuser = "SELECT * FROM user WHERE userID = '$userid'";
    $query_getuser = mysqli_query($connect, $sql_getuser);
    $row_getuser = mysqli_fetch_array($query_getuser);
    $userName = $row_getuser['userName'];
    $userPassword = $row_getuser['userPassword'];
    $name = $row_getuser['name'];
echo '

	<form action="" method="post" class="registerForm" id="formregister">
	<table>
		<tbody>
			<tr>
				<td><h1>Update User</h1></td>
			</tr>
			<tr>
				<td><label for="userID"><b>User ID: </b></label></td>
				<td><input type="text" name="userID"'. 'value="'. $userid . '" disabled="disabled" required></input></td>
			</tr>
			<tr>
				<td><label for="userName"><b>User Name: </b></label></td>
				<td><input type="text" placeholder="Enter New User Name" name="userName" value="' . $userName . '" required></input></td>
			</tr>
			<tr>
				<td><label for="userPassword"><b>Password: </b></label></td>
				<td><input type="password" name="userPassword" placeholder="Enter New Password"></td>
			</tr>
			<tr>
				<td><label for="name"><b>Name: </b></label></td>
				<td><input type="text" name="name" placeholder="Enter New User Name" value="'. $name .'"required></td>
			</tr>
			<tr>
				<td><label for="role"><b>Role: </b></label></td>
				<td>
					<select name="role">
						<option value="admin" selected>Admin</option>
						<option value="trainer">Trainer</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" value="Update User"></td>
			</tr>
		</tbody>
	</table>
	</form>
';
}




if ($_SERVER["REQUEST_METHOD"] == "POST"){

		$userName = mysqli_real_escape_string($connect, $_POST['userName']);
		$userPassword = mysqli_real_escape_string($connect, $_POST['userPassword']);
		$userPassword = md5($userPassword);
		$name = mysqli_real_escape_string($connect, $_POST['name']);
		$role = mysqli_real_escape_string($connect, $_POST['role']);
		
		if ($_POST['userPassword']="")
		{
			$sqlupdate="UPDATE user SET userName = '$userName', userPassword = '$userPassword', name = '$name', role = '$role'  WHERE userID = '$userid'";
		  	mysqli_query($connect, $sqlupdate);

		  	echo '
		  		<script>
		  			alert("Update Successfully");
		  		</script>

		  	';
		}
		else
		{
			$sqlupdate="UPDATE user SET userName = '$userName', name = '$name', role = '$role'  WHERE userID = '$userid'";
		  	mysqli_query($connect, $sqlupdate);

		  	echo '
		  		<script>
		  			alert("Update Successfully");
		  		</script>

		  	';
		}
  		

  		
  	}
?>

<script>
function backButton(){
	window.location.href = "/certSystem/ManageUser/registerUser.php";
}

</script>


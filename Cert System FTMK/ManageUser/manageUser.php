<?php
require_once('../connect.php');
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
	<h1>View User</h1>
	<table style="margin-top: 20px;"> 
		<form action="" method="post">
		<tbody>
			<tr>
				<td>Role: </td>
				<td>
					<select name="role">
						<option value="admin">Admin</option>
						<option value="trainer">Trainer</option>
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

					$role = mysqli_real_escape_string($connect, $_POST['role']);

					$sql_selectView = "
					SELECT * 
					FROM 
					user 
					WHERE 
					role = '$role'
					";

				$query_selectView = mysqli_query($connect, $sql_selectView);

				$count = 0;
				echo "<table class='result_certtable'>";
					echo '<tr>';
				    	echo '<td> Index </td>';
				    	echo '<td> userName</td>';
				    	echo '<td> Name  </td>';
				    	echo '<td> Role </td>';
				    	echo '<td> Options </td>';
				    echo '</tr>';
				
				if ($query_selectView){
						while ($row_selectView = mysqli_fetch_array($query_selectView)) 
						{
					    	$count++;

					    	echo '<tr>';
					    	echo '<td>' . $count .'</td>';
					    	echo '<td>' . $row_selectView['userName'] . '</td>';
					    	echo '<td>' . $row_selectView['name'] . '</td>';
					    	echo '<td>' . $row_selectView['role'] . '</td>';

					    	
					    	//Edit and Remove Button
					    	echo "<td>
					                <a href='updateUser.php?userid=".$row_selectView['userID']."'><button type='button'>Edit</button></a>
					                <a href='deleteUser.php?userid=".$row_selectView['userID']."'><button type='button'>Remove</button></a>
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
function addcert(){
	window.location.href = "/certSystem/ManageCertificate/addcert.php";
}

function showcert(){
	window.location.href = "/certSystem/ManageCertificate/showCert.php";
}
function backButton(){
	window.location.href = "/certSystem/ManageUser/registerUser.php";
}
</script>
<!DOCTYPE html>
<html>
<head>
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
	  	<a onclick="stdDetailClick()">Student Details</a>
		<a onclick="stdManage()">Student Management</a>
		<a onclick="certManage()">Manage Certificate</a>
		<a onclick="statReport()">Statistic Report</a>
		<a onclick="registerClick()">Manage User</a>
		<a class="logout" href="/certSystem/logout.php">Log Out</a>
	</div>
</div>
</body>
</html>


<script>
function certManage(){
	window.location.href = "/certSystem/ManageCertificate/manageCert.php";
}

function registerClick(){
	window.location.href = "/certSystem/ManageUser/registerUser.php";
} 

function stdDetailClick(){
	window.location.href = "/certSystem/admindashboard.php";
}

function stdManage(){
	window.location.href = "/certSystem/ManageStudent/manageStudent.php";
}

function statReport(){
	window.location.href = "/certSystem/statistic/viewStatistic.php";
}
</script>
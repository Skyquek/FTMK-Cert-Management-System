<?php

include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);

	$sql_cohort = "SELECT * FROM cohort WHERE cohortYear='$cohort' LIMIT 1";
	$query_cohort = mysqli_query($connect, $sql_cohort);
	$row_cohort =  mysqli_fetch_array($query_cohort);

	if ($row_cohort['cohortYear'] === $cohort) {
  		echo "
  		<script>
  		alert('Cohort Year Existed!')
  		</script>
  		";

		}
		else{
			//Add New cohort Year into cohort Table
			$sql_cert = "INSERT INTO cohort (cohortYear) VALUES ('$cohort')";
		  	mysqli_query($connect, $sql_cert);

		  	echo "
		  	<script>
		  	alert('Cohort Year Sucessfully Added');
		  	</script>
		  	";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Cohort</title>
</head>
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
<body>
	<div class="topnav">
	  	<a onclick="backButton()">Back</a>
		<a class="logout" href="/certSystem/logout.php">Log Out</a>
	</div>
	<table>
	<tbody>
		<tr>
			<td><h1>Add Cohort</h1></td>
		</tr>
	<form name="cohortform" action="" onsubmit="return validationForm()" method="post">
		<tr>
			<td><label for="cohort"><b>Cohort Year: </b></label></td>
			<td><input type="text" placeholder="14/15" name="cohort" required></input></td>
		</tr>
		<tr>
			<td><button>Add Cohort Year</button></td>
		</tr>
	</form>
	</tbody>
</table>
</body>
</html>
<script>
function backButton(){
	window.location.href = "/certSystem/ManageCertificate/manageCert.php";
}

function validationForm(){
	var cohortvalue = document.forms['cohortform']['cohort'].value;

	var first2digit_1 = parseInt(cohortvalue.substring(0,1));
	var first2digit_2 = parseInt(cohortvalue.substring(1,2));
	var middle = cohortvalue.substring(2,3);
	var last2digit_1 = parseInt(cohortvalue.substring(3,4));
	var last2digit_2 = parseInt(cohortvalue.substring(4,5));

	//console.log(first2digit_1);
	//console.log(middle);

	//alert(cohortvalue.length);

	if (cohortvalue.length>5)
	{
		alert('Please check your input');
		return false;
	}
	else if((Number.isInteger(first2digit_1)&&(Number.isInteger(first2digit_2))) != true)
	{
		alert("Please check your input first 2 digit!");
		return false;
	}
	else if( middle !== "/" )
	{
		alert("Your middle value must be /");
		return false;
	}
	else if( (Number.isInteger(last2digit_1) && (Number.isInteger(last2digit_2))) != true)
	{
		alert("Please check your last 2 digit");
		return false;
	}
	else{
		return true;
	}
}
</script>
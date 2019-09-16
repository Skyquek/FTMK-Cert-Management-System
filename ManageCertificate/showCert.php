<?php
include('../connect.php');
?>
 
<html>
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
.result_certtable {
	border-collapse: collapse;
	margin-top: 20px;
}
.result_certtable td{
	border: 1px solid black;
}
</style>
<body>
	<div class="topnav">
	  	<a onclick="backButton()">Back</a>
		<a class="logout" href="/certSystem/logout.php">Log Out</a>
	</div>
	<table style="margin-top: 20px;">
		<tbody>
			<tr>
				<h1>Certificate Available</h1>
			</tr>


			<tr>
				<?php
				$sql = "SELECT * FROM cohortcertdetails";
				$result = mysqli_query($connect, $sql);

				$count = 0;
				echo "<table class='result_certtable'>";
					echo '<tr>';
				    	echo '<td> Index </td>';
				    	echo '<td> Cohort</td>';
				    	echo '<td> Certificate Name </td>';
				    	echo '<td> Department Code </td>';
				    	echo '<td> Options </td>';
				    echo '</tr>';
				
				if ($result){
						while ($row = mysqli_fetch_array($result)) 
						{
					    	$count++;

					    	echo '<tr>';
					    	echo '<td>' . $count .'</td>';

					    	//Get Cohort Year
					    	$sql_cohortYrs = "SELECT cohortYear FROM cohort WHERE cohortID = '" . $row['cohortID'] . "'";
							$result_year = mysqli_query($connect, $sql_cohortYrs);
							$row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC);
					    	echo '<td>' . $row_year["cohortYear"] .'</td>';

				    		//Get Certificate Name
					    	$sql_certname = "SELECT certName FROM certificate WHERE certID = '" . $row['certID'] . "'";
							$result_cert = mysqli_query($connect, $sql_certname);
							$row_certname = mysqli_fetch_array($result_cert, MYSQLI_ASSOC);
					    	echo '<td>' . $row_certname["certName"] .'</td>';
					    	echo '<td>' . $row["deptCode"] .'</td>';

					    	$certificateID = $row['certID'];
					    	

					    	//check certificate and certacquire
					    	$sql_certificate_certAcquire = "
					    	SELECT 
					    	certificate.certID
					    	FROM certificate INNER JOIN certacquire
					    	ON
					    	certificate.certID = certacquire.certID
					    	AND 
					    	certificate.certID = '$certificateID'
					    	";

					    	//check certificate and class
					    	$sql_certificate_class = "
					    	SELECT 
					    	certificate.certID 
					    	FROM certificate INNER JOIN class
					    	ON
					    	certificate.certID = class.certID
					    	AND 
					    	certificate.certID = '$certificateID'
					    	";

					    	

					    	//Query student
					    	$query_certificate_certAcquire = mysqli_query($connect, $sql_certificate_certAcquire);

					    	$query_certificate_class = mysqli_query($connect, $sql_certificate_class);


					    	//array student
					    	$row_certificate_certAcquire = mysqli_fetch_array($query_certificate_certAcquire);

					    	$row_certificate_class = mysqli_fetch_array($query_certificate_class);



					    	

					    	if (($row_certificate_certAcquire == 0)&&($row_certificate_class==0))
					    	{
					    		echo "<td>
					                <a href='updateCert.php?certID=".$row['certID']."&cohortcertID=" . $row['cohortcertID'] . "'><button type='button'>Update</button></a>";


					    		echo "
					                <a href='deletecertandcohortcert.php?certID=".$row['certID']."&cohortcertID=" . $row['cohortcertID'] . "'><button type='button'>Remove</button></a>
				                </td>";
					    	}
					    	else
					    	{
					    		echo "
					    			<td>This Certificate is Currrently in Use! </td>
					    		";
					    	}					    		

				            echo '</tr>';
				            
						}
						echo "</table>";
				}
			    
				?>
			</tr>
		</tbody>
	</table>
</body>
</html>
<script>
function backButton(){
	window.location.href = "/certSystem/ManageCertificate/addcert.php";
}

</script>
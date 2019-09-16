<?php
require_once('session.php');
require_once('connect.php'); 
include('navbar.php');

if (isset($_SESSION['user_id'])){
	$resultOfFilter = "";

	//Loop all Cohort Details
	$sqlcohort = "SELECT * FROM cohort";
	$query_cohort = mysqli_query($connect, $sqlcohort);
	$selectCohort = "";
	while ($readcohort = mysqli_fetch_array($query_cohort)){
		$selectCohort .= '<option value="'.$readcohort['cohortID'].'">'.$readcohort['cohortYear'].'</option>';
	}

	//Loop all CourseCode 
	$sqlcoursecode = "SELECT * FROM department";
	$query_coursecode = mysqli_query($connect, $sqlcoursecode);
	$selectCourseCode = "";
	while ($readcoursecode = mysqli_fetch_array($query_coursecode)){
		$selectCourseCode .= '<option value="'.$readcoursecode['CourseCode'].'">'.$readcoursecode['CourseCode'].'</option>';
	}

	//Loop all CertificateName 
	$sqlcertname = "SELECT * FROM certificate";
	$query_cert = mysqli_query($connect, $sqlcertname);
	$selectCert = "";
	while ($readcert = mysqli_fetch_array($query_cert)){
		$selectCert .= '<option value="'.$readcert['certID'].'">'.$readcert['certName'].'</option>';
	}


    // Grab user data from the database using the user_id
    // Let them access the "logged in only" pages
} else {
    // Redirect them to the login page
    header("Location: index.php");
}

?>
<!--------------------------------------------------------------------------------------------------->

<!------------------------------------------HTML CODE------------------------------------------------->

<!---------------------------------------------------------------------------------------------------->


<html>
<head>
<title>Dashboard</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>

/****************************************************************************/
body{
	background-color: rgb(240,248,255);
	font-family: arial;
}

#studTitle button{
	border: 1px solid black;
	background: white;
}

#registerBlock{
	margin-left: 15%;
	display: none;
}

input[type="text"], input[type="password"], input[type="email"]{
	width: 100%;
	margin: 10px 0;
	padding: 10px 20px;
	box-sizing: border-box;
	display: inline-block;
	border: 1px solid black;
}

button.register{
	background-color: rgb(76,175,80);
	margin-bottom: 10px;
	padding: 10px;
	width: 100%;
	border: none;
	height: 30px;
}
td{
 padding:10px;
}
.result_table{
	border-collapse: collapse;
}
.result_table td{
	border: 1px solid black;
}
.topnav a.logout{
	float: right;
}

</style>
</head>
<body>
<!--------------------------------- View Student Details Block --------------------->
	<div id="studentblock">
		<h1>STUDENT DETAILS</h1>
		<div>
			<table class="selectiontable" table-layout='auto'>
				<form action="" id="bycourse" method="POST">
					<tr>
						<td><label for="courseCode"><b>Course: </b></label></td>
						<td>
							<select name="courseCode">
                                <option value=""></option>
                                <?php echo $selectCourseCode; ?>
                            </select>
						</td>

						<td><label for="seksyen"><b>Seksyen: </b></label></td>
						<td>
							<select name="seksyen">
								<option value=""></option>
								<option value="S1G1">S1G1</option>
								<option value="S1G2">S1G2</option>
								<option value="S2G1">S2G1</option>
								<option value="S2G2">S2G2</option>
								<option value="S3G1">S3G1</option>
								<option value="S3G2">S3G2</option>
			  				</select>
						</td>
						
						<td><label for="cohort"><b>Cohort: </b></label></td>
						<td>
							<select name="cohort">
                                <option value=""></option>
                                <?php echo $selectCohort; ?>
                            </select>
						</td>

						<td><label for="payment"><b>Payment: </b></label></td>
						<td>
							<select name="payment">
								<option value=""></option>
								<option value="notpaid">Not fully Paid</option>
								<option value="fullpaid">Fully Paid</option>
			  				</select>
						</td>

						<td><label for="training"><b>Attendant: </b></td>
						<td>
							<select name="training">
								<option value=""></option>
								<option value="1">Available</option>
								<option value="0">Absent</option>
			  				</select>
						</td>

						<td><label for="certName"><b>Certificate: </b></label></td>
						<td>
							<select name="certName">
								<option value=""></option>
								<?php echo $selectCert; ?>
			  				</select>
						</td>
						<td>
							<button type="submit" form="bycourse" value="Submit">Submit</button>
						</td>						
					</tr>
				</form>
			</table>
			

			<div>
			
			<!--------------------------------- View Student Details Block --------------------->		
				<?php

					if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['user_id'])
					{
						$courseCode = mysqli_real_escape_string($connect, $_POST['courseCode']);
						$seksyen = mysqli_real_escape_string($connect, $_POST['seksyen']);
						$cohort = mysqli_real_escape_string($connect, $_POST['cohort']);
						$payment = mysqli_real_escape_string($connect, $_POST['payment']);
						$training = mysqli_real_escape_string($connect, $_POST['training']); //attendance
						$certName = mysqli_real_escape_string($connect, $_POST['certName']);

						echo "<table class='result_table' width='97%'>";
						echo '<tr>';
					    	echo '<td> Index </td>';
					    	echo '<td> Matric No </td>';
					    	echo '<td> Name </td>';
					    	echo '<td> Seksyen </td>';
					    	echo '<td> Cohort </td>';
					    	echo '<td> Payment</td>';
					    	echo '<td> Attendance </td>';
					    	echo '<td> Cert Acquisition </td>';
					    	echo '<td> CourseCode </td>';
					    	//echo '<td> Options </td>';
					    echo '</tr>';

	/************************************************ ONE SEARCHING **********************************************************************************************/
						//if select only coursename
						if(($seksyen == "")&&($cohort == "")&&($payment == "")&&($training == "")&&($certName == ""))
						{
							$sqlfilter = " SELECT * FROM student WHERE courseCode = '$courseCode' ";
						}

						//if select only seksyen
						else if (($courseCode == "") && ($cohort == "")&&($payment == "")&&($training == "")&&($certName == ""))
						{
							$sqlfilter = " SELECT * FROM student WHERE yearGroup = '$seksyen' ";
						}
						
						//if select only cohort
						else if (($courseCode == "") && ($seksyen == "")&&($payment == "")&&($training == "")&&($certName == ""))
						{
							$sqlfilter = " SELECT * FROM student WHERE cohortID = '$cohort' ";
						}

						//if select only payment 
						else if (($courseCode == "")&&($seksyen == "")&&($cohort == "")&&($training == "")&&($certName == ""))
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								payAmount < 400";	
							} 
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								payAmount >= 400 ";
							}
							
						}

						//if select only attendance ($training)
						else if (($courseCode == "")&&($seksyen == "")&&($cohort == "")&&($payment == "")&&($certName == "")){
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								attendantStatus = '1' ";
							}	
						}
						
						//if select only cert
						else if (($courseCode == "")&&($seksyen == "")&&($cohort == "")&&($payment == "")&&($training == ""))
						{
							$sqlfilter = " SELECT 
							* 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric 
							WHERE 
							certID = '$certName' " ;
						}

						
	/*************************************************** TWO SEARCHING ******************************************************************************************/
						//if select only course and seksyen
						elseif (($cohort == "")&&($payment == "")&&($training == "")&&($certName == "")) 
						{
							$sqlfilter = " SELECT * FROM student WHERE courseCode = '$courseCode' AND yearGroup = '$seksyen' ";
						}

						//if select only course and cohort
						elseif (($seksyen == "")&&($payment == "")&&($training == "")&&($certName == "")) 
						{
							$sqlfilter = " SELECT * FROM student WHERE courseCode = '$courseCode' AND cohortID = '$cohort' ";
						}
						
						//if select only course and payment
						elseif (($seksyen == "")&&($cohort == "")&&($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								courseCode = '$courseCode' AND payAmount < 400";	
							} 
							else
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								courseCode = '$courseCode' AND payAmount >= 400 ";
							}
						}

						//if select only course and attendance ($training)
						elseif (($seksyen == "")&&($cohort == "")&&($payment == "")&&($certName == "")) {
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								courseCode = '$courseCode' AND attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								courseCode = '$courseCode' AND attendantStatus = '1' ";
							}	
						}
						
						//if select only course and cert 
						elseif (($seksyen == "")&&($cohort == "")&&($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT * 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric 
							WHERE 
							courseCode = '$courseCode' AND certID = '$certName' " ;
						}

						
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//if select only seksyen and cohort
						elseif (($courseCode == "")&&($payment == "")&&($training == "")&&($certName == "")) 
						{
							$sqlfilter = " SELECT * FROM student WHERE yearGroup = '$seksyen' AND cohortID = '$cohort' ";
						}
						
						//if select only seksyen and payment
						elseif (($courseCode == "")&&($cohort == "")&&($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND payAmount < 400";	
							} 
							else
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND payAmount >= 400 ";
							}
						}

						//if select only seksyen and attendance ($training)
						elseif (($courseCode == "")&&($cohort == "")&&($payment == "")&&($certName == "")) 
						{
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND attendantStatus = '1' ";
							}	
						}
						
						//if select only seksyen and cert 
						elseif (($courseCode == "")&&($cohort == "")&&($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT * 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric 
							WHERE 
							yearGroup = '$seksyen' AND certID = '$certName' " ;
						}
						
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//if select only cohort and payment
						elseif (($courseCode == "")&&($seksyen == "")&&($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								cohortID = '$cohort' AND payAmount < 400";	
							} 
							else
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								cohortID = '$cohort' AND payAmount >= 400 ";
							}
						}

						//if select only cohort and attendance ($training)
						elseif (($courseCode == "")&&($seksyen == "")&&($payment == "")&&($certName == "")) 
						{
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								cohortID = '$cohort' AND attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								cohortID = '$cohort' AND attendantStatus = '1' ";
							}	
						}
						
						//if select only cohort and cert 
						elseif (($courseCode == "")&&($seksyen == "")&&($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT 
							* 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric WHERE cohortID = '$cohort' AND certID = '$certName' " ;
						}
						
			////////////////////////////////////////////////////////////////////////////////////////////////////////
						//if select only payment and attendance ($training)
						elseif (($courseCode == "")&&($seksyen == "")&&($cohort == "")&&($certName == "")) {
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' ";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' ";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' ";
							}	
						}
						
						//if select only payment and cert 
						elseif (($courseCode == "")&&($seksyen == "")&&($cohort == "")&&($training == "")) 
						{
							if ($payment == "notpaid")
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}
							else{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN 
								certacquire ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}	
						}
						
			
			//////////////////////////////////////////////////////////////////////////////////////////////////
						//if select only training and cert 
						elseif (($courseCode == "")&&($seksyen == "")&&($cohort == "")&&($payment == "")) 
						{
							if ($training == 0){
								$sqlfilter ="SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '0'							
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '1'							
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}	
						}
						
						
	/************************************************************************** THREE SEARCHING *****************************************************************************************/
						//if select only course and seksyen and cohort
						elseif (($payment == "")&&($training == "")&&($certName == "")) 
						{
							$sqlfilter = " SELECT * FROM student WHERE courseCode = '$courseCode' AND yearGroup = '$seksyen' AND cohortID = '$cohort'";
						}
						
						//if select only course and seksyen and payment
						elseif (($cohort == "")&&($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND payAmount < 400";	
							} else
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND payAmount >= 400 ";
							}
						}
						
						//if select only course and seksyen and training
						elseif (($cohort == "")&&($payment == "")&&($certName == "")) 
						{
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND attendantStatus = '1' ";
							}	
						}
						
						//if select only course and seksyen and cert
						elseif (($cohort == "")&&($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT * 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric 
							WHERE 
							courseCode = '$courseCode' AND yearGroup = '$seksyen' AND certID = '$certName' " ;
						}
						
						//if select only course and payment and training
						elseif (($seksyen == "")&&($cohort == "")&&($certName == "")) {
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' AND courseCode = '$courseCode'";
							}	
						}
						
						
						//if select only course and cohort and payment
						elseif (($seksyen == "")&&($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								cohortID = '$cohort' AND payAmount < 400 AND courseCode = '$courseCode'";	
							} 
							else
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								cohortID = '$cohort' AND payAmount >= 400 AND courseCode = '$courseCode'";
							}
						}

						//if select only course and cohort and cert 
						elseif (($seksyen == "")&&($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT 
							* 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric WHERE cohortID = '$cohort' AND certID = '$certName' AND courseCode = '$courseCode' " ;
						}
						
						//if select only seksyen and cohort and payment
						elseif (($courseCode == "")&&($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND cohortID = '$cohort' AND payAmount < 400";	
							} else
							{
								$sqlfilter = "SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND cohortID = '$cohort' AND payAmount >= 400 ";
							}
						}
						
						//if select only seksyen and cohort and training
						elseif (($courseCode == "")&&($payment == "")&&($certName == "")) 
						{
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								yearGroup = '$seksyen' AND cohortID = '$cohort' AND attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE yearGroup = '$seksyen' AND cohortID = '$cohort' AND attendantStatus = '1' ";
							}
						}
						
						//if select only seksyen and cohort and certName
						elseif (($courseCode == "")&&($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT * 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric 
							WHERE 
							yearGroup = '$seksyen' AND cohortID = '$cohort' AND certID = '$certName' " ;
						}
						
						//if select only seksyen and training and cert
						elseif (($courseCode == "")&&($cohort == "")&&($payment == "")) 
						{
							if ($training == 0){
								$sqlfilter ="SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '0'							
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName'
								AND
								yearGroup = '$seksyen'" ;
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '1'							
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName'
								AND
								yearGroup = '$seksyen'" ;
							}	
						}
						
						//if select only cohort and payment and training
						elseif (($courseCode == "")&&($seksyen == "")&&($certName == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND
							    cohortID = '$cohort'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND
							    cohortID = '$cohort'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND
							    cohortID = '$cohort'";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' 
								AND
							    cohortID = '$cohort'";
							}	
						}
						
						//if select only cohort and payment and cert 
						elseif (($courseCode == "")&&($seksyen == "")&&($training == "")) 
						{
							if ($payment == "notpaid")
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND cohortID = '$cohort'
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND cohortID = '$cohort'
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}
							
							
						}
						
						//if select only cohort and payment and certName
						elseif (($courseCode == "")&&($seksyen == "")&&($training == "")) 
						{
							if ($payment == "notpaid")
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName'
								AND 
								cohortID = '$cohort'" ;
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN 
								certacquire ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' 
								AND
							    cohortID = '$cohort'";
							}	
						}
						
						
						//if select only payment and training and cert
						elseif (($courseCode == "")&&($seksyen == "")&&($cohort == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' ";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' ";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student 
								INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}
							else{//有还钱有去
								$sqlfilter = " SELECT 
								* 
								FROM 
								student 
								INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' 
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' " ;
							}	
						}
						
						//if select only seksyen and payment and attendance ($training)
						elseif (($courseCode == "")&&($cohort == "")&&($certName == "")) {
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND yearGroup = '$seksyen'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND yearGroup = '$seksyen'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND yearGroup = '$seksyen'";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' AND yearGroup = '$seksyen'";
							}	
						}
						
						//if select only Cohort and training and cert 
						elseif (($courseCode == "")&&($seksyen == "")&&($payment == "")) 
						{
							if ($training == 0){
								$sqlfilter ="SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '0'	AND cohortID = '$cohort'						
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND cohortID = '$cohort'" ;
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '1'	AND cohortID = '$cohort'						
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND cohortID = '$cohort'" ;
							}	
						}
	/*********************************************************** FOUR SEARCHING ******************************************************************************/
						//if select only Course and Cohort and training and cert 
						elseif (($seksyen == "")&&($payment == "")) 
						{
							if ($training == 0){
								$sqlfilter ="SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '0'	AND cohortID = '$cohort' AND courseCode = '$courseCode'	 					
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND cohortID = '$cohort' AND courseCode = '$courseCode'" ;
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND attendantStatus = '1'	AND cohortID = '$cohort' AND courseCode = '$courseCode'						
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND cohortID = '$cohort' AND courseCode = '$courseCode'" ;
							}	
						}
						
						//if select only course and seksyen and cohort and payment
						elseif (($training == "")&&($certName == "")) 
						{
							if ($payment == "notpaid") 
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND cohortID = '$cohort' AND payAmount < 400";	
							} else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN payment 
								ON 
								student.noMatric=payment.noMatric 
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND cohortID = '$cohort' AND payAmount >= 400";
							}
						}
						
						//if select only course and cohort and payment and training
						elseif (($seksyen == "")&&($certName == "")) {
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND courseCode = '$courseCode AND cohortID = '$cohort''
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode' AND cohortID = '$cohort'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' AND courseCode = '$courseCode'";
							}	
						}
						
						//if select only Course and cohort and payment and cert 
						elseif (($seksyen == "")&&($training == "")) 
						{
							if ($payment == "notpaid")
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND cohortID = '$cohort' AND courseCode = '$courseCode'
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND courseCode = '$courseCode'" ;
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND cohortID = '$cohort' AND courseCode = '$courseCode'
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND courseCode = '$courseCode'" ;
							}
							
							
						}
						
						//if select only course and seksyen and cohort and training
						elseif (($payment == "")&&($certName == "")) 
						{
							if ($training == 0)
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE 
								courseCode = '$courseCode' AND yearGroup = '$seksyen' AND cohortID = '$cohort' AND attendantStatus = '0' ";
							}
							else
							{
								$sqlfilter = " SELECT * 
								FROM student 
								INNER JOIN 
								classattendance 
								ON 
								student.noMatric=classattendance.noMatric 
								WHERE courseCode = '$courseCode' AND yearGroup = '$seksyen' AND cohortID = '$cohort' AND attendantStatus = '1' ";
							}	
						}
						
						//if select only course and seksyen and cohort and cert
						elseif (($payment == "")&&($training == "")) 
						{
							$sqlfilter = " SELECT * 
							FROM student 
							INNER JOIN certacquire 
							ON 
							student.noMatric=certacquire.noMatric 
							WHERE 
							courseCode = '$courseCode' AND yearGroup = '$seksyen' AND cohortID = '$cohort' AND certID = '$certName' " ;
						}
																
						//if select only seksyen and cohort and payment and training
						elseif (($courseCode == "")&&($certName == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}	
						}
		
						
						//if select only seksyen and cohort and payment and certName
						elseif (($courseCode == "")&&($training == "")) 
						{
							if ($payment == "notpaid")
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN certacquire 
								ON student.noMatric=certacquire.noMatric WHERE certID = '$certName'
								AND 
								yearGroup = '$seksyen'
								AND 
								cohortID = '$cohort'" ;
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN 
								certacquire ON student.noMatric=certacquire.noMatric WHERE certID = '$certName' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}	
						}
						
						//if select only course and payment and training and cert
						elseif (($seksyen == "")&&($cohort == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student 
								INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND courseCode = '$courseCode'
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND courseCode = '$courseCode'" ;
							}
							else{//有还钱有去
								$sqlfilter = " SELECT 
								* 
								FROM 
								student 
								INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND courseCode = '$courseCode'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' AND courseCode = '$courseCode'
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND courseCode = '$courseCode'" ;
							}	
						}
						
						//if select only seksyen and payment and training and cert
						elseif (($courseCode == "")&&($cohort == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND yearGroup = '$seksyen'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND yearGroup = '$seksyen'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student 
								INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' AND yearGroup = '$seksyen'
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND yearGroup = '$seksyen'" ;
							}
							else{//有还钱有去
								$sqlfilter = " SELECT 
								* 
								FROM 
								student 
								INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400 AND yearGroup = '$seksyen'
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' AND yearGroup = '$seksyen'
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' AND yearGroup = '$seksyen'" ;
							}	
						}
	/********************************************************************* FIVE SEARCHING ******************************************************************/    
						//if select only course and seksyen and cohort and payment and training
						elseif (($certName == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							else
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' 
								AND
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}	
						}
		
						//if select only seksyen and cohort and payment and training and cert
						elseif (($courseCode == "")) 
						{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							else
							{//有还钱有去
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' 
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' 
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}	
						}
				
		/********************************************************************** ALL SEARCHING ***********************************************************************/
						else{
							//没有给钱没有去training - common
							if ($payment == "notpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								courseCode = '$courseCode'
								AND
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//给钱没有去trainning - common
							else if($payment == "fullpaid" && $training == 0)
							{
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								AND 
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							//bug
							else if ($payment == "notpaid" && $training == 1)
							{
								$training == 0;
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount<400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '0' 
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' 
								AND 
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}
							else
							{//有还钱有去
								$sqlfilter = " SELECT 
								* 
								FROM 
								student INNER JOIN payment 
								ON 
								student.noMatric = payment.noMatric AND payment.payAmount>=400
								INNER JOIN classattendance 
								ON 
								student.noMatric=classattendance.noMatric AND classattendance.attendantStatus = '1' 
								INNER JOIN certacquire 
								ON 
								student.noMatric=certacquire.noMatric WHERE certID = '$certName' 
								AND 
								courseCode = '$courseCode'
								AND 
								yearGroup = '$seksyen'
								AND
							    cohortID = '$cohort'";
							}	
						}
						
						$resultOfFilter = mysqli_query($connect, $sqlfilter);
						$count = 0;

					    while ($row = mysqli_fetch_array($resultOfFilter)) 
						{
					    	$count++;
					    	$matricNo = $row["noMatric"];
					    	echo '<tr>';
					    	echo '<td>' . $count .'</td>';
					    	echo '<td>' . $matricNo .'</td>';
					    	echo '<td>' . $row["studentName"] .'</td>';
					    	echo '<td>' . $row["yearGroup"] .'</td>'; //Seksyen

					    	//Retrieve Cohort Year From cohort Table based on ID
					    	$cohortYearID = $row["cohortID"];
					    	$sql_cohortYear = "SELECT cohortYear FROM cohort WHERE cohortID = '$cohortYearID'";
					    	$query_cohortYear = mysqli_query($connect, $sql_cohortYear);
					    	while ($rowCohortYear = mysqli_fetch_array($query_cohortYear)){
					    		echo '<td>' . $rowCohortYear["cohortYear"] .'</td>'; //cohort
					    	}
					    	
					    	//Retrieve payment From payment table based on Matric Number
					    	$sql_payment = "SELECT payAmount FROM payment WHERE noMatric = '$matricNo'";
					    	$query_payment = mysqli_query($connect, $sql_payment);
							$rowPayment = mysqli_fetch_array($query_payment);
							if($rowPayment != 0)
							{
								echo '<td>' . $rowPayment["payAmount"] .'</td>'; 
							}
							else
							{
								echo '<td> No Payment</td>';
							}

					    	//Retrieve Attendance From classattendance table
					    	$sql_attendance = "SELECT attendantStatus FROM classattendance WHERE noMatric = '$matricNo'";
					    	$query_attendance = mysqli_query($connect, $sql_attendance);
							$rowAttendance = mysqli_fetch_array($query_attendance);
							
							if($rowAttendance != 0)
							{
					    		$attendanceStatus = $rowAttendance["attendantStatus"];

									if ($attendanceStatus == 0)
									{
										echo '<td> Not Yet Attempt </td>';
									}
									else{
										echo '<td> Attempted </td>';
									}
							}
							else
							{
								echo '<td> No Attendance</td>';
							}
					    	
					    	//Retrieve certificateAcquire From certacquire table
					    	$sql_certAcquire = "SELECT certID FROM certacquire WHERE noMatric = '$matricNo'";
					    	$query_certAcquire = mysqli_query($connect, $sql_certAcquire);
					    	$check_certAcquired = mysqli_fetch_array($query_certAcquire);
							if($check_certAcquired != 0)
							{
								$checkCertID = $check_certAcquired["certID"];
								
								$sql_certAcquireName = "SELECT certName FROM certificate WHERE certID = '$checkCertID'";
								$query_certAcquireName = mysqli_query($connect, $sql_certAcquireName);
								$check_certAcquiredName = mysqli_fetch_array($query_certAcquireName);
								echo '<td>' . $check_certAcquiredName["certName"] .'</td>';
							}
							else
							{
								echo '<td> No Cert</td>';
							}
	
					    	//CourseCode
					    	echo '<td>' . $row["courseCode"] .'</td>'; //courseCode
					    	/*echo "<td>
					                <a href='ManageStudent/updateStudent.php?matric=".$row['noMatric']."'><button type='button'>Edit</button></a>
					                <a href='ManageStudent/removeStudent.php?matric=".$row['noMatric']."'><button type='button'>Remove</button></a>
				                </td>";*/
						}
						echo "</table>";
					 }
				?>	
			</div>
		</div>
	</div>
	</div>
</body>
</html>
<script>
$(document).ready(function(){
 $('#registersubmit').click(function(){
	 	$.ajax({
	 		type: "POST",
	 		url:'/certSystem/ManageUser/registerUser.php',
	 		data: $('#formregister').serialize(),	
	 	}).done(function(){
	 		alert("You Have Successfully Register");
	 	});
	});
});


</script>
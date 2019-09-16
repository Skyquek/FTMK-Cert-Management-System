<?php
require_once('../connect.php');
	if(isset($_POST['submit']))
	{
		$filename=$_FILES["file"]["tmp_name"]; 
		  $file = fopen($filename, "r");

		  //get only csv lines
		  fgetcsv($file);

		         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
		         {
		         	$csvMatric = $emapData[0];
		         	$csvName = $emapData[1];
		         	$csvSection = $emapData[2];
		         	$csvCohortYear = $emapData[3];
		         	$csvCourse = strtoupper($emapData[4]);
		         	$csvPayment =  $emapData[5];

		         	$sql_cohortID = "SELECT cohortID FROM cohort WHERE cohortYear = '$csvCohortYear'";
		         	$query_cohortID = mysqli_query($connect, $sql_cohortID);
					$row_cohortID =  mysqli_fetch_array($query_cohortID);
					$csv_cohortID = $row_cohortID['cohortID'];

		         	$sqlcheckmatric = "SELECT noMatric FROM student WHERE noMatric = '$csvMatric'";
		         	$csvresult = mysqli_query($connect, $sqlcheckmatric);
					$user =  mysqli_fetch_array($csvresult);

					if ($user['noMatric'] !== $csvMatric) {
						$sql_student = "INSERT INTO student (noMatric,studentName,yearGroup,cohortID,courseCode) VALUES ('$csvMatric', '$csvName', '$csvSection', '$csv_cohortID', '$csvCourse')";
				  		mysqli_query($connect, $sql_student);

				  		$sql_payment = "INSERT INTO payment (noMatric,payAmount) VALUES ('$csvMatric','$csvPayment')";
				  		mysqli_query($connect, $sql_payment);	      		
			  		}

		           
		         }
		         fclose($file);
		         echo "
		         <script>
		         	alert('CSV File has been successfully Imported.');
		         </script>
		         ";
		         header('location: manageStudent.php');

	}
	else {
		echo "not POST";
	}
?>
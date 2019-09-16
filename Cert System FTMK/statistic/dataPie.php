<?php
include('../connect.php');

 if ($_SERVER["REQUEST_METHOD"] == "POST")
	if(isset($_POST['cohort'])) 
	{
		$piechart_data = "";
		$cohortID = $_POST['cohort'];
		$sql_showcourse = "SELECT CourseCode FROM department";
		$query_showcourse = mysqli_query($connect, $sql_showcourse);
		foreach (mysqli_fetch_all($query_showcourse) as $row_showcourse) 
		{
			$CourseCode = $row_showcourse[0];
			//print_r($row_showcourse);

			$sql_showcourse = "SELECT COUNT(noMatric) 
						   FROM student 
						   WHERE courseCode = '$CourseCode' AND cohortID = '$cohortID' ";
			$query_showcourse = mysqli_query($connect, $sql_showcourse);
			$row_showcourse2 =  mysqli_fetch_array($query_showcourse);
			$showcourse2 = $row_showcourse2['COUNT(noMatric)'];

			$ar[] = array(
				'label' => $CourseCode, 
				'value' => $showcourse2);

			//$piechart_data .= "{label:'". $CourseCode . " ', value:" . $showcourse2 . "}, ";

		}
		echo json_encode($ar);
	}
?>
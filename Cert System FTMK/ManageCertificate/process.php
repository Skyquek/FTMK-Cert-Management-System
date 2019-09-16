<?php
include('../connect.php');

$course = $_POST['course'];
$cohort = $_POST['cohort'];
$sql_findstudent = "SELECT student.noMatric 
						FROM student INNER JOIN classattendance
						ON 
						student.noMatric = classattendance.noMatric
						AND
						classattendance.attendantStatus > 0
						AND
						student.courseCode = '$course'
						AND
						student.cohortID = '$cohort'
						";
	$query_findstudent = mysqli_query($connect, $sql_findstudent);

	foreach (mysqli_fetch_all($query_findstudent, MYSQLI_ASSOC) as $key => $value) {
		$student_matric[$value['noMatric']] = $value['noMatric'];
		$matric_available = $student_matric[$value['noMatric']];
		$sql_validatestudent = "SELECT * FROM certacquire WHERE noMatric='$matric_available' LIMIT 1";
		$query_validatestudent = mysqli_query($connect, $sql_validatestudent);
		$row_validatestudent = mysqli_fetch_array($query_validatestudent);
		 
		if($row_validatestudent['noMatric'] != $matric_available)
		{
			$student_available[$value['noMatric']] = $value['noMatric'];
		}
	}

echo json_encode($student_available);

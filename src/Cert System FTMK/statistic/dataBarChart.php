<?php
include('../connect.php');

		$courseCodePOST = $_POST['courseCode'];
		$cohortcoursePOST = $_POST['cohortcourse'];
		
		//Payment Status by Course
		$sql_paid = "SELECT COUNT(payment.noMatric) FROM 
						   payment INNER JOIN student
						   ON
						   payment.noMatric = student.noMatric
						   AND
						   payment.payAmount >= 400
						   AND
						   student.courseCode = '$courseCodePOST'
						   AND
						   student.cohortID = '$cohortcoursePOST'";

		$query_paid = mysqli_query($connect, $sql_paid);
		$row_paid =  mysqli_fetch_array($query_paid);
?>

<?php		
		$sql_unpaidval = "SELECT COUNT(payment.noMatric) FROM 
					   payment INNER JOIN student
					   ON
					   payment.noMatric = student.noMatric
					   AND
					   payment.payAmount < 400
					   AND
					   student.courseCode = '$courseCodePOST'
					   AND
					   student.cohortID = '$cohortcoursePOST'";

		$query_unpaidval = mysqli_query($connect, $sql_unpaidval);
		$row_unpaidval =  mysqli_fetch_array($query_unpaidval);
		
		

		$ar[] = array(
				'valPaid' => $row_paid[0], 
				'valUnpaid' => $row_unpaidval[0]);

		//$barchart_data = "{y: 'Fully Paid', a:". $row_paid[0] ." },{y: 'Not Fully Paid', a:". $row_unpaid[0] ."},";
		//$someArray = json_decode($barchart_data);

		echo json_encode($ar);
?>
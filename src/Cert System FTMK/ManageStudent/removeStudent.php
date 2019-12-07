<?php
include('../navbar.php');
include('../connect.php');

if($_GET['noMatric']) {
    $noMatric = $_GET['noMatric'];

    //Delete student payment
    $sql_payment = "DELETE FROM payment WHERE noMatric = '$noMatric'";
    $query_payment = mysqli_query($connect, $sql_payment);

    //Delete student table
    $sql_student = "DELETE FROM student WHERE noMatric = '$noMatric'";
    $query_student = mysqli_query($connect, $sql_student);
	echo '
		<script>
		alert("Delete Succecssfully!");
		window.location.href = "/certSystem/ManageStudent/viewStudent.php";
		</script>
	';
}
?>
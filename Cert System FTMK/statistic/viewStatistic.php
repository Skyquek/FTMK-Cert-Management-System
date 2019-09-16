<?php
include('../connect.php');
include('../navbar.php');
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<title></title>
</head>
<style>
table,html {
	height: 100%;
}
</style>
<body>
	<table width=100% height=100% style="table-layout: fixed">
		<tbody>
			<tr align="center" width=50%>
				<td>Number of Students by Course</td>
				<td>Students Payment Status</td>
			</tr>

			<tr>
				<td>
					<label for="cohort">Cohort Year: </label>
					<select id="selectcohort" name="cohort">
						<?php
						//Number of Student By course Chart
						$sql_cohort = "SELECT * FROM cohort";
						$query_cohort = mysqli_query($connect, $sql_cohort);

						while($row_cohort =  mysqli_fetch_array($query_cohort))
						{
							$cohortYear = $row_cohort['cohortYear'];
							$cohortID = $row_cohort['cohortID'];

							echo "<option value=". $cohortID .">". $cohortYear . "</option>";
						}
					?>
					</select>
					<button id="cohortbtn" type="submit" form="bycohort" value="Submit">Submit</button>
				</td>



				<!--<form action="" id="bycourse" method="POST">-->
					<td>
						<label for="courseCode">Course: </label>
						<select id="courseCode" name="courseCode">
						<?php
							//Number of Student By course Chart
							$sql_showcourse = "SELECT CourseCode FROM department";
							$query_showcourse = mysqli_query($connect, $sql_showcourse);

							while($row_showcourse =  mysqli_fetch_array($query_showcourse))
							{
								$CourseCode = $row_showcourse['CourseCode'];

								    echo "<option value=". $CourseCode .">". $CourseCode . "</option>";
							}
						?>
						</select>

						<label for="cohortcourse">Cohort: </label>
						<select id="cohortcourse" name="cohortcourse">
						<?php
							//Number of Student By course Chart
							$sql_cohort = "SELECT * FROM cohort";
							$query_cohort = mysqli_query($connect, $sql_cohort);

							while($row_cohort =  mysqli_fetch_array($query_cohort))
							{
								$cohortYear = $row_cohort['cohortYear'];
								$cohortID = $row_cohort['cohortID'];

								echo "<option value=". $cohortID .">". $cohortYear . "</option>";
							}
						?>
						</select>

						<button id="cohortcoursebtn" type="submit" form="bycourse" value="Submit">Submit</button>
					</td>
				<!--</form>-->

			</tr>


			<tr>
				<td height=100%>
					<div id="student_pieChart" style="width: 100%; height: 100%; margin-top:200px;"></div>
				</td>
				<td height=100%>
					<div id="payment_barchart" style="width: 100% height: 100%; margin-top: 200px;"></div>
				</td>

			</tr>
		</tbody>
	</table>
</body>
</html>
<script>

	$('#cohortbtn').click(
		function(){
			var value = $('#selectcohort').val();
			$.ajax({  
			    type: 'POST',  
			    url: 'dataPie.php', 
			    data: {
			    	cohort: value
			    },
			    success: function(response){
					
					var newdata = JSON.parse(response);
					console.log(newdata);
					createPiechart(newdata);
				}
			});
		}
	);

	function createPiechart(newdata){
		$('#student_pieChart').empty();
		Morris.Donut({
		  element: 'student_pieChart',
		  data: newdata,
		});
	
	}

	$('#cohortcoursebtn').click(
		function(){
			var course = $('#courseCode').val();
			var cohort = $('#cohortcourse').val();
			console.log(course);
			console.log(cohort);
			$.ajax({  
			    type: 'POST',  
			    url: 'dataBarChart.php', 
			    data: {
			    	courseCode: course,
			    	cohortcourse: cohort
			    },
			    success: function(response){
					var newdata = JSON.parse( response );
					console.log(newdata[0]['valPaid']);
					createBarchart(newdata[0]['valPaid'], newdata[0]['valUnpaid']);
				}
			});
		}
	);

	function createBarchart(paid,unpaid)
	{
		$('#payment_barchart').empty();
		var newdata = [{y: 'Fully Paid', a: paid },{y: 'Not Fully Paid', a: unpaid},];
		Morris.Bar({
		  element: 'payment_barchart',
		  data: newdata,
		  xkey: 'y',
		  ykeys: ['a', 'b'],
		  labels: ['labels']
		});
	}

</script>
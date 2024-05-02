<?php
	include('secure.php');
	include('connection.php');
	include('nav_stu.php');
?>
<link rel="stylesheet" href="table2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<!-- Display a table with quiz history details -->
	<table>
		<caption>LIST OF HISTORY</caption>
		<tr>
			<th>No</th>
			<th>Topic</th>
			<th>Date Time</th>
			<th>Marks</th>
            <th>Grade</th>
            <th>Comment</th>
            <th>Details</th>

		</tr>
		<?php
			//Initialize additional conditions based on the report type
			$additional_conditions = "";
			//Initialize the idtopic, startdate, and enddate
			$idtopic = '';
			$startdate = '';
			$enddate = '';

			if ($_SERVER['REQUEST_METHOD'] === 'GET') {
				$report_type = $_GET['option'];

				if ($report_type == 2) {
					//If report type is Topics, get the selected topic ID
					$idtopic = $_GET['topic'];
					$additional_conditions .= " AND overall_result.TopicID = '$idtopic'";
				} elseif ($report_type == 3) {
					//If report type is Date, get the selected start and end dates
					$startdate = $_GET['startdate'];
					$enddate = $_GET['enddate'];
					$additional_conditions .= " AND overall_result.AnsDateTime BETWEEN '$startdate' AND '$enddate'";
				}
			}

			//Make the SQL query to include additional conditions
			$sql = "SELECT * FROM overall_result JOIN topic ON overall_result.TopicID = topic.TopicID 
					WHERE overall_result.StuID = ? $additional_conditions ORDER BY overall_result.AnsDateTime DESC";

			$idstudent = $_SESSION['userid'];        
			
			//Prepare and execute the SQL statement
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "s", $idstudent);
			mysqli_stmt_execute($stmt);
			$data = mysqli_stmt_get_result($stmt);

			//Check if there are quiz history records
			if (mysqli_num_rows($data) == 0) {
				echo '<script>alert("No quiz history for the selected date range."); window.location.href = "student_resultfilter.php";</script>';
				exit();
			}

			//Display quiz history details in the table
			$num = 1;
			while($question = mysqli_fetch_array($data)){
        ?>

		<tr>
            <td class="num"><?php echo $num; ?></td>
            <td class="question">
                <?php echo "$question[TopicName]"; ?>
            </td>
            <td class="question">
                <?php echo "$question[AnsDateTime]"; ?>
            </td>
            <td class="question">
                <?php echo "$question[Marks]"; ?>
            </td>
            <td class="question">
                <?php echo "$question[Grade]"; ?>
            </td>
            <td class="question">
                <?php echo "$question[Comment]"; ?>
            </td>
            <td class="question">
                <button onclick="window.location='student_resultdetailview.php?resultID=<?php echo $question['OvResultID']; ?>&option=<?php echo $report_type; ?>&topic=<?php echo $idtopic; ?>&startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&stuid=<?php echo $idstudent; ?>'">
                    Details
                </button>
            </td>
        </tr>


		<?php
				$num = $num+1;
			}
		?>
	</table>
	<div class="buttons-row">
        <button class="print" onclick="window.print()">Print</button>
        <button class="back" onclick="window.location='student_resultfilter.php'">Back</button>
    </div>
</div>


<?php
include('secure.php');
include('connection.php');
	
	$LecID = $_SESSION['userid'];
	$sql = "SELECT LecType FROM lecturer WHERE LecID = '$LecID'";
	$result = mysqli_query($connection, $sql);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$LecType = $row['LecType'];
		if ($LecType == 1) {
			include('nav_hom.php');
		} elseif ($LecType == 2) {
			include('nav_lec.php');
		}
	}
?>

<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<!-- Display the all the student result in table base on the option that have chosen from the filter -->
<div class="content">
	<table>
		<!-- Checkbox to toggle displaying rows with null comments -->
        <tr><td colspan ="9">
            <input type="checkbox" id="no-commentFilter" class="filterswitch">
            Show Null Comments
        </td></tr>
        <caption>LIST OF RESULT</caption>
        <tr>
            <th>No</th>
            <th>Student</th>
            <th>Topic</th>
            <th>Date Time</th>
            <th>Marks</th>
            <th>Grade</th>
            <th>Comment</th>
            <th>Details</th>
        </tr>
        <?php
			//Define variables before the if statement(to avoid error in the url)
			$grade = '';
			$startDate = '';
			$endDate = '';

			//Check if the filter parameters are set
			if (isset($_GET['option'])) {
				$option = $_GET['option'];
				 //Adjust the SQL query based on the selected filter option
				if ($option == 2) {
					//Based on the selected grade
					$grade = $_GET['grade'];
					$sql = "SELECT * FROM topic JOIN overall_result ON topic.TopicID = overall_result.TopicID JOIN student ON student.StuID = overall_result.StuID WHERE student.StuID = overall_result.StuID AND overall_result.Grade = '$grade'";
				} elseif ($option == 3) {
					//Based on the selected date range
					$startDate = $_GET['startdate'];
					$endDate = $_GET['enddate'];
					$sql = "SELECT * FROM topic JOIN overall_result ON topic.TopicID = overall_result.TopicID JOIN student ON student.StuID = overall_result.StuID WHERE student.StuID = overall_result.StuID AND overall_result.AnsDateTime BETWEEN '$startDate' AND '$endDate'";
				} 
			
				//Execute the query and fetch the data
				$data = mysqli_query($connection, $sql);
				$num = 1;

				//Display the filtered results
				while ($question = mysqli_fetch_array($data)) {
		?>
		<tr class="resultRow <?php echo empty($question['Comment']) ? 'noComment' : ''; ?>">
			<td class="num"><?php echo $num; ?></td>
			<td class="question"><?php echo "$question[StuName]"; ?></td>
			<td class="question"><?php echo "$question[TopicName]"; ?></td>
			<td class="question"><?php echo "$question[AnsDateTime]"; ?></td>
			<td class="question"><?php echo "$question[Marks]"; ?></td>
			<td class="question"><?php echo "$question[Grade]"; ?></td>
			<td class="question"><?php echo "$question[Comment]"; ?></td>
			<td class="question">
			<button onclick="window.location='lecturer_resultdetailview.php?resultID=<?php echo $question['OvResultID']; ?>&option=<?php echo $option; ?>&grade=<?php echo $grade; ?>&startdate=<?php echo $startDate; ?>&enddate=<?php echo $endDate; ?>'">
			Details</button>
			</td>
		</tr>
        <?php
					$num = $num + 1;
				}
			}
        ?>
    </table>
    <?php
    //Check if there are any records found
    if (mysqli_num_rows($data) === 0) {
        echo '<script>alert("No quiz history for this record filter."); window.location.href = "lecturer_resultfilter.php";</script>';
    }
    ?>

    <div class= "buttons-row">
		<button class="print" onclick="printTable()">Print</button>
		<button class="back" onclick="window.location='lecturer_resultfilter.php'">Back</button>
    </div>
</div>

<!-- JavaScript to toggle displaying rows with null comments -->
<script>
document.getElementById('no-commentFilter').addEventListener('change', function () {
    //Get the value of the checkbox for filtering rows.
	var showOnlyNoComment = this.checked;
	//Get all rows with the class 'resultRow'.
    var rows = document.getElementsByClassName('resultRow');

	//Iterate through each row and adjust display based on the presence of 'noComment' class.
    for (var i = 0; i < rows.length; i++) {
        var hasComment = rows[i].classList.contains('noComment');
        rows[i].style.display = showOnlyNoComment ? (hasComment ? '' : 'none') : '';
    }
});
</script>


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

	//Get filtering parameters from GET request
	$grade = isset($_GET['grade']) ? $_GET['grade'] : '';
	$startDate = isset($_GET['startdate']) ? $_GET['startdate'] : '';
	$endDate = isset($_GET['enddate']) ? $_GET['enddate'] : '';
	$idovresult = $_GET['resultID'];
	$option = $_GET['option'];
?>

<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<!-- Display result in a table -->
<div class="content">
	<table>
		<caption>RESULT</caption>
		<tr>
			<th>No.</th>
			<th>Questions</th>
			<th>Results</th>
		</tr>
		<?php
		//Fetch and display details in the overall_result and result table
			$sql = "SELECT * FROM overall_result JOIN record ON overall_result.OvResultID = record.OvResultID 
			JOIN question ON record.QuestID = question.QuestID WHERE overall_result.OvResultID ='".$idovresult."'";

			$data = mysqli_query($connection,$sql);
			$num = 1;
			
			while($question = mysqli_fetch_array($data)){
		?>
		
		<tr>
			<td class="num"><?php echo $num; ?></td>
			<td class="question">
				<?php
				//Display question title and options based on question type
					$type = $question['QuestType'];
					echo "$question[QuestTitle]<br>";

					if ($type == 1) {
						//Display options for multiple-choice questions
						echo "
						<input type=radio name=$question[QuestID] value='A' " . ($question['StuAnswer'] == 'A' ? 'checked' : 'disabled') . ">A.$question[Option1]<br>
						<input type='radio' name='$question[QuestID]' value='B' " . ($question['StuAnswer'] == 'B' ? 'checked' : 'disabled') . ">B.$question[Option2]<br>
						<input type='radio' name='$question[QuestID]' value='C' " . ($question['StuAnswer'] == 'C' ? 'checked' : 'disabled') . ">C.$question[Option3]<br>
						<input type='radio' name='$question[QuestID]' value='D' " . ($question['StuAnswer'] == 'D' ? 'checked' : 'disabled') . ">D.$question[Option4];
						";
					} else if ($type == 2) {
						//Display options for true/false questions
						echo "
						<input type='radio' name='$question[QuestID]' value='True' " . ($question['StuAnswer'] == 'True' ? 'checked' : 'disabled') . ">True<br>
						<input type='radio' name='$question[QuestID]' value='False' " . ($question['StuAnswer'] == 'False' ? 'checked' : 'disabled') . ">False<br>
						";
					} else if ($type == 3) {
						//Display text input for subjective questions
						echo "
						<input type='text' name='$question[QuestID]' value='$question[StuAnswer]' readonly><br>
						";
					}
				?>
			</td>
				
			<td class="schema">
				<br>
				<?php
					//Check the correctness of student's answer and display appropriate information
					if (!is_null($question['StuAnswer']))  {
						echo "Answer: " . $question['QuestAnswer'] . "<br>";
						echo "Student's Answer: " . $question['StuAnswer'] . "<br>";

						//Display correct/wrong indicator based on correctness
						if (strtolower($question['StuAnswer']) == strtolower($question['QuestAnswer'])) {
							echo "<img src='correct.jpg' style='width: 20px; height: 20px;'>";
						} else {
							echo "<img src='wrong.jpg' style='width: 20px; height: 20px;'>";
						}
					} else {
						//Handle the case where student's anwer is null
						echo "Answer: ".$question['QuestAnswer']." <br>";
						echo "Student's Answer: N/A <br>";
						echo "<img src='wrong.jpg' style='width: 20px; height: 20px;'>";
					}
				?>
			</td>
			
			<?php
				$num = $num+1;
			}
			?>
		</tr>

		<!-- Comment form section -->
		<tr>
			<form method="post" action="lecturer_updatecomment.php?option=<?php echo $option; ?>&grade=<?php echo $grade; ?>&startdate=<?php echo $startDate; ?>&enddate=<?php echo $endDate; ?>">

			<td colspan="3">
				<?php
					//Fetch the existing comment from the database for the given $idovresult
					$fetchCommentSql = "SELECT Comment FROM overall_result WHERE OvResultID = '$idovresult'";
					$result = mysqli_query($connection, $fetchCommentSql);
					
					//Check if the query was successful
					if ($result) {
						$row = mysqli_fetch_assoc($result);
						$existingComment = $row['Comment'];

						//If there is an existing comment, set it as the default value for the textarea
						if (!empty($existingComment)) {
							echo '<textarea name="comment" placeholder="Enter your comment here...">' . htmlspecialchars($existingComment) . '</textarea>';
						} else {
							echo '<textarea name="comment" placeholder="Enter your comment here..."></textarea>';
						}
					} else {
						//Handle the case where the query fails
						echo 'Error fetching existing comment: ' . mysqli_error($connection);
					}
				?>
			</td>
		</tr>
	</table>
    <input type="hidden" name="idovresult" value="<?php echo $idovresult; ?>">
	<div class="buttons-row">
		<button type="submit" class="comment">Add Comment</button>
		<button type="button" class="print" onclick="window.print()">Print</button>	
		<button type="button" class="back" onclick="window.location='lecturer_resultview.php?option=<?php echo $option; ?>&grade=<?php echo $grade; ?>&startdate=<?php echo $startDate; ?>&enddate=<?php echo $endDate; ?>'">Back</button>
	</div>
	</form>
</div>

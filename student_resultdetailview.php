<?php
	include('secure.php');
	include('connection.php');
	include('nav_stu.php');

    $idovresult= $_GET['resultID'];
	$topic = isset($_GET['topic']) ? $_GET['topic'] : '';
	$startDate = isset($_GET['startdate']) ? $_GET['startdate'] : '';
	$endDate = isset($_GET['enddate']) ? $_GET['enddate'] : '';
	$option = $_GET['option'];
?>
<link rel="stylesheet" href="table2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<!-- Display result table -->
	<table>
		<caption>YOUR RESULT</caption>
		<tr>
			<th>No.</th>
			<th>Questions</th>
			<th>Results</th>
		</tr>
		<?php
			$idstudent = $_SESSION['userid'];
			//SQL query to fetch details of the quiz result for the specified user and overall result id 
			$sql = "SELECT * FROM overall_result JOIN record ON overall_result.OvResultID = record.OvResultID 
			JOIN question ON record.QuestID = question.QuestID WHERE overall_result.OvResultID ='".$idovresult."' AND overall_result.StuID='".$idstudent."' ORDER BY question.QuestID ASC";

			//Execute the query
			$data = mysqli_query($connection,$sql);
			$num = 1;

			// Loop through the result set and display quiz details
			while($question = mysqli_fetch_array($data)){
		?>
		
		<tr>
			<td class="num"><?php echo $num; ?></td>
			<td class="question">
				<?php
				//Determine the question type
				$type = $question['QuestType'];
				echo "$question[QuestTitle]<br>";
				
				//Display options based on the question type
				if ($type == 1) {
					echo "
					<input type=radio name=$question[QuestID] value='A' " . ($question['StuAnswer'] == 'A' ? 'checked' : 'disabled') . ">A.$question[Option1]<br>
					<input type='radio' name='$question[QuestID]' value='B' " . ($question['StuAnswer'] == 'B' ? 'checked' : 'disabled') . ">B.$question[Option2]<br>
					<input type='radio' name='$question[QuestID]' value='C' " . ($question['StuAnswer'] == 'C' ? 'checked' : 'disabled') . ">C.$question[Option3]<br>
					<input type='radio' name='$question[QuestID]' value='D' " . ($question['StuAnswer'] == 'D' ? 'checked' : 'disabled') . ">D.$question[Option4];
					";
				} else if ($type == 2) {
					echo "
					<input type='radio' name='$question[QuestID]' value='True' " . ($question['StuAnswer'] == 'True' ? 'checked' : 'disabled') . ">True<br>
					<input type='radio' name='$question[QuestID]' value='False' " . ($question['StuAnswer'] == 'False' ? 'checked' : 'disabled') . ">False<br>
					";
				} else if ($type == 3) {
					echo "
					<input type='text' name='$question[QuestID]' value='$question[StuAnswer]' readonly><br>
					";
				}
				?>
			</td>
			
			<td class="schema">
				<br>
				<?php
					// Check if both $question['StuAnswer'] and $question['QuestAnswer'] are not null before using strtolower()
					if (!is_null($question['StuAnswer']))  {
						echo "Answer: " . $question['QuestAnswer'] . "<br>";
						echo "Your Choice: " . $question['StuAnswer'] . "<br>";
						//Display correct/wrong image based on the correctness of the answer
						if (strtolower($question['StuAnswer']) == strtolower($question['QuestAnswer'])) {
							echo "<img src='correct.jpg' style='width: 20px; height: 20px;'>";
						} else {
							echo "<img src='wrong.jpg' style='width: 20px; height: 20px;'>";
						}
					} else {
						//Handle the case where $question['StuAnswer'] is null
						echo "Answer: ".$question['QuestAnswer']." <br>";
						echo "Your Choice: N/A <br>";
						echo "<img src='wrong.jpg' style='width: 20px; height: 20px;'>";
					}
				?>
			</td>
		</tr>
			<?php
				$num = $num+1;
			}
			?>
	</table>
	<button class="back" onclick="window.location='student_resultview.php?option=<?php echo $option; ?>&topic=<?php echo $topic; ?>&startdate=<?php echo $startDate; ?>&enddate=<?php echo $endDate; ?>&stuid=<?php echo $idstudent; ?>'">Back</button>
</div>
<?php
	include('secure.php');
	include('connection.php');
	include('nav_stu.php');
	$idtopic = $_GET['topicID'];
	$idresult =$_GET['resultID'];
?>
<link rel="stylesheet" href="table2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<table>
		<caption>YOUR RESULT</caption>
		<tr>
			<th>No.</th>
			<th>Questions</th>
			<th>Results</th>
		</tr>
		<?php
		    //Query to get the total number of approved questions for the selected topic, and the topic of the questions is not deleted as well
			$numquestsql = "SELECT COUNT(QuestID) AS total FROM question JOIN topic ON question.TopicID = topic.TopicID WHERE question.TopicID= '".$idtopic."' AND QuestApprovalStatus= 'Y' AND QuestDeleteStatus= 'N'";

			$numdata = mysqli_query($connection,$numquestsql);
			$totalnum = mysqli_fetch_array($numdata)['total'];

			//Initialize variables
			$correct = 0;
			$idstudent = $_SESSION['userid'];

			//Query to fetch quiz results based on the selected topic, student, and resultID
			$sql = "SELECT * FROM overall_result JOIN record ON overall_result.OvResultID = record.OvResultID 
			JOIN question ON record.QuestID = question.QuestID JOIN topic 
			ON question.TopicID = topic.TopicID WHERE question.TopicID ='".$idtopic."' 
			AND overall_result.StuID='".$idstudent."' AND record.OvResultID = '".$idresult."' AND QuestApprovalStatus= 'Y' AND QuestDeleteStatus= 'N' ORDER BY question.QuestID ASC";

			$data = mysqli_query($connection,$sql);
			$num = 1;

			//Display each question and result
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
					//Check the student's answer is not null
					if (!is_null($question['StuAnswer']))  {
						//Display the correct answer and the student's choice.
						echo "Answer: " . $question['QuestAnswer'] . "<br>";
						echo "Your Choice: " . $question['StuAnswer'] . "<br>";
						
						//Check correctness and display the appropriate indicator.
						if (strtolower($question['StuAnswer']) == strtolower($question['QuestAnswer'])) {
							echo "<img src='correct.jpg' style='width: 20px; height: 20px;'>";
							$correct = $correct + 1;
						} else {
							echo "<img src='wrong.jpg' style='width: 20px; height: 20px;'>";
						}
					} else {
						//Handle the case where student answer is null
						echo "Answer: ".$question['QuestAnswer']." <br>";
						echo "Your Choice: N/A <br>";
						echo "<img src='wrong.jpg' style='width: 20px; height: 20px;'>";
					}
				?>
			</td>
		</tr>
		<?php
				$num = $num+1;
				$topic = $question['TopicID'];
			}
		?>
	</table>
	
	<?php
		//Calculate the percentage and update the overall result
		$percentage = round($correct / $totalnum * 100);
		$wrong = $totalnum - $correct;

		//Fetch the overall result ID based on the provided result id and student id
		$ovresultid = "SELECT OvResultID FROM overall_result WHERE OvResultID = '$idresult' AND StuID='$idstudent'";
		$oviddata = mysqli_query($connection, $ovresultid);
		$ovresult = mysqli_fetch_array($oviddata);
		
		//Check if $ovresult is not null and has the 'OvResultID' key
		if (!is_null($ovresult) && isset($ovresult['OvResultID'])) {
			$sql = "UPDATE overall_result 
			SET Marks = $percentage, 
				Grade = CASE WHEN $percentage >= 80 THEN 'A'
							 WHEN $percentage >= 70 THEN 'B'
							 WHEN $percentage >= 60 THEN 'C'
							 WHEN $percentage >= 50 THEN 'D'
							 ELSE 'F'
						END
			WHERE OvResultID = '" . $ovresult['OvResultID'] . "'";
			
			$data = mysqli_query($connection, $sql);
	
			if (!$data) {
				die("Error in SQL query: " . mysqli_error($connection));
			}
		} else {
			//Handle the case when $question is null or doesn't have 'OvResultID'
			echo "Error: Invalid data for update.";
		}
	?>
	<br>
	<table>
		 <!-- Display students' achievement in a table for the quizzes that have been answered -->
		<caption>INDIVIDUAL'S ACHIEVEMENT RESULT</caption>
		<tr>
    		<th class="result">Topic</th>
    		<th class="result">
        	<?php
        	$topicSql = "SELECT TopicName FROM topic WHERE TopicID='" . $topic . "'";
        	$topicData = mysqli_query($connection, $topicSql);
        	$topicname = mysqli_fetch_array($topicData);
        	echo $topicname['TopicName'];
        	?>
    		</th>
		</tr>
		
		<tr>
			<td class="result">Number Of Correct Answers</td>
			<td class="result"><?php echo $correct; ?></td>
		</tr>
		
		<tr>
			<td class="result">Number of Wrong Answers</td>
			<td class="result"><?php echo $wrong; ?></td>
		</tr>
		
		<tr>
			<td class="result">Total Questions</td>
			<td class="result"><?php echo $totalnum; ?></td>
		</tr>
		
		<tr>
			<td class="result">Results</td>
			<td class="result"><?php echo number_format($percentage,0)?>%</td>
		</tr>
	</table>
	<button type="button" class="back" onclick="window.location='student_quiztopicfilter.php'">Back to select a topic</button>
</div>
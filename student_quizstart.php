<?php
	include('secure.php');
	include('connection.php');
	include('nav_stu.php');

	$idtopic = isset($_GET['idtopic']) ? $_GET['idtopic'] : null;
	$resultID = isset($_GET['ovResultID']) ? $_GET['ovResultID'] : null;
	$stuid = $_SESSION['userid'];

	//Retrieve time limit from the database
	$timeLimitQuery = "SELECT AnsTimeLimit FROM topic WHERE TopicID = '$idtopic'";
	$timeLimitResult = mysqli_query($connection, $timeLimitQuery);
	$timeLimitRow = mysqli_fetch_assoc($timeLimitResult);
	$timeLimit = $timeLimitRow['AnsTimeLimit'];
?>
<script>
	//Function to start the timer
	function startTimer(duration, display) {
		var timer = duration, minutes, seconds;
		setInterval(function () {
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.textContent = minutes + ":" + seconds;

			if (--timer < 0) {
				//Submit the form or perform any action when time runs out
				document.forms["quizForm"].submit();
			}
		}, 1000);
	}

	//Function to initialize the timer
	document.addEventListener("DOMContentLoaded", function () {
		var timeLimitInSeconds = <?php echo $timeLimit * 60; ?>;
		var display = document.querySelector('.time-limit');
		startTimer(timeLimitInSeconds, display);
	});
	
	//Function for the back button
	function goBack() {
        if (confirm("All the question's answers will not be saved. Are you sure you want to go back? ")) {
            var ovResultID = '<?php echo $resultID; ?>';
            var stuID = '<?php echo $stuid; ?>'; 
            var topicID = '<?php echo $idtopic; ?>';
            
            //Construct the URL for the delete_record.php file or modify it accordingly
            var deleteURL = "student_backtodelete_quizrecord.php?ovResultID=" + ovResultID + "&stuID=" + stuID + "&topicID=" + topicID;

            //Redirect to delete_record.php to handle the deletion
            window.location.href = deleteURL;
        }
    }	
</script>

<link rel="stylesheet"  href="table2.css">
<link rel="stylesheet"  href="button.css">
<div class="content">
    <center>
        <form action="student_recordinsert_afterquiz.php" method="post" id="quizForm">
            <table>
                <caption>Quiz Questions</caption>
                <!-- Add a row to display the time limit -->
                <tr>
                    <td colspan="2" class="time-limit">Time Limit: <?php echo $timeLimit; ?> minutes</td>
                </tr>
                <tr>
                    <th>No.</th>
                    <th>Questions</th>
                </tr>

                <?php
					$sql = "SELECT * FROM question WHERE TopicID = '$idtopic' AND QuestApprovalStatus= 'Y' AND QuestDeleteStatus= 'N' ORDER BY QuestID ASC";
					$data = mysqli_query($connection, $sql);
					$num = 1;
					while ($question = mysqli_fetch_array($data)) {
				?>
						<tr>
							<td class="num"><?php echo $num; ?></td>
							<td class="question">

								<?php
								//Display question title and options based on question type
								$type = $question['QuestType'];
								if ($type == 1)
								//Display multiple-choice questions
									echo "
									$question[QuestTitle]<br>
									<input type=radio name=$question[QuestID] value=A required>A." . htmlspecialchars($question['Option1']) . "<br>
									<input type=radio name=$question[QuestID] value=B required>B." . htmlspecialchars($question['Option2']) ."<br>
									<input type=radio name=$question[QuestID] value=C required>C.". htmlspecialchars($question['Option3']) ."<br>
									<input type=radio name=$question[QuestID] value=D required>D.". htmlspecialchars($question['Option4']) ."<br>
									<input type=hidden name=idtopic value=$idtopic>
									<input type=hidden name=idresult value=$resultID>
									";
								else if ($type == 2)
								//Display true/ false questions
									echo "
									$question[QuestTitle]<br>
									<input type=radio name=$question[QuestID] value=True required>True<br>
									<input type=radio name=$question[QuestID] value=False required>False<br>
									<input type=hidden name=idtopic value=$idtopic>
									<input type=hidden name=idresult value=$resultID>
									";
								else if ($type == 3)
								//Display subjective questions
									echo "
									$question[QuestTitle]<br>
									<input type=text name=$question[QuestID] required><br>
									<input type=hidden name=idtopic value=$idtopic>
									<input type=hidden name=idresult value=$resultID>
									";
                            ?>

                        </td>
                    </tr>
                    <?php $num = $num + 1;
					} ?>
            </table>
            <div class="buttons-row">
                <button class="submit" type="submit" value="submit">Submit</button>
                <button class="back" type= "button" onclick="goBack()">Back</button>
            </div>
        </form>
    </center>
</div>

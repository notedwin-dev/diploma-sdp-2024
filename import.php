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
	
	function determineQuestionType($data) {
		//Extract question title, Option1, Option2, Option3, Option4 and question answer from the file imported
		$options = array_slice($data, 1, 4);
		$questTitle= $data[0];
		$questAnswer = $data[5];
		
		//Determine the question type based on the presence of question title, options and answer
		if (!empty($options[0]) && !empty($options[1]) && !empty($options[2]) && !empty($options[3]) && !empty($questAnswer) && !empty($questTitle)) {
			return 1; 
		} elseif (!empty($options[0]) && !empty($options[1]) && empty($options[2]) && empty($options[3]) && !empty($questAnswer) && !empty($questTitle)) {
			return 2; 
		} elseif (empty(array_filter($options)) && !empty($questAnswer) && !empty($questTitle)) {
			return 3; 
		}
	}
		
	if (isset($_POST["import"])) {
		$topicID = $_POST["topicid"];
		$filename = $_FILES["questionFile"]["tmp_name"];
		if ($_FILES["questionFile"]["size"] > 0) {
			$file = fopen($filename, "r");
			$skippedQuestionsCount = 0;
			while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
				//Determine the question type from the function
				$questionType = determineQuestionType($getData);

				//Modify input based on question type
				if ($questionType == 1) {
					//Make sure the answer is upper A/B/C/D
					$getData[5] = strtoupper($getData[5]);
				} elseif ($questionType == 2) {
					//Make sure Option1 is 'True', Option2 is 'False', and answer is 'True'/'False'
					$getData[1] = 'True';
					$getData[2] = 'False';
					$getData[3] = '';
					$getData[4] = '';
					$getData[5] = ucfirst(strtolower($getData[5]));
				}
				
				if (1 <= $questionType && $questionType <= 3) {
					$sql = "INSERT INTO question (QuestTitle, Option1, Option2, Option3, Option4, QuestAnswer, LecID, TopicID, QuestType)
							VALUES ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "',
							'" . $getData[5] . "','$LecID','$topicID','$questionType')";
					$result = mysqli_query($connection, $sql);
				} else {
					$skippedQuestionsCount++;
				}
			}
			
			if ($skippedQuestionsCount > 0) {
				echo "<script>alert('$skippedQuestionsCount question(s) were skipped due to incomplete/invalid file input format.');</script>";
			}
		}
	}
?>

<script>
	<?php
	if ($result == true) {
		echo "alert('New Question Added Successfully in List of Pending Approval');";
		//Direct user to view the list of questions of the topic
		echo "window.location.href = 'question_view.php?topicID=" . $topicID . "';"; 
	} else {
		echo "alert('Fail to add new question');";
		//Go back to the previous page on failure
		echo "window.history.back();"; 
	}
	?>
</script>
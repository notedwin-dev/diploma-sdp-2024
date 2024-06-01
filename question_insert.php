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

	$questtitle = $_POST["questtitle"];
	$lecid = $_POST["lecid"];
	$topicid = $_POST["topicid"];
	$type = $_POST["type"];
	$explanation = $_POST["answerexplanation"];
	//Set the value of options based on the question type
	if ($type == 1){
		$option1 = $_POST["option1"];
		$option2 = $_POST["option2"];
		$option3 = $_POST["option3"];
		$option4 = $_POST["option4"];
		$answer = $_POST["answerABC"];
	}elseif ($type == 2){
		//Fix the value of Option 1 = True and Option 2 = False
		$option1 = "True";
		$option2 = "False";
		//Set the null value to the rest of the options
		$option3 = null;
		$option4 = null;
		$answer = $_POST['answerTrueFalse'];
	}else{
		//Set the null value to all of the options
		$option1 = null;
		$option2 = null;
		$option3 = null;
		$option4 = null;
		$answer = $_POST['structureanswer'];
	}
	$sql = "INSERT INTO question (QuestTitle,Option1,Option2,Option3,Option4,QuestAnswer,QuesAnsExplanation,LecID,TopicID,QuestType,QuestApprovalStatus)
	VALUES('$questtitle','$option1','$option2','$option3','$option4','$answer','$explanation','$lecid','$topicid','$type','N')";
	$result = mysqli_query($connection,$sql);

	//Check if the question table for the topic id does not have any questions with QuestApprovalStatus = 'Y'
	$sql = "SELECT * FROM question WHERE TopicID = '$topicid' AND QuestApprovalStatus = 'Y'";
	$result2 = mysqli_query($connection,$sql);
?>

<script>
	<?php
	if ($result == true) {
		echo "alert('New Question Added Successfully in List of Pending Approval');";
		if (mysqli_num_rows($result2) !== 0){
			echo "window.location.href = 'question_view.php?topicID=" . $topicid . "';"; //Redirect to question_view.php on success
		} else {
			echo "window.location.href = 'question_insertform.php';"; //Redirect to question_view.php on success
		
		}
	} else {
		echo "alert('Fail to add new question');";
		echo "window.history.back();"; //Go back to the previous page on failure
	}
	?>
</script>
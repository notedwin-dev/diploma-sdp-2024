<?php
	include('secure.php');
	include('connection.php');
	$questid = isset($_GET['QuestID']) ? $_GET['QuestID'] : '';
	
	$questtitle = $_POST["questtitle"];
	$lecid = $_POST["lecid"];
	$topicid = $_POST["topicid"];
	$type = $_POST["questtype"];
	//Update the value of options based on the question type
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
	
	//Update the topic's question
	$updateSql = "UPDATE question SET QuestTitle = '$questtitle', Option1 = '$option1', Option2='$option2', Option3='$option3',
	Option4 ='$option4', QuestAnswer='$answer', LecID='$lecid', TopicID='$topicid', QuestType='$type', QuestApprovalStatus='N'
	WHERE QuestID = '$questid'";
	$result = mysqli_query($connection, $updateSql);
	
	//Show alert and redirect after processing the form
	if (mysqli_affected_rows($connection) > 0) {
		echo "<script>alert('Question Updated Successfully! Please wait for approval from the head of the module.');";
		echo "window.location.href = 'question_view.php?topicID=$topicid';</script>";
		exit();
	} else {
		echo "<script>alert('Question Update Failed'); window.history.back();</script>";
	}
?>
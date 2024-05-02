<?php
	include('secure.php');
	include('connection.php');

	if (isset($_GET['QuestID'])) {
		$questid = $_GET['QuestID'];
		$topicid = $_GET['TopicID'];

		//The question will not actually be deleted for view history/result purpose
		//The system will perform updating the delete status of question instead of delete
		$deleteSql = "UPDATE question SET QuestDeleteStatus = 'D' WHERE QuestID='$questid'";
		$deleteResult = mysqli_query($connection, $deleteSql);

		if ($deleteResult) {
			echo '<script>alert("Question deleted successfully!");';
			echo 'window.location.href = "question_view.php?topicID=' . $topicid . '";</script>';
		} else {
			echo '<script>alert("Failed to delete question: ' . mysqli_error($connection) . '");';
			echo 'window.location.href = "question_viewDetail.php?TopicID=' . $topicid . '&QuestID=' . $questid . '";</script>';
		}
	}
?>
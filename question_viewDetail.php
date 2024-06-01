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

	$topicid = $_GET['TopicID'];
	$questid = $_GET['QuestID'];

	
	//Check if the form is submitted for function
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['update_quest'])) {
			//Redirect to question_updateform.php without confirmation
			header("Location: question_updateform.php?QuestID=$questid");
			exit();
		} elseif (isset($_POST['delete_quest'])) {
			//Display delete confirmation message
			echo '<script>
					var confirmDelete = confirm("Are you sure you want to delete this question?");
					if (confirmDelete) {
						window.location.href = "question_delete.php?TopicID=' . $topicid . '&QuestID=' . $questid . '";
					} else {
						// User clicked cancel, stay on the current page
						history.back();
					}
				  </script>';
			exit();
		}
	}

	//Function to display question details based on question type
	function displayQuestionDetails($row, $topicid, $questid)
	{
		echo '<tr>
				<td>Question ID</td>
				<td>:</td>
				<td>'.htmlspecialchars($row["QuestID"]).'</td>
			</tr>
			<tr>
				<td>Question Title</td>
				<td>:</td>
				<td>'.htmlspecialchars($row["QuestTitle"]).'</td>
			</tr>';

		switch ($row['QuestType']) {
			//For question type 1, all options are displayed
			case 1:
				echo '<tr>
						<td>Option 1</td>
						<td>:</td>
						<td>'.htmlspecialchars($row["Option1"]).'</td>
					</tr>
					<tr>
						<td>Option 2</td>
						<td>:</td>
						<td>'.htmlspecialchars($row["Option2"]).'</td>
					</tr>
					<tr>
						<td>Option 3</td>
						<td>:</td>
						<td>'.htmlspecialchars($row["Option3"]).'</td>
					</tr>
					<tr>
						<td>Option 4</td>
						<td>:</td>
						<td>'.htmlspecialchars($row["Option4"]).'</td>
					</tr>';
				break;

			//For question type 2, only Option 1 and Option 2 are displayed
			case 2:
				echo '<tr>
						<td>Option 1</td>
						<td>:</td>
						<td>'.$row["Option1"].'</td>
					</tr>
					<tr>
						<td>Option 2</td>
						<td>:</td>
						<td>'.$row["Option2"].'</td>
					</tr>';
				break;

			//For question type 3, no options are displayed
			case 3:
				break;

			default:
				break;
		}

		echo '<tr>
				<td>Question Answer</td>
				<td>:</td>
				<td>'.htmlspecialchars($row["QuestAnswer"]).'</td>
			</tr>
			<tr>
				<td>Question Explanation</td>
				<td>:</td>
				<td>'.htmlspecialchars($row["QuesAnsExplanation"]).'</td>
			</tr>
			<tr>
				<td>Lecturer Name</td>
				<td>:</td>
				<td>'.$row["LecName"].'</td>
			</tr>
			<tr>
				<td>Topic</td>
				<td>:</td>
				<td>'.$row["TopicName"].'</td>
			</tr>';
	}

	//Get question details from the database
	$sql = "SELECT question.QuestID, question.QuestTitle, question.Option1, question.Option2, 
			question.Option3, question.Option4, question.QuestAnswer, lecturer.LecName, topic.TopicName, question.QuestType, question.QuesAnsExplanation
			FROM question 
			JOIN topic ON topic.TopicID = question.TopicID
			JOIN lecturer ON lecturer.LecID = question.LecID
			WHERE question.TopicID = '$topicid' AND question.QuestID = '$questid'";
	$result = mysqli_query($connection, $sql);
?>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<h3 class="header">View Question</h3>
	<form class="form" method="post">
		<table>
			<?php
			while ($row = mysqli_fetch_array($result)) {
				$questtype = $row['QuestType'];

				if ($questtype >= 1 && $questtype <= 3) {
					//Display question details using the function
					displayQuestionDetails($row, $topicid, $questid);
				}
			}
			?>
		</table>
		<div class="buttons-row">
			<button class="submit" type="submit" name="update_quest">Update</button>
			<button class="submit" type="submit" name="delete_quest">Delete</button>
			<button class="back" onclick="window.history.go(-1); return false;">Back</button>
		</div>
	</form>
</div>
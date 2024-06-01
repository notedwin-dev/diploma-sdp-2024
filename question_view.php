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
<script>
	// Check the previous page URL
	var previousPage = document.referrer;
	var lecType = <?php echo $LecType; ?>;

	// Define a function to handle back button click
	function handleBackClick() {
		if (previousPage.includes('question_view_selecttopic.php')) {
			window.location.href = 'question_view_selecttopic.php';
		} else if (previousPage.includes('topic_view.php')){
			window.location.href = 'topic_view.php';
		} else{
			if (lecType == 1) {
				window.location.href = 'home_hom.php';
			} else if (lecType == 2) {
				window.location.href = 'home_lecturer.php';
			}
		}
	}
</script>
<?php
	$topicid = $_GET['topicID'];

	//To get the approved and not deleted Question ID and Question Title based on the topic selected
	$sql = "SELECT question.QuestID, question.QuestTitle FROM question 
			JOIN topic ON topic.TopicID = question.TopicID
			WHERE question.TopicID = '$topicid' AND question.QuestDeleteStatus = 'N' AND question.QuestApprovalStatus = 'Y'";
	$result = mysqli_query($connection, $sql);

	if ($result && mysqli_num_rows($result) > 0) {
		$num = 1;
?>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class="content">
	<table>
		<caption>LIST OF QUESTIONS</caption>
		<tr>
			<th>No.</th>
			<th>QUESTION</th>
			<th>DETAILS</th>
		</tr>
		<?php
		while ($row = mysqli_fetch_array($result)) {
			$questid = $row['QuestID'];
			echo
				'<tr>
					<td>' . $num . '</td>
					<td>' . $row["QuestTitle"] . '</td>
					<td>
						<form action="question_viewDetail.php" method="get">
							<input type="hidden" name="TopicID" value="' . $topicid . '">
							<input type="hidden" name="QuestID" value="' . $questid . '">
							<button type="submit">Details</button>
						</form>
					</td>
				</tr>';
			$num = $num + 1;
		}
		?>
	</table>
	<div class="buttons-row">
		<button class="print" onclick="window.print()">Print</button>
		<button class="back" onclick="handleBackClick()">Back</button>
	</div>
	<br>
	<center>
	<br>
	<br>
	<p style="background-color: #ffffff; display: inline; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px;">Did not see your newly added questions here? This is due to the questions are pending for approval. Please check back later or contact the admin to get your questions approved.</p>
	<br>
	<br>
	<p style="background-color: #ffffff; display: inline; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px;">If students can't see your quiz, it is probably due to your questions are still pending for approval.</p>
	</center>
</div>

<?php
	} else {
		echo '<script>alert("No questions available for this topic."); handleBackClick();</script>';
		exit();
	}
?>
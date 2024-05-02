<?php
	include('secure.php');
	include('connection.php');	
	include('nav_stu.php');
?>
<script>
	//Function to validate the form before submission
	function validateForm() {
		var topicSelect = document.getElementById("idtopic");
		var selectedValue = topicSelect.value;

		if (selectedValue === "") {
			alert("Please select a topic before starting.");
			return false; //Prevent form submission
		}

		//Allow form submission if a topic is selected
		return true;
	}
</script>
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<center>
	<!-- Form to select a topic for the quiz -->
	<h3 class="header">PLEASE SELECT A TOPIC</h3>
	<form class="form" action="stuoverallresult_insert.php" method="get" onsubmit="return validateForm()">
		<table>
			<tr>
				<td>Topic</td>
				<td>
					<!-- Dropdown to select a topic -->
					<select class="topic" name="idtopic" id="idtopic">
					<option value="" disabled selected>Select topic</option>
					<?php
						// Fetch distinct topics with approval status for questions, question and topic's delete status is = 'N'
						$sql = "SELECT DISTINCT topic.TopicID, topic.TopicName FROM topic JOIN question ON topic.TopicID = question.TopicID WHERE TopicDeleteStatus = 'N' AND question.QuestApprovalStatus ='Y' AND question.QuestDeleteStatus ='N'";
						$data = mysqli_query($connection,$sql);
						
						//Display each topic as an option in the dropdown
						while($topic = mysqli_fetch_array($data)){
							echo "<option value='$topic[TopicID]'>$topic[TopicName]</option>";
						}
					?>
					</select>
				</td>
			</tr>
		</table>
		<button type="submit" class="submit">Start</button>
	</form>
	</center>
</div>
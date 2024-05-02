<?php
	include('secure.php');
	include('connection.php');
	include('nav_hom.php');
?>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class="content">
	<table>
	<caption>LIST OF PENDING APPROVAL QUESTIONS</caption>
		<tr>
			<th>No.</th>
			<th>QUESTION</th>
			<th>TOPIC</th>
			<th>DETAILS</th>
		</tr>
		
	<?php
        //Get the approved Question ID and Question Title based on the topic selected
		$sql="SELECT question.QuestID, question.QuestTitle, topic.TopicName FROM question 
        JOIN topic ON topic.TopicID = question.TopicID
        WHERE question.QuestApprovalStatus = 'N' AND question.QuestDeleteStatus = 'N'";
		$result = mysqli_query($connection,$sql);
		if ($result && mysqli_num_rows($result) > 0) {
			$num = 1;
			while($row = mysqli_fetch_array($result)){
				$questid = $row['QuestID'];
				echo 
					'<tr>
						<td>'.$num.'</td>
						<td>'.$row["QuestTitle"].'</td>
						<td>'.$row["TopicName"].'</td>
						<td>
							<form action = "question_approval.php" method="get">
								<input type="hidden" name="QuestID" value="'. $questid .'">
								<button type="submit">Details</button>
							</form>
						</td>
					</tr>';
				$num = $num +1;
			}
		}else{
			echo '<script>alert("No questions pending for approval."); window.location.href="home_hom.php";</script>';
			exit(); 
		}
	?>
	</table>
	<div class="buttons-row">
		<button class="print" onclick = "window.print()">Print</button>
		<button class="back" onclick="window.location.href='home_hom.php'">Back</button>
	</div>
</div>
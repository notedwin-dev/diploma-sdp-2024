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
	//JavaScript function to validate the form before submission
	function validateForm() {
		var topicSelect = document.getElementById("idtopic");
		var selectedValue = topicSelect.value;

		//Check if a topic is selected
		if (selectedValue === "") {
			alert("Please select a topic before starting.");
			return false; //Prevent form submission
		}

		//Allow form submission if a topic is selected
		return true;
	}
</script>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="form2.css">
<div class="content">
	<center>
	<h3 class="header">PLEASE SELECT A TOPIC</h3>
	<form class="form" action="question_view.php" method="get" onsubmit="return validateForm()">
		<table>
			<tr>
				<td>Topic</td>
				<td>
					<!-- Dropdown list for selecting a topic -->
					<select class="topic" name="topicID" id="idtopic">
					<option value="" disabled selected>Select topic</option>
					<?php
						//Retrieve and display topics from the database where the delete status is 'N'
						$sql="SELECT * FROM topic WHERE TopicDeleteStatus = 'N'";
						$data = mysqli_query($connection,$sql);
						while($topic = mysqli_fetch_array($data)){
							echo "<option value='$topic[TopicID]'>$topic[TopicName]</option>";
						}
					?>
					</select>
				</td>
			</tr>
		</table>
		<button type="submit" class="submit">View</button>
	</form>
	</center>
</div>
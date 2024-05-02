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
<!-- JavaScript to validate the form before submission -->
<script>
	function validateForm() {
		//Get the selected value from the topic dropdown
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
	<form class="form" action="resource_view.php" method="get" onsubmit="return validateForm()">
		<table>
			<tr>
				<td>Topic</td>
				<td>
					<!-- Dropdown to select a topic -->
					<select class="topic" name="topicID" id="idtopic">
					<option value="" disabled selected>Select topic</option>
					<?php
						//Query to retrieve topics that are not marked for deletion
						$sql="SELECT * FROM topic WHERE TopicDeleteStatus = 'N'";
						$data = mysqli_query($connection,$sql);
						//Display options for each topic
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
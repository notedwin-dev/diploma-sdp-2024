<?php
include('secure.php');
include('connection.php');	
include('nav_stu.php');
?>

<!-- JavaScript to validate the form before submission -->
<script>
    function validateForm() {
        //Get the selected value from the topic dropdown
        var topicSelect = document.getElementById("idtopic");
        var selectedValue = topicSelect.value;

        //Check if a topic is selected
        if (selectedValue === "") {
            alert("Please select a topic.");
            return false; // Prevent form submission
        }

        //Allow form submission if a topic is selected
        return true;
    }
</script>

<!-- Include CSS stylesheets -->
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">

<!-- Display the form(filter) to select a topic -->
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<center>
	<h3 class="header">PLEASE SELECT A TOPIC</h3>
	<form class="form" action="student_resourceview.php" method="get" onsubmit="return validateForm()">
		<table>
			<tr>
				<td>Topic</td>
				<td>
					<!-- Dropdown to select a topic -->
					<select class="topic" name="idtopic" id="idtopic">
					<option value="" disabled selected>Select topic</option>
					<?php
						//Query to retrieve distinct topics that are not marked for deletion and the topic is included in the resource table
						$sql = "SELECT DISTINCT topic.TopicID, topic.TopicName FROM topic JOIN resources ON topic.TopicID = resources.TopicID WHERE topic.TopicDeleteStatus = 'N'";
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
		<button type="submit" class="submit">Show</button>
	</form>
	</center>
</div>
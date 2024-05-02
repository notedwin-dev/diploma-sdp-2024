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
<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">

<script>
	function goBack() {
		var lecType = <?php echo $LecType; ?>;

		if (lecType == 1) {
			window.location.href = 'home_hom.php';
		} else if (lecType == 2) {
			window.location.href = 'home_lecturer.php';
		}
	}

	function validateForm() {
		var topicSelect = document.getElementById("idtopic");
		var selectedValue = topicSelect.value;

		if (selectedValue === "") {
			alert("Please select a topic before starting.");
			return false; // Prevent form submission
		}

		// Allow form submission if a topic is selected
		return true;
	}

	function downloadSampleTemplate() {
		var downloadLink = document.getElementById('downloadLink');
		downloadLink.click();
	}
</script>

<div class="content">
	<h3 class='header'>IMPORT QUESTIONS</h3>
	<form action="import.php" method="post" name="upload_excel" enctype="multipart/form-data" class="form" onsubmit="return validateForm()">
		<table>
			<tr>
				<td>Topic</td>
				<td>
					<select class="topic" name="topicid" id="idtopic">
					<option value="" disabled selected>Select topic</option>
					<?php
						$sql="SELECT * FROM topic WHERE TopicDeleteStatus = 'N'";
						$data = mysqli_query($connection,$sql);
						while($topic = mysqli_fetch_array($data)){
							echo "<option value='$topic[TopicID]'>$topic[TopicName]</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>File Name</td>
				<td><input type = "file" name = "questionFile" id="file" accept=".csv" required></td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight: normal;">Please ensure that your CSV file follows the correct format for inserting questions.
					<br>Each row should represent a question, and the columns must be organized as follows:
				</td>
			</tr>
			<tr class="example">
				<th>Type</th>
				<th>Columns</th>
			</tr>
			<tr class="example">
				<td>Type 1: Objective Question</td>
				<td>Question Title, Option A Text, Option B Text, Option C Text, Option D Text, Correct Answer (A, B, C, or D)</td>
			</tr>
			<tr class="example">
				<td>Type 2: True | False</td>
				<td>Question Title, True, False, [Leave Options Empty], Correct Answer (True or False)</td>
			</tr>
			<tr class="example">
				<td>Type 3: Fill In The Blank</td>
				<td>Question Title, [Leave Options Empty], [Leave Options Empty], [Leave Options Empty], [Leave Options Empty], Answer</td>
			</tr>
			<tr>
				<td colspan="2">
					<a id="downloadLink" href="Book1.csv" download="SampleFile" onclick="downloadSampleTemplate()">Download our sample template for reference.</a>
				</td>
			</tr>
		</table>
		<div class="buttons-row">
			<button class="submit" name="import" type="submit">Import</button>
			<button class="back" onclick="goBack();">Back</button>
		</div>
	</form>
</div>
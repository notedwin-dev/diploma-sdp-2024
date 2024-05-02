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
function updateOptions() {
    var questionType = document.getElementsByClassName("questionType")[0].value;
    var optionsABCDiv = document.getElementsByClassName("optionsABC");
    var answerABC = document.getElementsByClassName("answerABC")[0];
    var answerTrueFalseDiv = document.getElementsByClassName("answerTrueFalse")[0];
    var answerRow = document.getElementsByClassName("answerRow")[0];

    //Hide all options and answer by default
    hideOptions(optionsABCDiv);
    hideOptions([answerTrueFalseDiv, answerRow]);
    hideAnswer(answerABC);

    //Show options and answer based on the selected question type
    if (questionType == 1) {
        showOptions(optionsABCDiv);
        showAnswer(answerABC);
        setRequired(["questtitle", "option1", "option2", "option3", "option4", "answerABC"]);
    } else if (questionType == 2) {
        showOptions([answerTrueFalseDiv]);
        setRequired(["questtitle", "answerTrueFalse"]);
    } else if (questionType == 3) {
        showAnswer(answerRow);
        setRequired(["questtitle", "structureanswer"]);
    }
}

function setRequired(fields) {
    for (var i = 0; i < fields.length; i++) {
        document.getElementsByName(fields[i])[0].required = true;
    }
}

function hideOptions(options) {
    for (var i = 0; i < options.length; i++) {
        options[i].style.display = "none"; 
    }
}

function showOptions(options) {
    for (var i = 0; i < options.length; i++) {
        options[i].style.display = "table-row"; //Change display to table-row
    }
}

function hideAnswer(answer) {
    answer.style.display = "none";
}

function showAnswer(answer) {
    answer.style.display = "table-row"; //Change display to table-row
}

function goBack() {
    var lecType = <?php echo $LecType; ?>;

    if (lecType == 1) {
        window.location.href = 'home_hom.php';
    } else if (lecType == 2) {
        window.location.href = 'home_lecturer.php';
    }
}
</script>

<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<h3 class="header">ADD NEW QUESTIONS</h3>
	<form class="form" action="question_insert.php" method="post">
		<table>
			<input type="hidden" name="lecid" value="<?php echo $LecID; ?>">
			<tr>
				<td>Question</td>
				<td><input type="text" name="questtitle" required></td>
			</tr>
			
			<tr>
                <td>Type of Questions</td>
                <td>
                    <select name="type" class="questionType" onchange="updateOptions()" required>
						<option value="" disabled selected>Please Select</option>
                        <option value="1">Objective Question</option>
                        <option value="2">True | False</option>
                        <option value="3">Fill In The Blank</option>
                    </select>
                </td>
            </tr>

            <tr class="optionsABC" style="display: none;">
                <td>Option A</td>
                <td><input type="text" name="option1"></td>
            </tr>
			
            <tr class="optionsABC" style="display: none;">
                <td>Option B</td>
                <td><input type="text" name="option2"></td>
            </tr>
			
            <tr class="optionsABC" style="display: none;">
                <td>Option C</td>
                <td><input type="text" name="option3"></td>
            </tr>
			
			<tr class="optionsABC" style="display: none;">
                <td>Option D</td>
                <td><input type="text" name="option4"></td>
            </tr>
			
			<tr class="answerABC" style="display: none;">
				<td>Answer</td>
				<td>
					<select name="answerABC">
						<option value="" disabled selected>Please Select</option>
						<option value = "A">A</option>
						<option value = "B">B</option>
						<option value = "C">C</option>
						<option value = "D">D</option>
					</select>
				</td>
			</tr>
			
            <tr class="answerTrueFalse" style="display: none;">
                <td>Answer</td>
                <td>
					<input type="radio" name="answerTrueFalse" value = "True"><label for="True">True</label>
					<input type="radio" name="answerTrueFalse" value = "False"><label for="False">False</label>
				</td>
            </tr>
			
			<tr class="answerRow" style="display: none;">
				<td>Answer</td>
				<td><textarea type="text" name="structureanswer"></textarea></td>
			</tr>
			
			<tr>
				<td>Topic</td>
				<td>
					<select name="topicid">
						<option value="" disabled selected>Please Select</option>
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
		</table>
		<div class="buttons-row">
			<button class="submit" type="submit">Insert</button>
			<input type="button" class="custom-button" onclick="goBack();" value="Back">
		</div>
	</form>
</div>
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
	$questid = isset($_GET['QuestID']) ? $_GET['QuestID'] : '';

	//Get the current question details from the database
	$sql = "SELECT QuestTitle, QuestType, Option1, Option2, Option3, Option4, QuestAnswer, LecID, TopicID FROM question WHERE QuestID = '$questid'";
	$result = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($result);

	function getQuestionTypeLabel($type) {
		switch ($type) {
			case 1:
				return "Objective Question";
			case 2:
				return "True | False";
			case 3:
				return "Fill In The Blank";
			break;
		}
	}
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Call updateOptions on page load to initialize the form based on the retrieved question type
        updateOptions();
    });

    function updateOptions() {
        var questionTypeInput = document.getElementById("questionType");
        var optionsABCDiv = document.getElementsByClassName("optionsABC");
        var answerABC = document.getElementsByClassName("answerABC")[0];
        var answerTrueFalseDiv = document.getElementsByClassName("answerTrueFalse")[0];
        var answerRow = document.getElementsByClassName("answerRow")[0];

        //Hide all options and answer by default
        hideOptions(optionsABCDiv);
        hideOptions([answerTrueFalseDiv, answerRow]);
        hideAnswer(answerABC);

        //Show options and answer based on the retrieved question type
        if (questionTypeInput.value == "Objective Question") {
            showOptions(optionsABCDiv);
            showAnswer(answerABC);
        } else if (questionTypeInput.value == "True | False") {
            showOptions([answerTrueFalseDiv]);
        } else if (questionTypeInput.value == "Fill In The Blank") {
            showAnswer(answerRow);
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
</script>

<link rel="stylesheet" href="form2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
    <h3 class="header">UPDATE QUESTIONS</h3>
    <form class="form" action="question_update.php?QuestID=<?php echo $questid; ?>" method="post">
        <table>
            <input type="hidden" name="lecid" value="<?php echo $LecID; ?>">
            <tr>
                <td>Question</td>
                <td><input type="text" name="questtitle" value="<?php echo $row['QuestTitle']; ?>"></td>
            </tr>

            <tr>
                <td>Type of Questions</td>
                <td>
                    <input type="text" id="questionType" name="type" value="<?php echo getQuestionTypeLabel($row['QuestType']); ?>" readonly>
					<input type="hidden" name="questtype" value="<?php echo $row['QuestType']; ?>">
                </td>
            </tr>

            <tr class="optionsABC" style="display: none;">
                <td>Option A</td>
                <td><input type="text" name="option1" value="<?php echo $row['Option1']; ?>"></td>
            </tr>

            <tr class="optionsABC" style="display: none;">
                <td>Option B</td>
                <td><input type="text" name="option2" value="<?php echo $row['Option2']; ?>"></td>
            </tr>
			
			<tr class="optionsABC" style="display: none;">
                <td>Option C</td>
                <td><input type="text" name="option3" value="<?php echo $row['Option3']; ?>"></td>
            </tr>
			
			<tr class="optionsABC" style="display: none;">
                <td>Option D</td>
                <td><input type="text" name="option4" value="<?php echo $row['Option4']; ?>"></td>
            </tr>

            <tr class="answerABC" style="display: none;">
                <td>Answer</td>
                <td>
                    <select name="answerABC">
                        <option value="" disabled selected>Please Select</option>
                        <option value="A" <?php if ($row['QuestAnswer'] == 'A') echo 'selected'; ?>>A</option>
                        <option value="B" <?php if ($row['QuestAnswer'] == 'B') echo 'selected'; ?>>B</option>
						<option value="C" <?php if ($row['QuestAnswer'] == 'C') echo 'selected'; ?>>C</option>
						<option value="D" <?php if ($row['QuestAnswer'] == 'D') echo 'selected'; ?>>D</option>
                    </select>
                </td>
            </tr>

            <tr class="answerTrueFalse" style="display: none;">
                <td>Answer</td>
                <td>
                    <input type="radio" name="answerTrueFalse" value="True" <?php if ($row['QuestAnswer'] == 'True') echo 'checked'; ?>><label for="True">True</label>
                    <input type="radio" name="answerTrueFalse" value="False" <?php if ($row['QuestAnswer'] == 'False') echo 'checked'; ?>><label for="False">False</label>
                </td>
            </tr>

            <tr class="answerRow" style="display: none;">
                <td>Answer</td>
                <td><textarea name="structureanswer"><?php echo $row['QuestAnswer']; ?></textarea></td>
            </tr>

            <tr>
                <td>Topic</td>
                <td>
                    <select name="topicid">
                        <option value="" disabled selected>Please Select</option>
                        <?php
                        $sql = "SELECT * FROM topic WHERE TopicDeleteStatus = 'N'";
                        $data = mysqli_query($connection, $sql);
                        while ($topic = mysqli_fetch_array($data)) {
                            $selected = ($topic['TopicID'] == $row['TopicID']) ? 'selected' : '';
                            echo "<option value='$topic[TopicID]' $selected>$topic[TopicName]</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <div class="buttons-row">
            <button class="submit" type="submit">Update</button>
            <button class="back" onclick="window.history.go(-1); return false;">Back</button>
        </div>
    </form>
</div>

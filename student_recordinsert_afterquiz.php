<?php
    include('connection.php');
    include('secure.php');

	$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
	$topicID = $_POST['idtopic'];
	$resultID = $_POST['idresult'];

    //Check if 'userid' key and 'id result ' is set in the $_SESSION superglobal (session variables)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//Validate and set the timezone
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $answerDateTime = date('Y-m-d H:i:s'); //Get the current date and time in the required format
        
    
        //Update answer date time in overall_result table
        $updateSql = "UPDATE overall_result SET AnsDateTime = '$answerDateTime' WHERE StuID = '$userId' AND OvResultID ='$resultID'";
        $updateResult = mysqli_query($connection, $updateSql);
    
        //Check for errors
        if (!$updateResult) {
            die("Error updating AnsDateTime: " . mysqli_error($connection));
        }
    }

	//Prepare a single SQL statement for both answered and unanswered questions
	$sql = "INSERT INTO record (OvResultID, QuestID, StuAnswer) VALUES (?, ?, ?)";
	$stmt = mysqli_prepare($connection, $sql);

	//Check for errors in preparing the statement
	if (!$stmt) {
		die("Error: " . mysqli_error($connection));
	}

	//Loop through all question IDs for the given topic
	$allQuestionIDs = array_column(mysqli_fetch_all(mysqli_query($connection, "SELECT QuestID FROM question WHERE TopicID = '$topicID' AND QuestApprovalStatus= 'Y' AND QuestDeleteStatus= 'N'")), 0);

	//Loop through the submitted form data
	foreach ($allQuestionIDs as $questionID) {
		// Check if the question was answered
		$stuAnswer = isset($_POST[$questionID]) ? $_POST[$questionID] : null;

		//Bind parameters and execute the statement
		mysqli_stmt_bind_param($stmt, 'iss', $resultID, $questionID, $stuAnswer);
		mysqli_stmt_execute($stmt);
	}

	//Close the statement
	mysqli_stmt_close($stmt);

	//Close the database connection
	mysqli_close($connection);

    header("Location: stu_currentResult_view.php?topicID=$topicID&resultID=$resultID");
?>
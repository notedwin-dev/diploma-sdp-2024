<?php
    include('secure.php');
    include('connection.php');	
	include('nav_hom.php');
    $questid = $_GET['QuestID'];
?>

<script>
function questionReject() {
    var confirmReject = confirm("Are you sure you want to reject this question?");
    if (confirmReject) {
        //If user confirmed, proceed with deletion
        window.location.href = 'question_reject.php?QuestID=<?php echo $questid; ?>';
    }
}

function questionApprove() {
    var confirmApprove = confirm("Are you sure you want to approve this question?");
    if (confirmApprove) {
        //If user confirmed, proceed with approval
        window.location.href = 'question_approve.php?QuestID=<?php echo $questid; ?>';
    }
}
</script>

<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class="content">
    <table>
        <caption>VIEW QUESTION</caption>
        <?php
            //Function to display question details based on question type
            function displayQuestionDetails($row,$questid) {
                echo '<tr>
                        <td>Question ID</td>
                        <td>'.$row["QuestID"].'</td>
                    </tr>
                    <tr>
                        <td>Question Title</td>
                        <td>'.$row["QuestTitle"].'</td>
                    </tr>';

                switch ($row['QuestType']) {
					//For question type 1, all options are displayed
                    case 1:
                        echo '<tr>
                                <td>Question Option 1</td>
                                <td>'.$row["Option1"].'</td>
                            </tr>
                            <tr>
                                <td>Question Option 2</td>
                                <td>'.$row["Option2"].'</td>
                            </tr>
                            <tr>
                                <td>Question Option 3</td>
                                <td>'.$row["Option3"].'</td>
                            </tr>
                            <tr>
                                <td>Question Option 4</td>
                                <td>'.$row["Option4"].'</td>
                            </tr>';
                        break;

					//For question type 2, only Option1 & Option2 are displayed
                    case 2:
                        echo '<tr>
                                <td>Question Option 1</td>
                                <td>'.$row["Option1"].'</td>
                            </tr>
                            <tr>
                                <td>Question Option 2</td>
                                <td>'.$row["Option2"].'</td>
                            </tr>';
                        break;

                    //For question type 3, no options are displayed
                    case 3:
                        break;

                    default:
                        break;
                }

                echo '<tr>
                        <td>Question Answer</td>
                        <td>'.$row["QuestAnswer"].'</td>
                    </tr>
                    <tr>
                        <td>Question Explanation</td>
                        <td>'.$row["QuesAnsExplanation"].'</td>
                    </tr>
                    <tr>
                        <td>Lecturer Name</td>
                        <td>'.$row["LecName"].'</td>
                    </tr>
                    <tr>
                        <td>Topic</td>
                        <td>'.$row["TopicName"].'</td>
                    </tr>';
            }

            //Get the question details
            $sql="SELECT question.QuestID, question.QuestTitle, question.Option1, question.Option2, 
            question.Option3, question.Option4, question.QuestAnswer, lecturer.LecName, topic.TopicName, question.QuestType, question.QuesAnsExplanation
            FROM question 
            JOIN topic ON topic.TopicID = question.TopicID
            JOIN lecturer ON lecturer.LecID = question.LecID
            WHERE question.QuestID = '".$questid."'";
            $result = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_array($result)){
                $questtype = $row['QuestType'];

                if ($questtype >= 1 && $questtype <= 3) {
                    //Display question details using the function
                    displayQuestionDetails($row,$questid);
                }
            }
        ?>
    </table>
	<div class="buttons-row">
		<button class="approve" onclick="questionApprove()">Approve</button>
		<button class="reject" onclick="questionReject()">Reject</button>
		<button class="back" onclick = "window.history.go(-1); return false;">Back</button>
	</div>
</div>

<?php
	include('connection.php');

    $questid = isset($_GET['QuestID']) ? $_GET['QuestID'] : '';
	
	//Update the question approval status to approved by setting QuestApprovalStatus to 'Y'
	$updateSql = "UPDATE question SET QuestApprovalStatus = 'Y' WHERE QuestID = '$questid'";
	$updateResult = mysqli_query($connection,$updateSql);
		
	if ($updateResult) {
        echo '<script>alert("Question approved successfully!");</script>';
		if ($_SESSION['status'] == 'hom') {
			echo '<script>window.location.href = "home_hom.php"</script>';
		} elseif ($_SESSION['status'] == 'lecturer') {
			echo '<script>window.location.href = "home_lecturer.php"</script>';
		}
    } else {
        echo '<script>alert("Failed to approve Question:")</script>'.mysqli_error($connection);
    }
	
	echo '<script>window.location.href = "questionpending_view.php"</script>';
?>
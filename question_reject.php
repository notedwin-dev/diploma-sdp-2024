<?php
    include('connection.php');

    $questid = isset($_GET['QuestID']) ? $_GET['QuestID'] : '';

    //Delete the question that gets rejected
    $deleteSql = "DELETE FROM question WHERE QuestID='$questid'";
    $deleteResult = mysqli_query($connection, $deleteSql);

    if ($deleteResult) {
        echo '<script>alert("Question rejected successfully!")</script>';
    } else {
        echo '<script>alert("Failed to reject Question:")</script>' . mysqli_error($connection);
    }
	echo '<script>window.location.href = "questionpending_view.php"</script>';
?>
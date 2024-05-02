<head>
	<?php
        // Retrieve the username from the session
		$username = $_SESSION['username'];
		include('footer.php');
	?>
    <title>Network Insight <?php echo $username; ?></title>
</head>
<body>
    <link rel="stylesheet" href="navbar.css">
    <div class="menu">
        <div class="header">
            <a href="home_student.php" class="header">Network Insight<br><?php echo $username; ?></a>
        </div>
        <ul>
            <li><a href="student_quiztopicfilter.php">Quiz</a></li>
            <li><a href="student_resultfilter.php">History</a></li>
            <li><a href="resource_stuview_selecttopic.php">Notes</a></li>
            <li><a href="studentprofile_view.php">Profile</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>
</body>
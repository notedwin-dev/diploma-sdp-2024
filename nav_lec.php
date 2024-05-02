<head>
    <?php
	 	// Retrieve the username from the session
		$username=$_SESSION['username'];
		include('footer.php');
	?>
    <title>Network Insight <?php echo $username;?></title>
</head>
<body>
	<link rel="stylesheet" href="navbar.css">
    <div class="menu">
        <div class="header">
			<a href="home_lecturer.php" class="header">Network Insight<br><?php echo $username ;?></a>
		</div>
		<ul>
			<li><a class="arrow"href="#">Topic</a>
				<ul>
					<li><a href="topic_insertform.php">Insert</a></li>
					<li><a href="topic_view.php">Manage</a></li>
				</ul>
			</li>
			<li><a class="arrow"href="#">Question</a>
				<ul>
					<li><a href="question_insertform.php">Insert</a></li>
					<li><a href="question_view_selecttopic.php">Manage</a></li>
				</ul>
			</li>
			<li><a class="arrow"href="#">Resources</a>
				<ul>
					<li><a href="resource_insertform.php">Insert</a></li>
					<li><a href="resource_lecview_selecttopic.php">Manage</a></li>
				</ul>
			</li>

			<li><a href="student_view.php">Student</a></li>
			<li><a href="lecturer_resultfilter.php">Results</a></li>
			<li><a href="import_form.php">Import</a></li>
			<li><a href="lecturerprofile_view.php">Profile</a></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	</div>
</body>
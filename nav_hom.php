<head>
    <?php
		// Retrieve the username from the session
		$username=$_SESSION['username'];
		include('footer.php');
	?>
    <title>APHub | Home Dashboard</title>
</head>
<body>
	<link rel="stylesheet" href="navbar.css">
		<div class="menu">
			<div class="header">
			<a href="home_hom.php" class="header">APHUB<br><?php echo $username ;?></a>
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
					<li><a href="questionpending_view.php">Approval</a></li>
				</ul>
			</li>
			<li><a class="arrow"href="#">Resources</a>
				<ul>
					<li><a href="resource_insertform.php">Insert</a></li>
					<li><a href="resource_lecview_selecttopic.php">Manage</a></li>
				</ul>
			</li>

			<li><a class="arrow"href="#">Lecturer</a>
				<ul>
					<li><a href="lecturer_insertform.php">Insert</a></li>
					<li><a href="lecturer_view.php">Manage</a></li>
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
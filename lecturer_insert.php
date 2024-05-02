<?php
	include('secure.php');
	include('connection.php');

	$LecID = $_POST["LecID"];
	$LecName = $_POST["LecName"];
	$LecPw = $_POST["LecPw"];
	$LecEmail = $_POST["LecEmail"];
	$LecDob = $_POST["LecDob"];
	$LecGender = $_POST["LecGender"];
	$LecEduQua = $_POST["LecEduQua"];
	$sql = "INSERT INTO lecturer values('$LecID','$LecName','$LecPw','$LecEmail','$LecDob','$LecGender','$LecEduQua','2')";
	$result = mysqli_query($connection,$sql);

	if ($result) {
		echo "<script>alert('New Lecturer Added Successfully');</script>";
		//Direct user to view the list of lecturers on success
		echo "<script>window.location.href = 'lecturer_view.php';</script>"; 
	} else {
		echo "<script>alert('Fail to add new lecturer.');</script>";
		//Go back to the previous page on failure
		echo "<script>window.history.back();</script>"; 
	}
?>
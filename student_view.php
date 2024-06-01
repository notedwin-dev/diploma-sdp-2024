<?php
	include('secure.php');
	include('connection.php');
	if($_SESSION['status'] == 'student'){
		include('nav_stu.php');
	}
	else if($_SESSION['status'] == 'lecturer'){
		include('nav_lec.php');
	}
	else if($_SESSION['status'] == 'hom'){
		include('nav_hom.php');
	}
?>
<link rel="stylesheet" href="table2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<!-- Display a table that list all the students -->
	<table>
		<caption>LIST OF ENROLLED STUDENTS</caption>
		<tr>
			<th>Student ID</th>
			<th>Student Name</th>
			<th>Student Email</th>
			<th>Student Date of Birth</th>
			<th>Student Gender</th>
			<th>Student University</th>
		</tr>
		<?php
			//Initialize additional conditions based on the report type
			$additional_conditions = "";
			//Initialize the idtopic, startdate, and enddate
			$idtopic = '';
			$startdate = '';
			$enddate = '';

			//Make the SQL query to include additional conditions
			$sql = "SELECT * FROM student";

			$idstudent = $_SESSION['userid'];        
			
			//Execute the SQL query
			$data = mysqli_query($connection, $sql);
			
			//Display the student details in the table
			while($student = mysqli_fetch_array($data)){

        ?>

		<tr>
			<td><?php echo $student['StuID']; ?></td>
			<td><?php echo $student['StuName']; ?></td>
			<td><?php echo $student['StuEmail']; ?></td>
			<td><?php echo $student['StuDob']; ?></td>
			<td><?php echo $student['StuGender']; ?></td>
			<td><?php echo $student['StuUni']; ?></td>
        </tr>

		<?php
			}
		?>
	</table>
	<div class="buttons-row">
        <button class="print" onclick="window.print()">Print</button>
        <button class="back" onclick="window.history.back();">Back</button>
    </div>
</div>


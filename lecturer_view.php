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
?>
<script>
function confirmDelete() {
	return confirm("Are you sure you want to delete this lecturer?");
}
</script>
<link rel="stylesheet" href="button.css">
<link rel="stylesheet" href="table2.css">
<div class="content">
	<table>
		<caption>LIST OF LECTURER</caption>
		<tr>
			<th>No.</th>
			<th>LECTURER ID</th>
			<th>NAME</th>
			<th>DETAILS</th>
			<th>DELETE</th>
		</tr>
			
		<?php
			//Check if the form is submitted for delete function
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_lecturer'])) {
				$lecid = $_POST['delete_lecturer'];

				//Delete the lecturer
				$sql = "DELETE FROM lecturer WHERE LecID = '$lecid'";
				$result = mysqli_query($connection, $sql);
				
				if ($result) {
					echo '<script>alert("Lecturer deleted successfully!")</script>';
				} else {
					echo '<script>alert("Failed to delete lecturer")</script>'.mysqli_error($connection);
				}
			}

			
			//To get the Lecturer ID and Lecturer Name which the lecturer type is not Head of Module
			$sql = "SELECT LecID, LecName FROM lecturer WHERE LecType != 1";
			$result = mysqli_query($connection,$sql);
			$num = 1;
			while($row = mysqli_fetch_array($result)){
				$lecid = $row["LecID"];
				echo 
					'<tr>
						<td>'.$num.'</td>
						<td>'.$row["LecID"].'</td>
						<td>'.$row["LecName"].'</td>
						<td>
							<form action="lecturerprofile_homview.php" method="post">
								<input type="hidden" name="lecid" value="'.$lecid.'">
								<button type="submit">Details</button>
							</form>
						</td>
						<td>
							<form action="lecturer_view.php" method="post" onsubmit="return confirmDelete()">
								<input type="hidden" name="delete_lecturer" value="'.$lecid.'">
								<button type="submit">Delete</button>
							</form>
						</td>
					</tr>';
				$num = $num + 1;
			}
		?>
	</table>
	<div class="buttons-row">
		<button class="print" onclick="window.print()">Print</button>
		<button class="back" onclick="window.location.href='home_hom.php'">Back</button>
	</div>
</div>
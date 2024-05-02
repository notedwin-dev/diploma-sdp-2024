<?php
	include('secure.php');
	include('connection.php');
	include('nav_stu.php');
?>
<link rel="stylesheet" href="table2.css">
<link rel="stylesheet" href="button.css">
<div class="content">
	<!-- Display table of notes -->
	<table>
		<caption>NOTES</caption>
		<tr>
			<th>No</th>
			<th>Resouce Name</th>
            <th>Download</th>
		</tr>

		<?php
			//Check if a topic is selected
			if (isset($_GET['idtopic'])) {
				$selectedTopicID = $_GET['idtopic'];

				//Prepare SQL query to fetch resources based on the selected topic
				$sql = "SELECT ResID, ResName FROM resources WHERE TopicID=?";

				//Prepare the SQL statement
				$stmt = mysqli_prepare($connection, $sql);

				//Bind the parameter
				mysqli_stmt_bind_param($stmt, "s", $selectedTopicID);

				//Execute the statement
				mysqli_stmt_execute($stmt);

				//Get the result set
				$result = mysqli_stmt_get_result($stmt);
			
				$num = 1;
				
				//Loop through the resources and display them in the table
				while($row = mysqli_fetch_array($result)){
					echo 
						'<tr>
							<td class="num">'.$num.'</td>
							<td>'.$row["ResName"].'</td>
							<td><button onclick="window.location=\'student_download.php?id=' . $row["ResID"] . '\'">Download</button></td>
						</tr>';
					$num = $num+1;
				}
			}
		?>
	</table>
	<div class="buttons-row">
        <button class="back" onclick="window.location='resource_stuview_selecttopic.php'">Back</button>
    </div>
</div>

<?php
    //Handle errors during the execution of the prepared statement
    if (mysqli_stmt_errno($stmt)) {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    //Close the statement
    mysqli_stmt_close($stmt);
    //Close the database connection
    mysqli_close($connection);
?>
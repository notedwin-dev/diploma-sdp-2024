<?php
    include('secure.php');
    include('connection.php'); 
    if(isset($_POST['insert'])){
			$resfile = $_FILES['resfile']['tmp_name'];
			//Read the content of the file into string
			$file = file_get_contents($resfile);
			$resname = $_POST['resname'];
			$topicid = $_POST['topicid'];
			$sql = "INSERT INTO resources (ResName, ResFileName, TopicID)
			VALUES (?, ?, ?)";
			$stmt = mysqli_prepare($connection,$sql);
			//Bind variables to the parameter markers of the prepared statement
			mysqli_stmt_bind_param($stmt,'ssi',$resname,$file,$topicid);
			//Execute the statement
			mysqli_stmt_execute($stmt);
			$check = mysqli_stmt_affected_rows($stmt);
			if ($check == 1){
				echo '<script>alert("New Resource Added Successfully!");
				window.location.href = "resource_view.php?topicID='.$topicid.'";
				</script>';
			}else{
				echo '<script>alert("Fail to add resource!");
				window.location.href = "resource_insertform.php";
				</script>';
			}
			mysqli_close($connection);
		}
?>



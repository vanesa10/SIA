<?php
	include 'connect.php';
	if(isset($_POST['add'])){
		if(isset($_POST['id']) && isset($_POST['date'])){
			$id=$_POST['id'];
			$date=$_POST['date'];
			if($id != "" && $date != ""){
				$query = mysqli_query($con, "select count(*) from general_journal where id = '$id'");
				$row = mysqli_fetch_row($query);
				echo $row[0];
				if($row[0] == 0){
					$query=mysqli_query($con,"insert into general_journal values('$id','$date','0')");
					header("location:addjournal-form.php?id=$id");
				}
				else{
					header("location:generaljournal.php?success=0");	
				}
				//echo "A";
			}
			else{
				header("location:generaljournal.php?success=0");
			}
		}
		else{
			header("location:generaljournal.php?success=0");
		}
		//echo "b";
	}
	else{
		//echo "c";
		header("location:generaljournal.php?success=0");
	}
?>
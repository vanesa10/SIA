<?php
	include("connect.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		//echo $id."<br>";
		if($_GET['id'] != ""){
			$query = mysqli_query($con, "select count(*) from detail_journal where id_generaljournal = '$id'");
			$row = mysqli_fetch_row($query);
			echo $row[0];
			if($row[0] == 0){
				header("location:generaljournal.php?success=3");	
			}
			else{
				mysqli_query($con, "update general_journal set posted = 1 where id = '$id'");
				header("location:generaljournal.php?success=5");
			}
		}
		else{
			header("location:generaljournal.php?success=2");	
		}
	}
	else{
		header("location:generaljournal.php?success=2");
	}
?>
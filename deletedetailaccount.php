<?php
	include 'connect.php';
	if(isset($_GET['id'])){
		if($_GET['id'] != ""){
			$id = $_GET['id'];
			$query = mysqli_query($con, "select count(*) from detail_account where id = $id");
			$row = mysqli_fetch_row($query);
			if($row[0] != 0){
				$query = mysqli_query($con, "select id_detailjournal from detail_account where id = $id");
				$row = mysqli_fetch_row($query);
				echo $row[0];
				//echo "a";
				mysqli_query($con, "delete from detail_account where id = $id");
				header("location:editdetailjournal-form.php?id=".$row[0]);
			}
			else{
				//echo "b";
				header("location:generaljournal.php");
			}
		}
		else{
			//echo "c";
			header("location:generaljournal.php");
		}
	}
	else{
		//echo "d";
		header("location:generaljournal.php");
	}
?>
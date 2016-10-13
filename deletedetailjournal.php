<?php
	include 'connect.php';
	if(isset($_GET['id'])){
		if($_GET['id'] != ""){
			$id = $_GET['id'];
			$query = mysqli_query($con, "select * from detail_account where id_detailjournal = $id");
			while($da = mysqli_fetch_row($query)){
				mysqli_query($con, "delete from detail_account where id = $da[0]");
			}
			mysqli_query($con, "delete from detail_journal where id = $id");
			session_start();
			$gj = $_SESSION['gj'];
			header("location:editjournal-form.php?id=".$gj[0]);
		}
		else{
			header("location:generaljournal.php");	
		}
	}
	else{
		header("location:generaljournal.php");
	}
?>
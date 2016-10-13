<?php
	include 'connect.php';
	session_start();
	if(isset($_POST['update'])){
		if($_POST['dr'] == ""){
			$type1 = 1;
		}
		else{
			$val = $_POST['dr'];
			$type1 = 0;
		}
		if($_POST['cr'] == ""){
			$type = 0;
		}
		else{
			$val = $_POST['cr'];
			$type = 1;
		}
		if($type1 != $type){
			header("location:editdetailaccount-form.php?id=".$_SESSION['id']."&success=1");
		}
		else{
			$acc = $_POST['acc'];
			$id = $_SESSION['id'];
			$query = mysqli_query($con, "update detail_account set type = $type, value = $val, id_Account = $acc where id = $id");
			session_destroy();
			header("location:editdetailjournal-form.php?id=".$_SESSION['da']);
			//header("location:addjournal-form.php?id=".$_SESSION['idgj']);
		}
	}
	else{
		header("location:generaljournal.php");
	}
?>
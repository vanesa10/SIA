<?php
	include 'connect.php';
	session_start();
	if(isset($_SESSION['idtemp']) && isset($_POST['update'])){
		if($_POST['dr'] == ""){
			//$dr = 0;
			$type1 = 1;
		}
		else{
			$val = $_POST['dr'];
			$type1 = 0;
		}
		if($_POST['cr'] == ""){
			//$cr = 0;
			$type = 0;
		}
		else{
			$val = $_POST['cr'];
			$type = 1;
		}
		if($type1 != $type){
			header("location:edittemp-form.php?id=".$_SESSION['idtemp']."&success=1");
		}
		else{
			$acc = $_POST['acc'];
			$id = $_SESSION['idtemp'];
			$query = mysqli_query($con, "update temp_detail_account set type = $type, value = $val, id_Account = $acc where id = $id");
			session_destroy();
			header("location:addjournal-form.php?id=".$_SESSION['idgj']);
		}
	}
	else{
		header("location:generaljournal.php");
	}
?>
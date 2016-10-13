<?php
	include 'connect.php';
	if(isset($_GET['id'])){
		if($_GET['id'] != ""){
			$id = $_GET['id'];
			$query = mysqli_query($con, "select count(*) from temp_detail_account where id = $id");
			$tda = mysqli_fetch_row($query);
			if($tda[0] == 0){
				header("location:generaljournal.php");
			}
			else{
				//session_start();
				$query = mysqli_query($con, "select tda.id_Account, tda.type, tda.value , tda.ID_tempDetailJournal, tdj.id_generaljournal from temp_detail_account tda JOIN temp_detail_journal tdj on tda.ID_tempDetailJournal = tdj.ID where tda.ID = $id");
				$tda = mysqli_fetch_row($query);
				$gj = $tda[4];
				$query = mysqli_query($con, "delete from temp_Detail_Account where id = $id");
				header("location:addjournal-form.php?id=".$gj);
			}
			//$gj =mysqli_fetch_row($query);
		}
		else{
			header("location:generaljournal.php");
		}
	}
	else{
		header("location:generaljournal.php");
	}
?>
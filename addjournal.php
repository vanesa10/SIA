<?php
	include 'connect.php';
	if(isset($_POST['add'])){
		$id = $_POST['id'];
		$desc = $_POST['desc'];
		$cr = $_POST['cr'];
		$dr = $_POST['dr'];
		$ac = $_POST['acc'];
		if($cr == ""){
			$type1 = 0;
		}
		else{
			$type1 = 1;
			$val = $cr;
		}
		if($dr == ""){
			$type = 1;
		}
		else{
			$type = 0;
			$val = $dr;
		}
		if($type != $type1){
			header("location:addjournal-form.php?id=".$id."&success=0");
		}
		else{
			$query = mysqli_query($con, "select count(*) from temp_detail_journal where id_generaljournal = '$id'");
			$ada = mysqli_fetch_row($query);
			if($ada[0] == 0){
				mysqli_query($con, "insert into temp_detail_journal values(NULL, '$desc', '$id')");
			}
			elseif ($ada[0] == 1){
				mysqli_query($con, "update temp_detail_journal set description = '$desc' where id_generaljournal = '$id'");
			}
			else{
				mysqli_query($con, "delete from temp_detail_journal where id_generaljournal = '$id'");	
			}
			$query = mysqli_query($con, "select * from temp_detail_journal where id_generaljournal = '$id'");
			$tdj = mysqli_fetch_row($query);
			$query = mysqli_query($con, "select id, value from temp_detail_account where ID_tempDetailJournal = $tdj[0] and type = $type and id_Account = $ac");
			$tda = mysqli_fetch_row($query);
			if($tda[0] != ""){
				$val += $tda[1];
				mysqli_query($con, "update temp_detail_account set value = $val where id = $tda[0]");
			}
			else{
				mysqli_query($con, "insert into temp_detail_account values(NULL, $type, $val, $ac, $tdj[0])");
			}
			header("location:addjournal-form.php?id=".$id);
		}
	}
	else if(isset($_POST['save'])){
		$id = $_POST['id'];
		$desc = $_POST['desc'];
		$query = mysqli_query($con,"select SUM(case when da.Type = 0 then value else value * -1 end) from temp_detail_account da join account a on da.ID_Account = a.ID join account_type at on at.ID = a.ID_Type join temp_detail_journal tdj on tdj.ID = da.ID_tempDetailJournal WHERE tdj.ID_GeneralJournal = '$id'");
		//echo "select SUM(case when da.Type = at.Normal_Balance then value else value * -1 end) from temp_detail_account da join account a on da.ID_Account = a.ID join account_type at on at.ID = a.ID_Type join temp_detail_journal tdj on tdj.ID = da.ID_tempDetailJournal WHERE tdj.ID_GeneralJournal = '$id'";
		$balance = mysqli_fetch_row($query);
		echo $balance[0];
		if($balance[0] == 0){
			mysqli_query($con, "insert into detail_journal values(NULL,'$desc', '$id')");
			$query = mysqli_query($con, "select max(id) from detail_journal");
			$dj = mysqli_fetch_row($query);
			$query = mysqli_query($con, "select id from temp_detail_journal where id_generaljournal = '$id'");
			$tdj = mysqli_fetch_row($query);
			$query = mysqli_query($con, "select id, type, value, id_account from temp_detail_account where ID_tempDetailJournal = $tdj[0]");
			//echo "select id, type, value, id_account from temp_detail_account where ID_tempDetailJournal = $tdj[0]";
			while($tda = mysqli_fetch_row($query)){
				
				//echo "insert into detail_account values(NULL, $tda[1], $tda[2], $tda[3], $dj[0])"."<br>";
				mysqli_query($con, "insert into detail_account values(NULL, $tda[1], $tda[2], $tda[3], $dj[0])");
				//echo "delete from temp_detail_account where id = $tda[0]"."<br>";
				mysqli_query($con, "delete from temp_detail_account where id = $tda[0]");
			}
			//echo "delete from temp_detail_journal where id = $tdj[0]"."<br>";
			mysqli_query($con, "delete from temp_detail_journal where id = $tdj[0]");
			header("location:generaljournal.php?success=4");
		}
		else{
			header("location:addjournal-form.php?id=".$id."&success=1");
		}
	}
	else if(isset($_POST['del'])){
		$id = $_POST['id'];
		$query = mysqli_query($con, "select id from temp_detail_journal where id_generaljournal = '$id'");
		$tdj = mysqli_fetch_row($query);
		$query = mysqli_query($con, "select id from temp_detail_account where ID_tempDetailJournal = $tdj[0]");
		while($tda = mysqli_fetch_row($query)){
			mysqli_query($con, "delete from temp_detail_account where id = $tda[0]");
		}
		mysqli_query($con, "delete from temp_detail_journal where id = $tdj[0]");
		header("location:generaljournal.php");
	}
	else{
		header("location:generaljournal.php");
	}
?>
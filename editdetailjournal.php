<?php
	include 'connect.php';
	if(isset($_POST['add'])){
		echo"A";
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
			echo"b";
			header("location:editdetailjournal-form.php?id=".$id."&success=0");
		}
		else{
			echo"c";
			$query = mysqli_query($con, "SELECT Value FROM detail_account da JOIN detail_journal dj on da.ID_DetailJournal = dj.ID where ID_DetailJournal = $id and type = $type and id_Account = $ac");
			$va = mysqli_fetch_row($query);
			if($va[0] != ""){
				$val += $va[0];
				mysqli_query($con, "update detail_account set value = $val");
			}
			else{
				mysqli_query($con, "insert into detail_account values(NULL, $type, $val, $ac, $id)");	
			}
			header("location:editdetailjournal-form.php?id=".$id);
		}
	}
	else if(isset($_POST['save'])){
		$id = $_POST['id'];
		$desc = $_POST['desc'];
		//echo "select SUM(case when da.Type = 0 then value else value * -1 end) from detail_account where ID_DetailJournal = $id";
		$query = mysqli_query($con,"select SUM(case when Type = 0 then value else value * -1 end) from detail_account where ID_DetailJournal = $id");
		$balance = mysqli_fetch_row($query);
		echo $balance;
		echo"d";
		if($balance[0] == 0){
			mysqli_query($con, "update into detail_journal set description = '$desc' where id = $id");
			header("location:generaljournal.php?success=6");
		}
		else{
			header("location:editdetailjournal-form.php?id=".$id."&success=1");
		}
	}
	else if(isset($_POST['del'])){
		echo"e";
		$id = $_POST['id'];
		$query = mysqli_query($con, "select id from detail_account where ID_DetailJournal = $id");
		while($row = mysqli_fetch_row($query)){
			mysqli_query($con, "delete from detail_account where id = $row[0]");
		}
		mysqli_query($con, "delete from detail_journal where id = $id");
		header("location:generaljournal.php");
	}
	else{
		echo"f";
		header("location:generaljournal.php");
	}
?>
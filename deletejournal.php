<?php
	include("connect.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		//echo $id."<br>";
		if($_GET['id'] != ""){
			$query = mysqli_query($con, "select id from detail_journal where id_generaljournal = '$id'");
			//echo "1. select id from detail_journal where id_generaljournal = '$id'<br>";
			while($row = mysqli_fetch_row($query)){
				$query2 = mysqli_query($con, "select id from detail_account where id_detailjournal = $row[0]");
				//echo  "2. select id from detail_account where id_detailjournal = $row[0]<br>";
				while($row1 = mysqli_fetch_row($query2)){
					mysqli_query($con, "delete from detail_account where id = $row1[0]");
					//echo "3. delete from detail_account where id = $row1[0]<br>";
				}
				mysqli_query($con, "delete from detail_journal where id = $row[0]");
				//echo "4. delete from detail_journal where id = $row[0]<br>";
			}

			$query = mysqli_query($con, "select id from temp_detail_journal where id_generaljournal = '$id'");
			//echo "5. select id from temp_detail_journal where id_generaljournal = '$id'<br>";
			while($row = mysqli_fetch_row($query)){
				$query2 = mysqli_query($con, "select id from temp_detail_account where id_tempdetailjournal = $row[0]");
				//echo "6. select id from temp_detail_account where id_tempdetailjournal = $row[0]<br>";
				while($row1 = mysqli_fetch_row($query2)){
					mysqli_query($con, "delete from temp_detail_account where id = $row1[0]");
					//echo "7. delete from temp_detail_account where id = $row1[0]<br>";
				}
				mysqli_query($con, "delete from temp_detail_journal where id = $row[0]");
				//echo "8. delete from temp_detail_journal where id = $row[0]<br>";
			}
			mysqli_query($con, "delete from general_journal where id = '$id'");
			//echo "9. delete from general_journal where id = '$id'<br>";
			header("location:generaljournal.php");
		}
		else{
			header("location:generaljournal.php?success=1");
		}
	}
	else{
		header("location:generaljournal.php?success=1");
	}
?>
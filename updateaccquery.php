<?php

include("connect.php");
session_start();
if(isset($_POST['update']) && isset($_POST['id']))
{
	$id_=$_POST['id'];
	$nama_=$_POST['nama'];
	$tipe_=$_POST['type'];
	$id = $_SESSION['id'];
	echo $id_;
	echo $nama_;
	echo $tipe_;
	if(($id_=="") || ($nama_=="") || ($tipe_==0)){
		echo "data belum lengkap!";
	}
	else {
		$queryupdate=mysqli_query($con, "UPDATE account SET ID=$id_,Name='$nama_',ID_Type=$tipe_ WHERE ID = $id");
		header("location: acc.php");
	}
}
?>
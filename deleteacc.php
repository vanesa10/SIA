<?php
include("connect.php");

$id_=$_GET['fid'];
if(isset($_GET['fid']))
{
	$querydelete=mysqli_query($con, "delete from account where ID=$id_");
	header("location: acc.php");
}
?>
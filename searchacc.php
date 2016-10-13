<?php
include("connect.php");
$nama_=$_POST['fnama'];
	 
 if(isset($_POST['search']))
{ 
$query=mysqli_query($conn, "select * account where name='$nama_'");
while($row=mysqli_fetch_array($query))
{
	echo "<tbody>";
	echo "<tr>";
		echo "<td>".$row[0]."</td>";
		echo "<td>".$row[1]."</td>";
		echo "<td>".$row[2]."</td>";
	echo "</tr>";
	echo "</tbody>";
}
}
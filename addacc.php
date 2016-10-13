<?php
include("connect.php");

$id_=$_POST['fid'];
$nama_=$_POST['fnama'];
$tipe_=$_POST['ftype'];

 if(isset($_POST['add']))
 {
 	$queryinsert=mysqli_query($con, "insert into account values($id_, '$nama_', $tipe_)");
 	header("location: acc.php");
 }
 else if(isset($_POST['search'])){
 	echo'

<?php
include("connect.php");
?> 
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Account</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/flat-ui.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/flat-ui.min.js"></script>
 	
	<!-- 
	<link rel= stylesheet href= "css/bootstrap.css">
  	<script src="jquery-2.2.1.js"></script>
  	<script type= "text/javascript" src="js/bootstrap.js"></script>
  	<link rel= stylesheet href= "css/bootstrap.min.css"> -->
</head>

<body>
	<div class="wrapper" style="min-height:100%;">
		<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
					<span class="sr-only">Toggle navigation</span>
				</button>
				<a class="navbar-brand" href="#">CKCounting</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse-01">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="home.php">Home</a></li>
					<li><a href="acc.php">Account</a></li>
					<li><a href="generaljournal.php">General Journal</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Financial Statement<b class="caret"></b></a>
						<span class="dropdown-arrow"></span>
						<ul class="dropdown-menu">
							<li><a href="income-form.php">Income Statement</a></li>
							<li><a href="ownersequity-form.php">Owner\'s Equity</a></li>
							<li><a href="balancesheet-form.php">Balance Sheet</a></li>
					  	</ul>
					</li>
					<li><a href="trialbalance-form.php">Trial Balance</a></li>
			   	</ul>
			</div>
		</nav>
<div class="container">
	<h1 style="text-align:center"> Account </h1>
	<br>
	<table class="table table-hover">
		<thead>
		<tr>
			<th width="20%">ID</th>
			<th width="30%">Name</th>
			<th width="30%">Type</th>
			<th width="20%">Action</th>
		</tr>
		<tr>	
			<form action="addacc.php" method="POST">
			<td width="20%"><input type="text" name="fid" class="form-control">
			</div></td>
			<td width="30%"><input type="text" name="fnama" class="form-control">
			</div></td>
			<td width="30%"><select name="ftype" id="ftype" class="form-control">
			<option value = "0">-- Select --</option>';
			$queryjoin=mysqli_query($con, "select * from account_type");
			while($row=mysqli_fetch_row($queryjoin)) 
			{
				echo "<option value=".$row[0].">".$row[1]."</option>";
			}
			echo '
			</select>
			</td>
			<td width="20%">
				<!-- <input type="submit" class="btn btn-success"> -->
			<button type="submit" class="btn btn-success" name="add"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i></button>
			<button type="submit" class="btn btn-default" name="search"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></button></td>
			</form>
		</tr>';
		if($id_ == "" && $nama_ == "" && $tipe_ == 0){
			$query=mysqli_query($con,"select a.id, a.name, at.type from account a join account_type at on a.id_type = at.id");
		}
		else if($nama_ != ""){
			$query=mysqli_query($con,"select a.id, a.name, at.type from account a join account_type at on a.id_type = at.id where a.id = '$id_' or a.name like '%$nama_%' or a.id_type = $tipe_");
		}
		else{
			$query=mysqli_query($con,"select a.id, a.name, at.type from account a join account_type at on a.id_type = at.id where a.id = '$id_' or a.id_type = $tipe_");	
		}
		while($row=mysqli_fetch_row($query))
		{
			echo "<tbody>";
			echo "<tr>";
				echo "<td>".$row[0]."</td>";
				echo "<td>".$row[1]."</td>";
				echo "<td>".$row[2]."</td>";
				echo "<td>";
				echo "<a href='updateacc.php?fid=".$row[0]."&fnama=".$row[1]."&ftype=".$row[2]."'> <button type='button' class='btn btn-success'><i class='glyphicon glyphicon-pencil' aria-hidden='true'></i></button>";
				echo "<a href='deleteacc.php?fid=".$row[0]."'> <button type='button' class='btn btn-danger' name='delete'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button></td>";
			echo "</tr>";
			echo "</tbody>";
		}
		echo'
</table>
	</div>

<footer>
		<div class="container">
			<div class="text-center">
				© CKCompany 2016
			</div>
		</div>
</footer>

	</div>
<body>
</body>
</html>';
 

}
?>
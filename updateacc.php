<?php
include("connect.php");
	$id_=$_GET['fid'];
	$nama_=$_GET['fnama'];
	$tipe_=$_GET['ftype'];
	session_start();
	$_SESSION['id'] = $id_;
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit Account</title>

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
							<li><a href="ownersequity-form.php">Owner's Equity</a></li>
							<li><a href="balancesheet-form.php">Balance Sheet</a></li>
					  	</ul>
					</li>
					<li><a href="trialbalance-form.php">Trial Balance</a></li>
			   	</ul>
					</li>
			   	</ul>
			</div>
		</nav>
	<div class="container">
	<h3 style="text-align:center"> Edit Account </h3>
	<br>
	<form action="updateaccquery.php" method="POST" enctype="multipart/form-data">
		<div class="input-group">
	 	<span id="basic-addon1"><b>ID</b></span>
		<input type="text" value="<?php echo $id_ ?>" class="form-control" placeholder="id" aria-describedby="basic-addon1" name="id">
		</div>
		<div class="input-group">
	 	<span id="basic-addon1"><b>Description</b></span>
		<input type="text" value="<?php echo $nama_ ?>" class="form-control" placeholder="description" aria-describedby="basic-addon1" name="nama">
		</div>
		<div class="input-group">
	 	<span id="basic-addon1"><b>Type</b></span>
		<!-- <input type="text" value="<?php echo $tipe_ ?>" class="form-control" placeholder="type." aria-describedby="basic-addon1" name="type"> -->
		<select name="type" class="form-control">
			<option value = "0">-- Select --</option>
			<?php 
			$queryjoin=mysqli_query($con, "select * from account_type");
			while($row=mysqli_fetch_row($queryjoin))
			{
				if($_GET['ftype'] == $row[0]){
					echo "<option value=".$row[0]." selected>".$row[1]."</option>";	
				}
				else{
					echo "<option value=".$row[0].">".$row[1]."</option>";
				}
			}
			?>
			</select>
			<!-- <option value="<?php echo $tipe_ ?>" selected="selected"><?php echo $tipe_ ?></option> -->
	</div>
		<button type='submit' name='update' class='btn btn-success'> Update </button>
		</form>
	</div>
	 <footer>
			<div class="container">
				<div class="text-center">
					© CKCompany 2016
				</div>
			</div>
	</footer>

</body>
</html>
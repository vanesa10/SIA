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
				session_start();
				$query = mysqli_query($con, "select tda.id_Account, tda.type, tda.value , tda.ID_tempDetailJournal, tdj.id_generaljournal from temp_detail_account tda JOIN temp_detail_journal tdj on tda.ID_tempDetailJournal = tdj.ID where tda.ID = $id");
				$tda = mysqli_fetch_row($query);
				$gj = $tda[4];
				$_SESSION['idtemp'] = $id;
				$_SESSION['idgj'] = $gj;
			}
		}
		else{
			header("location:generaljournal.php");
		}
	}
	else{
		header("location:generaljournal.php");
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit Journal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/flat-ui.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/flat-ui.min.js"></script>
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
			</div>
		</nav>
		<div class="header text-center">
			<h2>Edit Journal</h2>
			<?php
				if(isset($_GET['success'])){
					if($_GET['success'] == 1){
						echo'
						<div class="alert alert-danger alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Can\'t Save the account!</strong>
						</div>';
					}
				}
			?>
		</div>
		<div class="container">
			<form class="form-horizontal" action="edittemp.php" method="post">
				<div class="form-group">
					<label for="acc" class="control-label col-sm-2">Account</label>
					<div class="col-sm-10">
						<select class="form-control" name="acc">
							<?php
								$query = mysqli_query($con, "select id, name from account");
								while ($acc = mysqli_fetch_row($query)) {
									if($tda[0] == $acc[0]){
										echo '<option value="'.$acc[0].'" selected>'.$acc[1].'</option>';
									}
									else{
										echo '<option value="'.$acc[0].'">'.$acc[1].'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="dr" class="control-label col-sm-2">Debit</label>
					<div class="col-sm-10">
						<?php
							if($tda[1] == 0){
								echo '<input type="text" class="form-control" id="dr" name="dr" value="'.$tda[2].'">';
							}
							else{
								echo '<input type="text" class="form-control" id="dr" name="dr">';
							}
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="cr" class="control-label col-sm-2">Credit</label>
					<div class="col-sm-10">
						<?php
							if($tda[1] == 1){
								echo '<input type="text" class="form-control" id="cr" name="cr" value="'.$tda[2].'">';
							}
							else{
								echo '<input type="text" class="form-control" id="cr" name="cr">';
							}
						?>
					</div>
				</div>
				<button type="submit" class="btn btn-primary" name="update" style="float:right;margin-left:10px;"><i class="fui-check"></i><span> Submit</span></button>
				<?php
					echo '<a href="addjournal-form.php?id='.$gj.'"><button type="button" class="btn btn-warning" style="float:right;"><i class="fui-cross"></i><span> Cancel</span></button></a>';
				?>
			</form>
		</div>
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
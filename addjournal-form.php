<?php
	include 'connect.php';
	if(isset($_GET['id'])){
		if($_GET['id'] != ""){
			$id = $_GET['id'];
			$query = mysqli_query($con, "select * from general_journal where id = '$id'");
			$gj = mysqli_fetch_row($query);
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
	<title>Add Journal</title>
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
			<h2>Add Journal</h2>
			<?php
				echo "<h6>".$id."</h6>";
			?>
		</div>
		<div class="container">
			<form action="addjournal.php" method="post">
				<div class="form-group">
					<label for="id" class="control-label"><strong>ID</strong></label>
					<?php
						echo '<input type="text" class="form-control" style="color:black;" id="id" name="id" value="'.$id.'" readonly>';
					?>
				</div>
				<div class="form-group">
					<label for="desc"><strong>Description</strong></label>
					<textarea class="form-control" style="max-height:100px;max-width:100%;" id="desc" name="desc"><?php
					$query = mysqli_query($con, "select id, Description from temp_detail_journal where id_generaljournal = '$id'");
					$tdj = mysqli_fetch_row($query);
					echo $tdj[1];
					?></textarea>
				</div>
				<?php
					if(isset($_GET['success'])){
						if($_GET['success'] == 0){
							echo'
							<div class="alert alert-danger alert-dismissible" role="alert">
	  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Add Journal has
	  							<strong> Failed!</strong>
							</div>';
						}
						else if($_GET['success'] == 1){
							echo'
							<div class="alert alert-danger alert-dismissible" role="alert">
	  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Journal<strong> Not Balance!</strong>
							</div>';
						}
					}
				?>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Account</th>
							<th>Ref</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Action</th>
						</thead>
						<tbody>
							<tr>
								<td><a href="acc.php"><button type="button" class="btn btn-success"><i class="fui-plus"></i><span> Account</span></button></td>
								<td>
									<select class="form-control" name="acc">
										<?php
											$query = mysqli_query($con, "select id, name from account");
											while ($acc = mysqli_fetch_row($query)) {
												echo '<option value="'.$acc[0].'">'.$acc[1].'</option>';
											}
										?>
									</select>
								</td>
								<td></td>
								<td><input type="text" class="form-control" name="dr"></td>
								<td><input type="text" class="form-control" name="cr"></td>
								<td><button type="submit" class="btn btn-primary" name="add"><i class="fui-plus"></i></button></td>
							</tr>
							<?php
								if($tdj[0] != ""){
									$query = mysqli_query($con, "select tda.Type, tda.Value, a.ID, a.Name, tda.id FROM temp_detail_account tda join account a on tda.ID_Account = a.ID where tda.ID_tempDetailJournal = $tdj[0] order by tda.Type");
									while($tda = mysqli_fetch_row($query)){
										echo'
										<tr>
											<td></td>
											<td>'.$tda[3].'</td>
											<td>'.$tda[2].'</td>';
										if($tda[0] == 0){
											echo '
											<td>'.$tda[1].'</td>
											<td></td>';
										}
										else{
											echo '
											<td></td>
											<td>'.$tda[1].'</td>';
										}
										echo '
										<td>
											<a href="edittemp-form.php?id='.$tda[4].'"><button type="button" class="btn btn-info" name="add"><i class="fui-new"></i></button></a>
											<a href="deletetemp.php?id='.$tda[4].'"><button type="button" class="btn btn-danger" name="add"><i class="fui-cross"></i></button></a>
										</td>
										</tr>';
									}
								}
							?>
						</tbody>
					</table>
				</div>
				<button type="submit" class="btn btn-primary" name="save" style="float:right;margin-left:10px;"><i class="fui-check"></i><span> Submit</span></button>
				<button type="submit" class="btn btn-warning" name="del" style="float:right;"><i class="fui-cross"></i><span> Cancel</span></button>
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
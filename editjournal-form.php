<?php
	include 'connect.php';
	if(isset($_GET['id'])){
		if($_GET['id'] != ""){
			$id = $_GET['id'];
			$query = mysqli_query($con, "select * from general_journal where id = '$id'");
			$gj = mysqli_fetch_row($query);
			session_start();
			$_SESSION['gj'] = $gj;
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
	<title>View Journal</title>
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
			<h2>General Journal</h2>
			<?php
				echo "<h6>".$gj[1]."</h6>";
				if($gj[2] == 0){
					echo "<h6>".$id." - Not Posted</h6>";
				}
				else{
					echo "<h6>".$id."</h6>";	
				}
			?>
		</div>
		<div class="container">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<th>Account & Description</th>
						<th>Ref</th>
						<th>Debit</th>
						<th>Credit</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							$query = mysqli_query($con, "select id, Description from detail_journal where id_generaljournal = '$id'");
							while($dj = mysqli_fetch_row($query)){
								echo '
								<tr class="active">
									<th>'.$dj[1].'</th>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<a href="editdetailjournal-form.php?id='.$dj[0].'"><button class="btn btn-warning"><i class="fui-new"></i></button></a>
										<a href="deletedetailjournal.php?id='.$dj[0].'"><button class="btn btn-danger"><i class="fui-cross"></i></button></a>
									</td>
								</tr>';
								$query2 = mysqli_query($con, "SELECT a.id, a.name, da.Type, da.Value FROM detail_account da join account a on da.ID_Account = a.ID where ID_DetailJournal = $dj[0] ORDER by Type");
								while($da = mysqli_fetch_row($query2)){
									echo '<tr>';
									if($da[2] == 0){
										echo '<td style="padding-left:25px;">'.$da[1].'</td>
										<td>'.$da[0].'</td>
										<td>Rp. '.$da[3].'</td>
										<td></td>
										<td></td>';
									}
									else{
										echo '<td style="padding-left:50px;">'.$da[1].'</td>
										<td>'.$da[0].'</td>
										<td></td>
										<td>Rp. '.$da[3].'</td>
										<td></td>';	
									}
									echo'</tr>';
								}
							}
						?>
					</tbody>
				</table>
			</div>
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
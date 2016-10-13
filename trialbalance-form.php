<html>
<head>
	<meta charset="utf-8">
	<title></title>
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
			<h2>Trial Balance</h2>
			<h6><?php 
			if(isset($_GET['date']))
			{
				if($_GET['date'] != "" && $_GET['to'] != ""){
					$sampai=$_GET['to'];
					echo "As";
					echo $sampai;
				}
			}
			?></h6>
		</div>
		<div class="container">
			<form class="form-inline" action="trialbalance-form.php" method="get">
				<div class="form-group">
					<label for="tanggal">From</label>
					<input type="date" class="form-control" id="tanggal" name="to">
				</div>
				<input type="submit" class="btn btn-success" name="date">
			</form>
	<?php
	include("connect.php");
		if(isset($_GET['date']))
			{
				if($_GET['date'] != "" && $_GET['to'] != ""){
					$totald=0;
					$totalk=0;
					echo '<table class="table table-responsive">
					<tbody>
							<tr class="active">
							<th>Account</th>
							<th>Debit</th>
							<th>Credit</th>
						</tr>';
					$query=mysqli_query($con,"select a.id,a.name,a.id_type,at.Normal_Balance from account a join account_type at on a.id_type=at.id");
						while($row=mysqli_fetch_row($query))
						{
							$balance=0;
							$query1=mysqli_query($con,"select da.value, da.type, a.name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where gj.posted='1' and da.id_account=$row[0] and date<='$sampai'");
							while($row1=mysqli_fetch_row($query1))
							{
								if($row1[1]==$row1[3])
								{
									$balance+=$row1[0];
								}
								else
								{
									$balance-=$row1[0];
								}

							}
							if($row[3]==0)
								{
									echo '<tr>
									<td style="padding-left:25px;">'.$row[1].'</td>
									<td>'.$balance.'</td>
									<td></td>
									</tr>';
									$totald+=$balance;
								}
								else
								{
									echo '<tr>
									<td style="padding-left:25px;">'.$row[1].'</td>
									<td></td>
									<td>'.$balance.'</td>
									</tr>';
									$totalk+=$balance;
								}
						}
						echo '<tr class="info">
									<td style="padding-left:25px;">Total</td>
									<td>'.$totald.'</td>
									<td>'.$totalk.'</td>
									</tr>';
					}				
			}
	?>
				</tbody>
			</table>
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
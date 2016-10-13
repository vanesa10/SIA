<?php
include("connect.php");
?>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
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
			<h2>Owner's Equity</h2>
			<?php 
				if(isset($_GET['date']))
				{
					if($_GET['date'] != ""){
						$tgl=$_GET['date'];
						echo '<h6>';
						echo 'As of ';
						echo $tgl;
						echo '</h6>';
					} 
				}
			?>
				
		</div>
		<div class="container">
			<form class="form-inline" action="#" method="GET">
				<div class="form-group">
					<label for="tanggal">Date</label>
					<input type="date" class="form-control" id="tanggal" name="date">
				</div>
				<input type="submit" class="btn btn-success" name="submit">
			</form>
			<?php
				if(isset($_GET['date']))
				{
					if($_GET['date'] != ""){
						echo '
						<table class="table table-responsive">
							<tbody>
								<tr class="active">
									<th>Owner\'s Equity</th>
									<th></th>
								</tr>';
						$totalequity=0;
						$totalnet=0;
						$total=0;
						$queryeq=mysqli_query($con,"select * from account where id_type = 3");
						while($row=mysqli_fetch_array($queryeq))
						{
							$balance=0;   
							$queryeq_=mysqli_query($con,"SELECT gj.id, da.type, da.Value, at.normal_balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where a.id = $row[0]");
							while($row=mysqli_fetch_row($queryeq_))
							{
								if($row[3]==$row[1]){
										$balance += $row[2];
									}
								else
								{
									$balance -= $row[2];
								}
							}
							//$total = $total + $balance;
						}

						$querydraw=mysqli_query($con,"select * from account where id_type = 4");
						while($row=mysqli_fetch_array($querydraw))
						{
							$balance3=0;
							$querydraw_=mysqli_query($con,"SELECT gj.id, da.type, da.Value, at.normal_balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where a.id = $row[0] ");
							while($row=mysqli_fetch_row($querydraw_))
							{
								if($row[3]==$row[1]){
										$balance += $row[2];
									}
								else
								{
									$balance -= $row[2];
								}
							}
						}

						$queryrev=mysqli_query($con,"select * from account where id_type = 5");
						$balance1=0;
						while($row=mysqli_fetch_array($queryrev))
						{
							$queryrev_=mysqli_query($con,"SELECT gj.id, da.type, da.Value, at.normal_balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where a.id = $row[0] ");
							while($row=mysqli_fetch_row($queryrev_))
							{
								if($row[3]==$row[1]){
										$balance1 += $row[2];
									}
								else
								{
									$balance1 -= $row[2];
								}
							}
						}

						$queryex=mysqli_query($con,"select * from account where id_type = 6");
						$balance2=0;
						while($row=mysqli_fetch_array($queryex))
						{
							$queryex_=mysqli_query($con,"SELECT gj.id, da.type, da.Value, at.normal_balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where a.id = $row[0] ");
							while($row=mysqli_fetch_row($queryex_))
							{
								if($row[3]==$row[1]){
										$balance2 += $row[2];
									}
								else
								{
									$balance2 -= $row[2];
								}
							}
						}
						$totalnet = $balance1 - $balance2;
						$totalequity = $balance + $totalnet;
						$total = $totalequity - $balance3;
						$tgl=$_GET['date'];
						echo '
						<tr>
							<td style="padding-left:25px;">Owner\'s Capital</td>
							<td>Rp. '.$balance.' </td>
						</tr>';
						echo '
						<tr>
						<td style="padding-left:25px;">Net Income</td>
						<td>Rp.'.$totalnet.'</td>
						</tr>';
						echo '<tr class="active">
							<th>Owner\'s Drawings</th>
							<th></th>
						</tr>
						<tr>
							<td style="padding-left:25px;">Owner\'s Drawings</td>
							<td>Rp. ('.$balance3.')</td>
						</tr>';
						echo '<tr class="info">
							<th>Owner\'s Equity - '.$tgl.'</th>
							<td>Rp.'.$total.' </td>
						</tr></table>';
					}
				}
			?><!-- 
			<table class="table table-responsive">
				<tbody>
					<tr class="active">
						<th>Owner's Equity</th>
						<th></th>
					</tr>
					<tr>
						<td style="padding-left:25px;">Owner's Capital</td>
						<td>Rp. </td>
					</tr>
					<tr>
						<td style="padding-left:25px;">Net Income</td>
						<td>Rp. </td>
					</tr>
					<tr class="active">
						<th>Owner's Drawings</th>
						<th></th>
					</tr>
					<tr>
						<td style="padding-left:25px;">Owner's Drawings</td>
						<td>Rp. ()</td>
					</tr>
					<tr class="info">
						<th>Owner's Equity - April, 30 2016</th>
						<td>Rp. </td>
					</tr>
				</tbody>
			</table> -->
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
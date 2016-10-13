<?php
	include("connect.php");
?>
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
			<h2>Balance Sheet</h2>
			<?php
				if(isset($_GET['date'])){
					if($_GET['date'] != ""){
						echo '<h6>As of '.$_GET['date'].'</h6>';
					}
				}
			?>
		</div>
		<div class="container">
			<form class="form-inline" action="balancesheet-form.php" method="GET">
				<div class="form-group">
					<label for="tanggal">Date</label>
					<input type="date" class="form-control" id="tanggal" name="date">
				</div>
				<input type="submit" class="btn btn-success">
			</form>
			<?php
				if(isset($_GET['date'])){
					$tgl = $_GET['date'];
					if($tgl != ""){
						echo '
						<table class="table table-responsive">
							<tbody>
								<tr class="active">
									<th width=50%>Assets</th>
									<td width=20%></td>
									<td width=10%></td>
									<td width=10%></td>
									<td width=10%></td>
								</tr>';
						//assets
						$query = mysqli_query($con, "SELECT a.id, a.Name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID where at.Type like 'Assets'");
						$total = 0;
						while($row = mysqli_fetch_row($query)){
							$query2 = mysqli_query($con, "SELECT da.type, da.Value FROM detail_account da join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where da.ID_Account = $row[0] and gj.Posted = 1 and gj.date < '$tgl'");
							$balance = 0;
							while($row2 = mysqli_fetch_row($query2)){
								if($row[2] == $row2[0]){
									$balance += $row2[1];
								}
								else{
									$balance -= $row2[1];
								}
							}
							$total += $balance;
							if($balance != 0){
								echo '
								<tr>
									<td style="padding-left:25px;">'.$row[1].'</td>
									<td></td>
									<td></td>
									<td>Rp. '.$balance.'</td>
									<td></td>
								</tr>';
							}
						}
						echo '
						<tr class="info">
							<th>Total Assets</th>
							<td></td>
							<td></td>
							<td></td>
							<th>Rp. '.$total.'</th>
						</tr>';
						//liability and equity
						echo '
						<tr><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="active">
							<th>Liability and Equity</th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<th style="padding-left:25px;">Equity</th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>';
						//equity
						$query = mysqli_query($con, "SELECT a.id, a.Name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID where at.Type like 'Owner''s Equity'");
						$equity = 0;
						while($row = mysqli_fetch_row($query)){
							$query2 = mysqli_query($con, "SELECT da.type, da.Value FROM detail_account da join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where da.ID_Account = $row[0] and gj.Posted = 1 and gj.date < '$tgl'");
							$balance = 0;
							while($row2 = mysqli_fetch_row($query2)){
								if($row[2] == $row2[0]){
									$balance += $row2[1];
								}
								else{
									$balance -= $row2[1];
								}
							}
							$equity += $balance;
							if ($balance != 0) {
								echo'
								<tr>
									<td style="padding-left:50px;">'.$row[1].'</td>
									<td></td>
									<td></td>
									<td>Rp. '.$balance.'</td>
									<td></td>
								</tr>';	
							}
						}
						//Drawings
						$query = mysqli_query($con, "SELECT a.id, a.Name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID where at.Type like 'Owner''s Drawings'");
						while($row = mysqli_fetch_row($query)){
							$query2 = mysqli_query($con, "SELECT da.type, da.Value FROM detail_account da join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where da.ID_Account = $row[0] and gj.Posted = 1 and gj.date < '$tgl'");
							$balance = 0;
							while($row2 = mysqli_fetch_row($query2)){
								if($row[2] == $row2[0]){
									$balance += $row2[1];
								}
								else{
									$balance -= $row2[1];
								}
							}
							$equity -= $balance;
							if($balance != 0){
								echo'
								<tr>
									<td style="padding-left:50px;">'.$row[1].'</td>
									<td></td>
									<td></td>
									<td>Rp.('.$balance.')</td>
									<td></td>
								</tr>';
							}
						}
						//retained earnings
						$income = 0;
						$query = mysqli_query($con, "SELECT a.id, a.Name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID where at.Type like 'Revenues'");
						while($row = mysqli_fetch_row($query)){
							$query2 = mysqli_query($con, "SELECT da.type, da.Value FROM detail_account da join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where da.ID_Account = $row[0] and gj.Posted = 1 and gj.date < '$tgl'");
							$balance = 0;
							while($row2 = mysqli_fetch_row($query2)){
								if($row[2] == $row2[0]){
									$balance += $row2[1];
								}
								else{
									$balance -= $row2[1];
								}
							}
							$income += $balance;
						}
						$query = mysqli_query($con, "SELECT a.id, a.Name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID where at.Type like 'Expenses'");
						while($row = mysqli_fetch_row($query)){
							$query2 = mysqli_query($con, "SELECT da.type, da.Value FROM detail_account da join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where da.ID_Account = $row[0] and gj.Posted = 1 and gj.date < '$tgl'");
							$balance = 0;
							while($row2 = mysqli_fetch_row($query2)){
								if($row[2] == $row2[0]){
									$balance += $row2[1];
								}
								else{
									$balance -= $row2[1];
								}
							}
							$income -= $balance;
						}
						$equity += $income;
						echo'
							<tr>
								<td style="padding-left:50px;">Retained Earnings</td>
								<td></td>
								<td></td>
								<td>Rp.'.$income.'</td>
								<td></td>
							</tr>';
						echo '
						<tr>
							<th style="padding-left:75px;">Total Equity</th>
							<td></td>
							<td></td>
							<td></td>
							<th>Rp. '.$equity.'</th>
						</tr>';
						//liability
						echo '
						<tr>
							<th style="padding-left:25px;">Liability</th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>';
						$query = mysqli_query($con, "SELECT a.id, a.Name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID where at.Type like 'Liability'");
						$liability = 0;
						while($row = mysqli_fetch_row($query)){
							$query2 = mysqli_query($con, "SELECT da.type, da.Value FROM detail_account da join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where da.ID_Account = $row[0] and gj.Posted = 1 and gj.date < '$tgl'");
							$balance = 0;
							while($row2 = mysqli_fetch_row($query2)){
								if($row[2] == $row2[0]){
									$balance += $row2[1];
								}
								else{
									$balance -= $row2[1];
								}
							}
							$liability += $balance;
							if ($balance != 0) {
								echo'
								<tr>
									<td style="padding-left:50px;">'.$row[1].'</td>
									<td></td>
									<td></td>
									<td>Rp. '.$balance.'</td>
									<td></td>
								</tr>';	
							}
						}
						$total = $liability + $equity;
						echo '
							<tr>
								<th style="padding-left:75px;">Total Liability</th>
								<td></td>
								<td></td>
								<td></td>
								<th>Rp. '.$liability.'</th>
							</tr>
							<tr class="info">
								<th>Total Liability and Equity</th>
								<td></td>
								<td></td>
								<td></td>
								<th>Rp. '.$total.'</th>
							</tr>
							</tbody>
						</table>';
					}
				}
			?>
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
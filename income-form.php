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
			<h2>Income Statement</h2>
			<h6><?php 
			if(isset($_GET['date1']))
			{
				if($_GET['date1'] != "" && $_GET['to'] != "" && $_GET['from'] != ""){
					$dari=$_GET['from'];
					$sampai=$_GET['to'];
					echo $dari;
					echo " to ";
					echo $sampai;
				}
			}
			?></h6>
		</div>
		<div class="container">
			<form class="form-inline" action="income-form.php" method="get">
				<div class="form-group">
					<label for="tanggal">Date</label>
					<input type="date" class="form-control" id="tanggal" name="from">
				</div>
				<div class="form-group">
					<label for="tanggal">to</label>
					<input type="date" class="form-control" id="tanggal" name="to">
				</div>
				<input type="submit" class="btn btn-success" name="date1">
			</form>
			<?php
				include("connect.php");
				if(isset($_GET['date1']))
				{
					if($_GET['date1'] != "" && $_GET['to'] != "" && $_GET['from'] != ""){
						$total=0;
						$total1=0;
						echo '
						<table class="table table-responsive">
							<tbody>
								<tr class="active">
									<th width=50%>Revenues</th>
									<td width=20%></td>
									<td width=10%></td>
									<td width=10%></td>
									<td width=10%></td>
								</tr>
						';
						$query=mysqli_query($con,"select id, name from account where id_type='5'");
						while($row=mysqli_fetch_row($query))
						{
							$balance=0;
							//echo "select dc.value,dc.type from detail_account dc join detail_journal dj on dc.ID_DetailJournal=dj.id join general_journal gj on gj.id=dj.id_generaljournal where gj.posted='1' and dc.id_account=$row[0] and date<'$tgl'";
							$query1=mysqli_query($con,"select da.value, da.type, a.name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where gj.posted='1' and da.id_account=$row[0] and date>='$dari' and date<='$sampai'");
							while($row1=mysqli_fetch_row($query1))
							{	
								if($row1[1]==$row1[3])
								{
									$balance+=$row1[0];
									$total+=$balance;
								}
								else
								{
									$balance-=$row1[0];	
									$total-=$balance;
								}
							}
							echo "<tr>";
							echo '<td style="padding-left:25px;">'.$row[1].'</td>';
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo '<td>'.$balance.'</td>';
							echo "</tr>";
						}

						echo '<tr>
							<th style="padding-left:50px;">Gross Profit</th>
							<td></td>
							<td></td>
							<td></td>
							<th>'.$total.'</th>
						</tr>';

						echo '
									<tr class="active">
									<th width=50%>Expenses</th>
									<td width=20%></td>
									<td width=10%></td>
									<td width=10%></td>
									<td width=10%></td>
								</tr>
						';
						$query=mysqli_query($con,"select id, name from account where id_type='6'");
						while($row=mysqli_fetch_row($query))
						{
							$balance1=0;
							//echo "select dc.value,dc.type from detail_account dc join detail_journal dj on dc.ID_DetailJournal=dj.id join general_journal gj on gj.id=dj.id_generaljournal where gj.posted='1' and dc.id_account=$row[0] and date<'$tgl'";
							$query1=mysqli_query($con,"select da.value, da.type, a.name, at.Normal_Balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID where gj.posted='1' and da.id_account=$row[0] and date>='$dari' and date<='$sampai'");

							while($row1=mysqli_fetch_row($query1))
							{	
								if($row1[1]==$row1[3])
								{
									$balance1+=$row1[0];
									$total1+=$balance1;
								}
								else
								{
									$balance1-=$row1[0];	
									$total1-=$balance1;
								}
							}
							echo "<tr>";
							echo '<td style="padding-left:25px;">'.$row[1].'</td>';
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo '<td>'.$balance1.'</td>';
							echo "</tr>";
							
						}
						echo '<tr>
							<th style="padding-left:50px;">Total Expenses</th>
							<td></td>
							<td></td>
							<td></td>
							<th>'.$total1.'</th>
						</tr>';

						$netincome=$total-$total1;
						echo '<tr class="info">
							<th>Net Income</th>
							<td></td>
							<td></td>
							<td></td>
							<th>'.$netincome.'</th>
						</tr>';
						echo "</table>";
					}
				}
			?>
			<!--<table class="table table-responsive">
				<tbody>
					<tr class="active">
						<th width=50%>Revenues</th>
						<td width=20%></td>
						<td width=10%></td>
						<td width=10%></td>
						<td width=10%></td>
					</tr>
					<tr>
						<td style="padding-left:25px;">Net Sales</td>
						<td></td>
						<td></td>
						<td></td>
						<td>Rp. 72000</td>
					</tr>
					<tr>
						<th style="padding-left:50px;">Gross Profit</th>
						<td></td>
						<td></td>
						<td></td>
						<th>Rp. 72000</th>
					</tr>
					<tr class="active">
						<th>Expenses</th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style="padding-left:25px;">Expenses 1</td>
						<td></td>
						<td></td>
						<td>Rp. 2000</td>
						<td></td>
					</tr>
					<tr>
						<td style="padding-left:25px;">Expenses 2</td>
						<td></td>
						<td></td>
						<td>Rp. 2000</td>
						<td></td>
					</tr>
					<tr>
						<td style="padding-left:25px;">Expenses 3</td>
						<td></td>
						<td></td>
						<td>Rp. 2000</td>
						<td></td>
					</tr>
					<tr>
						<th style="padding-left:50px;">Total Expenses</th>
						<td></td>
						<td></td>
						<td></td>
						<th>Rp. (6000)</th>
					</tr>
					<tr class="info">
						<th>Net Income</th>
						<td></td>
						<td></td>
						<td></td>
						<th>Rp. 66000</th>
					</tr>
				-->
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
<?php
include ("connect.php");
if(isset($_GET['id'])){
	$id_=$_GET['id'];
}
else{
	header("location:acc.php");
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>General Ledger</title>

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
			</div>
		</nav>

	<div class="container">
	<h3 style="text-align:center">General Ledger</h3>
	<h5 style="text-align:center"><?php $query=mysqli_query($con,"select name from account where id=$id_"); $row = mysqli_fetch_row($query); echo $row[0];?></h5>
	<h6 style="text-align:center"><?php echo $id_ ?></h6>
	<br>
	<table class="table table-hover">
		<thead>
		<tr>
			<th width="10%">Date</th>
			<th width="20%">Description</th>
			<th width="10%">Ref</th>
			<th width="20%">Debit</th>
			<th width="20%">Credit</th>
			<th width="20%">Balance</th>
		</tr>

	<?php
	$query=mysqli_query($con,"SELECT gj.date, dj.Description, gj.id, da.type, da.Value, at.normal_balance FROM account a join account_type at on a.ID_Type = at.ID join detail_account da on a.id = da.ID_Account join detail_journal dj on da.ID_DetailJournal = dj.ID join general_journal gj on dj.ID_GeneralJournal = gj.ID
 where a.id = $id_ ");
	$balance=0;
	$total=0;
	while($row=mysqli_fetch_array($query))
	{
		echo "<tbody>";
		echo "<tr>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			if($row[3] == 0){ 
				echo "<td>".$row[4]."</td>";
				echo "<td></td>";
			}
			else{
				echo "<td></td>";
				echo "<td>".$row[4]."</td>";
			}
			if($row[5]==$row[3]){
				$balance += $row[4];
				echo "<td>".$balance."</td>";
			}
			else
			{
				$balance -= $row[4];
				echo "<td>".$balance."</td>";
			}
			$total = $total + $balance;

		echo "</tr>";		
	}
		echo "<tr class='info'><td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>Total</td>";
		echo "<td>".$total."</td></tr>";
		echo "</tbody>";
?>
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
</body>
</html>
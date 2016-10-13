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
			<h2>Manage General Journal</h2>
		</div>
		<div class="container">
			<form action="addgeneraljournal.php" method="post" class="form-inline">
				<div class="form-group">
					<input type="text" class="form-control" id="idjournal" placeholder="ID Journal" name="id">
				</div>
				<div class="form-group">
					<input type="date" class="form-control" name="date">
				</div>
				<a href="#" style="color:black"><button type="submit" class="btn btn-success" name="add">
					<i class='fui-plus' aria-hidden='true'></i><span> General Journal</span></button></a>
			</form>
			<?php
				if(isset($_GET['success'])){
					if($_GET['success'] == 0){
						echo'
						<div class="alert alert-danger alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Add Journal has
  							<strong> Failed!</strong>
						</div>';
					}
					elseif ($_GET['success'] == 1) {
						echo'
						<div class="alert alert-danger alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Delete Journal has
  							<strong> Failed!</strong>
						</div>';
					}
					elseif ($_GET['success'] == 2) {
						echo'
						<div class="alert alert-danger alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Post Journal has
  							<strong> Failed!</strong>
						</div>';
					}
					elseif ($_GET['success'] == 3) {
						echo'
						<div class="alert alert-danger alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Can\'t</strong> post an empty journal!
						</div>';
					}
					elseif ($_GET['success'] == 4) {
						echo'
						<div class="alert alert-success alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Journal Added!</strong></div>';
					}
					elseif ($_GET['success'] == 5) {
						echo'
						<div class="alert alert-success alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Journal Posted!</strong></div>';
					}
					elseif ($_GET['success'] == 6) {
						echo'
						<div class="alert alert-success alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Journal Edited!</strong></div>';
					}
				}
			?>
			<div class="table-responsive">
				<table class ="table table-hover">
					<thead>
						<tr>
							<th width="20%">ID</th>
							<th width="20%">Date</th>
							<th width="20%">Posted</th>
							<th width="40%">Action</th>
						</tr>
					</thead>
					<?php
						include("connect.php");
						$query=mysqli_query($con,"select * from general_journal order by date"); 
						echo"<tbody>";
						while($row=mysqli_fetch_array($query))
						{
							echo"<tr>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>";
							if($row[2] == 1){
								echo "
								<span class='label label-success'>Posted</span>
								</td>
								<td>
									<a href='viewjournal.php?id=".$row[0]."'>
										<button type='button' class='btn btn-info'>
											<i class='fui-search' aria-hidden='true'></i>
											<span>View</span>
										</button>
									</a>";
							}
							else{
								echo "<span class='label label-default'>Not Posted</span>";
								echo "</td>
								<td>
									<a href='addjournal-form.php?id=".$row[0]."'>
										<button type='button' class='btn btn-success'>
											<i class='fui-plus' aria-hidden='true'></i>
											<span>Add</span>
										</button>
									</a>
									<a href='editjournal-form.php?id=".$row[0]."'>
										<button type='button' class='btn btn-warning'>
											<i class='fui-new' aria-hidden='true'></i>
											<span>Edit</span>
										</button>
									</a>
									<a href='deletejournal.php?id=".$row[0]."'>
										<button type='button' class='btn btn-danger'>
											<i class='fui-cross' aria-hidden='true'></i>
											<span>Delete</span>
										</button>
									</a>
									<a href='viewjournal.php?id=".$row[0]."'>
										<button type='button' class='btn btn-info'>
											<i class='fui-search' aria-hidden='true'></i>
											<span>View</span>
										</button>
									</a>
									<a href='postjournal.php?id=".$row[0]."'>
										<button type='button' class='btn btn-primary'>
											<i class='fui-check' aria-hidden='true'></i>
											<span>Post</span>
										</button>
									</a>";
							}
							echo "
								</td>
							</tr>";
						}
						echo "</tbody>";
					?>
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
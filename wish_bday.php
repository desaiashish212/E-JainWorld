<?php session_start();
if(isset($_SESSION["id"]) and isset($_SESSION["user"]))
{
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<!--Google graph chart js initialization-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<title>Dhangar Mahasabha</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	<div class="brand clearfix">
		<a href="index.php" class="logo"><img src="img/logo.jpg" class="img-responsive" alt=""></a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="change_password.php">Change password</a></li>
					<li><a href="logout.php">Logout</a></li>
					
				</ul>
			</li>
		</ul>
	</div>

	<div class="ts-main-content">
	<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
				
			
								<?include_once ('connection.php');?>
				<li class="open"><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
				<li><a href="#"><i class="fa fa-desktop"></i>Marathi</a>
					<ul>
						<?php
				$sql = mysqli_query($con,"SELECT category.id, category.caregory_name  FROM category where lang_status=1"); 
				
				$i = 0;
				
				while($row=mysqli_fetch_array($sql))
				{
					$category_id=$row['0'];
					?>
					
						
						<!-- news containt-->
					<li><a href="m_news.php?id=<?=$category_id?>&name=<?=$row['1']?>"> <? echo $row['1']; ?></a></li>
						
					<? 
					
					$i++;					
				}
			
				?>
					</ul>
				</li>
				<li><a href="#"><i class="fa fa-desktop"></i>Hindi</a>
					<ul>
						<?php
				$sql = mysqli_query($con,"SELECT category.id, category.caregory_name  FROM category where lang_status=2"); 
				
				$i = 0;
				
				while($row=mysqli_fetch_array($sql))
				{
					$category_id=$row['0'];
					?>
					
						
						<!-- news containt-->
					<li><a href="h_news.php?id=<?=$category_id?>&name=<?=$row['1']?>"> <? echo $row['1']; ?></a></li>
						
					<? 
					
					$i++;					
				}
			
				?>
					</ul>
				</li>
				<li><a href="#"><i class="fa fa-desktop"></i>English</a>
					<ul>
					
						<?php
				$sql = mysqli_query($con,"SELECT category.id, category.caregory_name  FROM category where lang_status=3"); 
				
				$i = 0;
				
				while($row=mysqli_fetch_array($sql))
				{
					$category_id=$row['0'];
					?>
					
						
						<!-- news containt-->
					<li><a href="e_news.php?id=<?=$category_id?>&name=<?=$row['1']?>"> <? echo $row['1']; ?></a></li>
						
					<? 
					
					$i++;					
				}
			
				?>
					</ul>
				</li>
				
				<li><a href="#"><i class="fa fa-desktop"></i>Category</a>
					<ul>
						<li><a href="m_category.php">Marathi</a></li>
						<li><a href="h_category.php">Hindi</a></li>
						<li><a href="e_category.php">English</a></li>
					
					</ul>
				</li>
				<li><a href="users.php"><i class="fa fa-pie-chart"></i> Users</a></li>
				<li ><a href="advertise.php" ><i class="fa fa-pie-chart"></i> Advertise</a></li>
				<li><a href="notifications.php"><i class="fa fa-pie-chart"></i> Notifications</a></li>

				<!-- Account from above -->
				<ul class="ts-profile-nav">
					<li class="ts-account">
						<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
							<li><a href="#">My Account</a></li>
							<li><a href="#">Edit Account</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>

			</ul>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">FOLLOWING USERS HAVE THEIR BIRTHDYS TODAY</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Todays BIRTH DAYS</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Name</th>
											<th>Mobile NO.</th>
											<th>Email ID</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>Mobile NO.</th>
											<th>Email ID</th>
										</tr>
									</tfoot>
									<tbody>
									<?
										$result = mysqli_query($con,"SELECT users.id, users.`name`, users.mobile_no, users.email from users WHERE DATE_FORMAT(users.birth,'%d-%m') = DATE_FORMAT(NOW(),'%d-%m')");	
									while($row = mysqli_fetch_array($result)){		
									?>
										<tr>
									
											<td><?echo $row[1];?></td>
											<td><?echo $row[2];?></td>
											<td><?echo $row[3];?></td>
									
										</tr>
									<?
										}
									?>	
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>
<?php

}
  else
  {
  	$_SESSION["ERROR"]="Invalid Access, Please Login Again";
	header("Location:login.php");
  }
?> 

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
	
	<title>E-Jain World</title>

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
				<li ><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
				<li ><a href="repoter.php"><i class="fa fa-dashboard"></i> Repoter</a></li>
				<li ><a href="m_news.php""><i class="fa fa-desktop"></i> News</a>
					
				</li>
				<li class="open"><a href="m_event.php"><i class="fa fa-desktop"></i> Event</a>
					
				</li>
				
				<li ><a href="m_pravachan.php"><i class="fa fa-desktop"></i> Pravachan</a></li>
				
				<li><a href="ringtone.php"><i class="fa fa-dashboard"></i> Ringtone</a></li>
							
				
				<li><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
				<li ><a href="advertise.php" ><i class="fa fa-briefcase"></i> Advertise</a></li>
				<li><a href="notifications.php"><i class="fa fa-bell"></i> Notifications</a></li>
				<li><a href="feedback.php"><i class="fa fa-envelope"></i> Feedbacks</a></li>
			

				<!-- Account from above -->
				<ul class="ts-profile-nav">
					
					<li class="ts-account">
						<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
				
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>

			</ul>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Add Event</h2>

						
						<div class="panel panel-default">
							<div class="panel-heading">Marathi Event</div>
							<div class="panel-body">
								<form method="POST" class="form-horizontal" method="post" action="m_create_event.php" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-sm-2 control-label">Title *</label>
										<div class="col-sm-10">
											
											<input type="text" placeholder="enter event title here" name="title" id="title" class="form-control mb" required>
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Address *</label>
										<div class="col-sm-10">
											<textarea class="form-control" placeholder="enter event address here" name="address" id="address"  rows="10" required></textarea>
										</div>
									</div>
																	
									<div class="form-group">
										<label class="col-sm-2 control-label">Description *</label>
										<div class="col-sm-10">
											<textarea class="form-control" placeholder="enter event description here" name="disc" id="disc"  rows="10" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Start Date *</label>
										<div class="col-sm-10">
											<input type="date" name="start_date" id="start_date" required/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label">End Date</label>
										<div class="col-sm-10">
											<input type="date" name="end_date" id="end_date" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Start Time</label>
										<div class="col-sm-10">
											<input type="time" name="start_time" id="start_time" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label">End Time</label>
										<div class="col-sm-10">
											<input type="time" name="end_time" id="end_time" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Speeker</label>
										<div class="col-sm-10">
											
											<input type="text" placeholder="enter speeker here" name="spk" id="spk" class="form-control mb" >
											
										</div>
									</div>
											
									<div class="form-group">
										<label class="col-sm-2 control-label">Select Image *</label>
										<div class="col-sm-10">
											<input id="input-43"  type="file" name="files[]" multiple accept="image/*" required>
										</div>
									</div>
								
											
									<div class="hr-dashed"></div>
									<div class="form-group">
										<div class="col-sm-8 col-sm-offset-2">
											<button class="btn btn-primary" type="submit" value="submit">Save news</button>
										</div>
									</div>
								</form>

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

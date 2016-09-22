<?php session_start();
if(isset($_SESSION["id"]) and isset($_SESSION["user"]))
{
	include_once('DbConnect.php');
	$news_id=$_GET['id']; 
	$db = new DbConnect();
	$conn = $db->connect();
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
					<li><a href="#">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>

	<div class="ts-main-content">
		<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
				<li ><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
				<li class="open"><a href="repoter.php"><i class="fa fa-dashboard"></i> Repoter</a></li>
				<li><a href="m_news.php""><i class="fa fa-desktop"></i> News</a>
					
				</li>
				<li><a href="m_event.php"><i class="fa fa-desktop"></i> Event</a>
					
				</li>
				
				<li ><a href="m_pravachan.php"><i class="fa fa-desktop"></i> Pravachan</a></li>
				
				<li><a href="ringtone.php"><i class="fa fa-dashboard"></i> Ringtone</a></li>
							
				
				<li><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
				<li ><a href="advertise.php" ><i class="fa fa-briefcase"></i> Advertise</a></li>
				<li><a href="notifications.php"><i class="fa fa-bell"></i> Notifications</a></li>
				<li><a href="feedback.php"><i class="fa fa-envelope"></i> Feedbacks</a></li>
				<!-- Account from above -->
				<ul class="ts-profile-nav">
					<li><a href="#">Help</a></li>
					<li><a href="#">Settings</a></li>
					<li class="ts-account">
						<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
							<li><a href="#">My Account</a></li>
							<li><a href="#">Edit Account</a></li>
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
					
						<h2 class="page-title">Edit Repoter</h2>

						<?
						$stmt = $conn->prepare("SELECT repoters.username,repoters.`password`,repoters.oragnasation,repoters.avatar FROM repoters WHERE repoters.id = ?");
        $stmt->bind_param("i", $_GET['id']);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($username, $password, $oragnasation,$avatar);
            $stmt->fetch();
          
            $stmt->close();
           
        } 
        ?>

						<div class="panel panel-default">
							<div class="panel-heading">Repoter</div>
							<div class="panel-body">
								<form class="form-horizontal" method="post" action="worker_edit_repoter.php" enctype="multipart/form-data" onSubmit="return validate(this)" >
									<div class="form-group">
										<label class="col-sm-2 control-label">Username</label>
										<div class="col-sm-10">
											
											<input type="text" placeholder="enter username here" name="username" id="username" value="<?php echo $username;?>" class="form-control mb">
											
										</div>
									</div>
								
								<div class="form-group">
										<label class="col-sm-2 control-label">Password</label>
										<div class="col-sm-10">
											
											<input type="password" placeholder="enter password here" name="password" id="password" value="<?php echo $password;?>" class="form-control mb">
											
										</div>
									</div>
									
								<div class="form-group">
										<label class="col-sm-2 control-label">Organasation</label>
										<div class="col-sm-10">
											
											<input type="text" placeholder="enter organasation name here" name="org" id="org" value="<?php echo $oragnasation;?>" class="form-control mb">
											
										</div>
									</div>	
									
					
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Image Url</label>
										<div class="col-sm-10">
											
											<input type="text" placeholder="enter url here" name="url" id="url" value="<?php echo $avatar;?>" class="form-control mb">
											
										</div>
									</div>
									
									
								
									<input type="hidden" name="id" id="id" value="<?= $_GET['id']?>"/>
									
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

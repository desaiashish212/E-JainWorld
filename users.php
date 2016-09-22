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
				<li ><a href="m_event.php"><i class="fa fa-desktop"></i> Event</a>
					
				</li>
				
				<li ><a href="m_pravachan.php"><i class="fa fa-desktop"></i> Pravachan</a></li>
				
				<li ><a href="ringtone.php"><i class="fa fa-dashboard"></i> Ringtone</a></li>
							
				
				<li class="open"><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
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

						<h2 class="page-title">Users</h2>
							<?php
				
				
				if(isset($_SESSION["MSG"]))
				{ ?>
					 <div class="row">
					<div class="clearfix pt pb">
						<div class="col-md-12">
							<em><?php echo $_SESSION['MSG'] ?></em>
						</div>
					</div>
				</div>					
					<?php 
					unset($_SESSION["MSG"]);
				}
					?>
						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
						
							<div class="panel-heading">Users registered with E-Jain World</div>
						
												
													
											
											
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Name</th>
											<th>Mobile Number</th>
											<th >Email</th>
											<th >State</th>
											<th >District</th>
											<th >City</th>
											<th >Created_at</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>Mobile Number</th>
											<th >Email</th>
											<th >State</th>
											<th >District</th>
											<th >City</th>
											<th >Created_at</th>
										</tr>
									</tfoot>
									<tbody>
										<?
				include_once('DbConnect.php');
						$db = new DbConnect();
						$conn = $db->connect();
							//$id = $_GET["id"];
				
				$stmt = $conn->prepare("SELECT users.`name`,users.mobile,users.email,users.state,users.district,users.city,users.created_at FROM users");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
       $stmt->store_result();
       
				
				
				while($row = fetchAssocStatement($stmt))
				{
					
					?>
					
						<tr align="left"> 
						<td > <? echo $row['name']; ?></td>	<!-- Title containt-->
						<td > <? echo $row['mobile']; ?></td>	
						<td > <? echo $row['email']; ?></td>	
						<td > <? echo $row['state']; ?></td>	
						<td > <? echo $row['district']; ?></td>	
						
						<td > <? echo $row['city']; ?></td>	
						
						
						<td > <? echo $row['created_at']; ?></td>	
						
			
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

<?php
function fetchAssocStatement($stmt)
{
    if($stmt->num_rows>0)
    {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if($stmt->fetch())
            return $result;
    }

    return null;
}
?>

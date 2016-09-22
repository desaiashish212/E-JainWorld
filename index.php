<?php session_start();
if(isset($_SESSION["id"]) and isset($_SESSION["user"]))
{
		include_once('DbConnect.php');
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
	<!--Google graph chart js initialization-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
				
		
				<li class="open"><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
				<li ><a href="repoter.php"><i class="fa fa-dashboard"></i> Repoter</a></li>
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
					<li class="ts-account">
						<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
							<li><a href="change_password.php">Change password</a></li>
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

						<h2 class="page-title">Dashboard</h2>
						
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">
												<?
										
															$stmt = $conn->prepare("SELECT COUNT(*) FROM users");
        
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($users);
			$stmt->fetch();
            $stmt->close();
		}									
												
												?>
													<div class="stat-panel-number h1 "><?echo $users;?></div>
													<div class="stat-panel-title text-uppercase">All Users</div>
												</div>
											</div>
											<a href="users.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">
<?
		$stmt = $conn->prepare("select COUNT(*) from users WHERE users.lang='1'");
        
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($marathiCount);
			$stmt->fetch();
            $stmt->close();
		}
	
?>												
													<div class="stat-panel-number h1 "><? echo $marathiCount;?></div>
													<div class="stat-panel-title text-uppercase">Marathi Reader</div>
												</div>
											</div>
											<a href="users.php" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">
<?
		$stmt = $conn->prepare("select COUNT(*) from users WHERE users.lang='2'");
        
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($HindiCount);
			$stmt->fetch();
            $stmt->close();
		}									
?>												
													<div class="stat-panel-number h1 "><?echo $HindiCount;?></div>
													<div class="stat-panel-title text-uppercase">Hindi Reader</div>
												</div>
											</div>
											<a href="users.php" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						

						<div class="row">
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-heading">Monthly New Users</div>
									<div class="panel-body">
										<div class="chart">
										<!--Google graph chart-->
											 <div id="chart_div"></div> 
										</div>
<?

	$stmt = $conn->prepare("Select count(*) as counts, DATE_FORMAT(created_at, \"%Y-%m\") as \"_month\" from users    
group by _month
order by _month DESC
LIMIT 5 ");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
       $stmt->store_result();

	

	$jsonArray = array();
	while($graph_result = fetchAssocStatement($stmt))
	{
		$graphCount =  $graph_result['counts'];
		$graphMonth =  $graph_result['_month'];
		$jsonArray[] =  array($graphCount,$graphMonth);
	}
	
?>	

<script>
	  var graphMonth = parseInt(<?php echo json_encode($jsonArray[0][0]);?>);
	  var graphCount = <?php echo json_encode($jsonArray[0][1]);?>;	
	  
	  console.log("hi"+graphCount);
	  var graphMonth1 = parseInt(<?php echo json_encode($jsonArray[1][0]);?>);	
	  var graphCount1 = <?php echo json_encode($jsonArray[1][1]);?>;	
	  
	  var graphMonth2 = parseInt(<?php echo json_encode($jsonArray[2][0]);?>);	
	  var graphCount2 = <?php echo json_encode($jsonArray[2][1]);?>;	
	  
	  var graphMonth3 = parseInt(<?php echo json_encode($jsonArray[3][0]);?>);	
	  var graphCount3 = <?php echo json_encode($jsonArray[3][1]);?>;	
	  
	  var graphMonth4 = parseInt(<?php echo json_encode($jsonArray[4][0]);?>);	
	  var graphCount4 = <?php echo json_encode($jsonArray[4][1]);?>;	
	  
	 /*
	  var graphMonth5 = <?php echo json_encode($jsonArray[5][0]);?>;	
	  var graphCount5 = <?php echo json_encode($jsonArray[5][1]);?>;	
	  
	  var graphMonth6 = <?php echo json_encode($jsonArray[6][0]);?>;	
	  var graphCount6 = <?php echo json_encode($jsonArray[6][1]);?>;	
	  
	  var graphMonth7 = <?php echo json_encode($jsonArray[7][0]);?>;	
	  var graphCount7 = <?php echo json_encode($jsonArray[7][1]);?>;	
	  
	  var graphMonth8 = <?php echo json_encode($jsonArray[8][0]);?>;	
	  var graphCount8 = <?php echo json_encode($jsonArray[8][1]);?>;	
	  
	  var graphMonth9 = <?php echo json_encode($jsonArray[9][0]);?>;	
	  var graphCount9 = <?php echo json_encode($jsonArray[9][1]);?>;	
	  
	  var graphMonth10 = <?php echo json_encode($jsonArray[10][0]);?>;	
	  var graphCount10 = <?php echo json_encode($jsonArray[10][1]);?>;	
	  
	  var graphMonth11 = <?php echo json_encode($jsonArray[11][0]);?>;	
	  var graphCount11 = <?php echo json_encode($jsonArray[11][1]);?>;
	  
	  */
	  google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
      	
        var data = google.visualization.arrayToDataTable([
         ['months', 'users'],
         [graphCount,graphMonth],
         [graphCount1,graphMonth1],
         [graphCount2,graphMonth2],
         [graphCount3,graphMonth3],
         [graphCount4,graphMonth4],
       /*
         [graphCount5,graphMonth5],
         [graphCount6,graphMonth6],
         [graphCount7,graphMonth7],
         [graphCount8,graphMonth8],
         [graphCount9,graphMonth9],
         [graphCount10,graphMonth10],
         [graphCount11,graphMonth11],
        */ 
        ]);

        var options = {
          chart: {
            title: 'Report of Users added in a year',
            subtitle: '2016',
          },
          bars: 'vertical',
          vAxis: {format: 'decimal'},
          height: 250,
          colors: ['#1b9e77']
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

        var btns = document.getElementById('btn-group');

        btns.onclick = function (e) {

          if (e.target.tagName === 'BUTTON') {
            options.vAxis.format = e.target.id === 'none' ? '' : e.target.id;
            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        }
      }
</script>


										<div id="legendDiv"></div>
									</div>
								</div>
							</div>
							
							<div class="panel panel-default">
									<div class="panel-heading">Latest Users</div>
									<div class="panel-body">
										<div class="row">
									<div class="panel-body">
									<?
											// To display 5 latest users ...
$stmt = $conn->prepare("SELECT
users.`name`,
users.mobile,
users.email
FROM
users
ORDER BY
users.created_at DESC
LIMIT 8");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
       $stmt->store_result();											
										?>
										<table class="table table-hover">
											<thead>
												<tr>
													<td><td>
													<th>Name</th>
													<th>Mobile No.</th>
													<th>Email ID</th>
													
												</tr>
											</thead>
											<tbody>
											<?
												while($row = fetchAssocStatement($stmt)){
											?>
												<tr>
													<th><th>
													<td><?echo $row['name'];?></td>
													<td><?echo $row['mobile'];?></td>
													<td><?echo $row['email'];?></td>
												</tr>
												<?
													}
												?>	
										
											</tbody>
											
										</table>
										<a href="users.php">View all users <i class="fa fa-fw"></i> </a>
								
								</div>
											
										</div>
									</div>
								</div>
							
						</div>
						
						<div class="row">
							<div class="col-md-6">
								
							<div class="panel panel-default">
									<div class="panel-heading">Marathi news pending to aprove</div>
									<div class="panel-body">
										<div class="row">
									<div class="panel-body">
									<?
											// To display 5 latest users ...
$stmt = $conn->prepare("SELECT
users.`name`,
users.mobile,
users.email
FROM
users
ORDER BY
users.created_at DESC
LIMIT 8");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
       $stmt->store_result();											
										?>
										<table class="table table-hover">
											<thead>
												<tr>
													<td><td>
													<th>Name</th>
													<th>Mobile No.</th>
													<th>Email ID</th>
													
												</tr>
											</thead>
											<tbody>
											<?
												while($row = fetchAssocStatement($stmt)){
											?>
												<tr>
													<th><th>
													<td><?echo $row['name'];?></td>
													<td><?echo $row['mobile'];?></td>
													<td><?echo $row['email'];?></td>
												</tr>
												<?
													}
												?>	
										
											</tbody>
											
										</table>
										<a href="users.php">View all users <i class="fa fa-fw"></i> </a>
								
								</div>
											
										</div>
									</div>
								</div>	
								
								
								
							</div>
							<div class="row">
							<div class="col-md-6">
								
							<div class="panel panel-default">
									<div class="panel-heading">Hindi news pending to aprove</div>
									<div class="panel-body">
										<div class="row">
									<div class="panel-body">
									<?
											// To display 5 latest users ...
$stmt = $conn->prepare("SELECT
users.`name`,
users.mobile,
users.email
FROM
users
ORDER BY
users.created_at DESC
LIMIT 8");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
       $stmt->store_result();											
										?>
										<table class="table table-hover">
											<thead>
												<tr>
													<td><td>
													<th>Name</th>
													<th>Mobile No.</th>
													<th>Email ID</th>
													
												</tr>
											</thead>
											<tbody>
											<?
												while($row = fetchAssocStatement($stmt)){
											?>
												<tr>
													<th><th>
													<td><?echo $row['name'];?></td>
													<td><?echo $row['mobile'];?></td>
													<td><?echo $row['email'];?></td>
												</tr>
												<?
													}
												?>	
										
											</tbody>
											
										</table>
										<a href="users.php">View all users <i class="fa fa-fw"></i> </a>
								
								</div>
											
										</div>
									</div>
								</div>	
								
								
								
							</div>
							
							
			<!--
				#################################################################
			-->
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">
												<?
													// Counting number of users in the system	
													$stmt = $conn->prepare("SELECT (SELECT COUNT(*)FROM marathi_news)+(SELECT COUNT(*)from h_news) as totalnews");
        
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($Count);
			$stmt->fetch();
            $stmt->close();
		}									
													
												
												?>
													<div class="stat-panel-number h1 "><?echo $Count;?></div>
													<div class="stat-panel-title text-uppercase">Total news</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">
<?
		$stmt = $conn->prepare("SELECT COUNT(*) from marathi_news");
        
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($marathiCount);
			$stmt->fetch();
            $stmt->close();
		}									
?>												
													<div class="stat-panel-number h1 "><? echo $marathiCount;?></div>
													<div class="stat-panel-title text-uppercase">Marathi News</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">
<?
		$stmt = $conn->prepare("SELECT COUNT(*) from h_news");
        
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($marathiCount);
			$stmt->fetch();
            $stmt->close();
		}
?>												
													<div class="stat-panel-number h1 "><?echo $marathiCount; ?></div>
													<div class="stat-panel-title text-uppercase">Hindi News</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
			<!--
				#################################################################
			-->
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

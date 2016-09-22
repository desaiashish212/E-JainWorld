<?php session_start();
	$conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	$root_folder = "uploads/event/";
	$date=date("Y-m-d");	
	echo "#Running upload script...<br>";
	echo $repoter_id = $_SESSION["id"];
	if(isset($_FILES['files']))
	{
		chdir($root_folder);
		if(!file_exists($date))
		{
			 mkdir($date);
			 $root_folder = $root_folder.$date.'/';
			 echo $root_folder;
			 chdir($date);
			 //exit();
			 $errors= array();
			  $count=0;
			  
			 foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
			 {
			 	$file_name = $key.$_FILES['files']['name'][$key];
			 	echo $file_name.'<br>';
			 	$file_size =$_FILES['files']['size'][$key];
				$file_tmp =$_FILES['files']['tmp_name'][$key];
				$file_type=$_FILES['files']['type'][$key];	
				
	       	 	if(is_dir($root_folder.$file_name)==false){
	                move_uploaded_file($file_tmp,$file_name);
	                $path =$root_folder.$file_name;
	                
	                $title=(isset($_POST['title']) ? $_POST['title'] : null);
	                $address=(isset($_POST['address']) ? $_POST['address'] : null);
					$disc=(isset($_POST['disc']) ? $_POST['disc'] : null);
					$start_date=(isset($_POST['start_date']) ? $_POST['start_date'] : null);
					$end_date=(isset($_POST['end_date']) ? $_POST['end_date'] : null);
	                $start_time=(isset($_POST['start_time']) ? $_POST['start_time'] : null);
					$end_time=(isset($_POST['end_time']) ? $_POST['end_time'] : null);
					$spk=(isset($_POST['spk']) ? $_POST['spk'] : null);
					
					
					date_default_timezone_set("Asia/Kolkata");
					$server_time=date("h:i:s");
					
					if($count === 0)
					{
						$stmt = $conn->prepare("insert into m_event (title,image,startDate,endDate,startTime,endTime,address,discription,speeker,repoter_id) values (?,?,?,?,?,?,?,?,?,?)");
						$stmt->bind_param("sssssssssi", $title, $path, $start_date,$end_date,$start_time,$end_time,$address,$disc,$spk,$repoter_id);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
	
						
						$count++; 	// on next iteration execute else
						
					}else{
						
						$stmt = $conn->prepare("update m_event SET image='$path' WHERE m_event.title=?");
						$stmt->bind_param("s", $title);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
					}
					
					   	$_SESSION["MSG"]="Event not added, Try Again";
						header("Location: m_event.php");	
				     
	            }else{
						$_SESSION["MSG"]="event not added, Try Again";
						header("Location: m_event.php");	
				}	
			 }//EOF foreach
		}
		else
		{
			 $root_folder = $root_folder.$date.'/';
			 echo $root_folder;
			 chdir($date);
			 //exit();
			 $errors= array();
			  $count=0;
			  
			 foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
			 {
			 	$file_name = $key.$_FILES['files']['name'][$key];
			 	echo $file_name.'<br>';
			 	$file_size =$_FILES['files']['size'][$key];
				$file_tmp =$_FILES['files']['tmp_name'][$key];
				$file_type=$_FILES['files']['type'][$key];	
				
	       	 	if(is_dir($root_folder.$file_name)==false)
	       	 	{
	                move_uploaded_file($file_tmp,$file_name);
	                 $path =$root_folder.$file_name;
	                
	                 $title=(isset($_POST['title']) ? $_POST['title'] : null);
	                 $address=(isset($_POST['address']) ? $_POST['address'] : null);
					 $disc=(isset($_POST['disc']) ? $_POST['disc'] : null);
					 $start_date=(isset($_POST['start_date']) ? $_POST['start_date'] : null);
					 $end_date=(isset($_POST['end_date']) ? $_POST['end_date'] : null);
	                 $start_time=(isset($_POST['start_time']) ? $_POST['start_time'] : null);
					 $end_time=(isset($_POST['end_time']) ? $_POST['end_time'] : null);
					 $spk=(isset($_POST['spk']) ? $_POST['spk'] : null);
					
					
					date_default_timezone_set("Asia/Kolkata");
					$server_time=date("h:i:s");
					
					if($count === 0)
					{
						$stmt = $conn->prepare("insert into m_event (title,image,startDate,endDate,startTime,endTime,address,discription,speeker,repoter_id) values (?,?,?,?,?,?,?,?,?,?)");
						$stmt->bind_param("sssssssssi", $title, $path, $start_date,$end_date,$start_time,$end_time,$address,$disc,$spk,$repoter_id);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
						$count++; 	// on next iteration execute else
						
					}else{
						$stmt = $conn->prepare("update m_event SET image='$path' WHERE m_event.title=?");
						$stmt->bind_param("s", $title);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
					}
					
					   	$_SESSION["MSG"]="Event added successfully.";
						header("Location: m_event.php");	
				     
	            }else{
						$_SESSION["MSG"]="Event not added, Try Again";
						header("Location: m_event.php");	
				}	
			 }//EOF foreach
		}	 
	}	 
 ?>
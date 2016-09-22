<?php session_start();
	$conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	$root_folder = "pravachan/";
	$date=date("Y-m-d");	
	echo "#Running upload script...<br>";
	$repoter_id = $_SESSION["id"];
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
	                
	                $mtitle=(isset($_POST['mtitle']) ? $_POST['mtitle'] : null);
				//	$htitle=(isset($_POST['htitle']) ? $_POST['htitle'] : null);
	                
					exit;
					
					date_default_timezone_set("Asia/Kolkata");
					$server_time=date("h:i:s");
					
					if($count === 0)
					{
						$stmt = $conn->prepare("insert into m_pravachan (mtitle,url) values (?,?)");
						$stmt->bind_param("ss", $mtitle,$path);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
	
						
						$count++; 	// on next iteration execute else
						
					}
					
					   	$_SESSION["MSG"]="Pravachan not added, Try Again";
						header("Location: m_pravachan.php");	
				     
	            }else{
						$_SESSION["MSG"]="Pravachan not added, Try Again";
						header("Location: m_pravachan.php");	
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
	                
	                $mtitle=(isset($_POST['mtitle']) ? $_POST['mtitle'] : null);
					//$htitle=(isset($_POST['htitle']) ? $_POST['htitle'] : null);
	                
					
					
					date_default_timezone_set("Asia/Kolkata");
					$server_time=date("h:i:s");
					
					if($count === 0)
					{
						$stmt = $conn->prepare("insert into m_pravachan (mtitle,url) values (?,?)");
						$stmt->bind_param("ss", $mtitle,$path);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
						
						$count++; 	// on next iteration execute else
						
					}
					
					   	$_SESSION["MSG"]="Pravachan added successfully.";
						header("Location: m_pravachan.php");	
				     
	            }else{
						$_SESSION["MSG"]="Pravachan not added, Try Again";
						header("Location: m_pravachan.php");	
				}	
			 }//EOF foreach
		}	 
	}	 
 ?>
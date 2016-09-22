<?php session_start();
	$conn;
	include_once('DbConnect.php');
	$db = new DbConnect();
    $conn = $db->connect();
	$root_folder = "uploads/";
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
				$path="";
	       	 	if(is_dir($root_folder.$file_name)==false){
	       	 		
	                move_uploaded_file($file_tmp,$file_name);
	                $path =$root_folder.$file_name;
	                
	                $title=(isset($_POST['title']) ? $_POST['title'] : null);
	                $news=(isset($_POST['news']) ? $_POST['news'] : null);
					$newsDate=(isset($_POST['date']) ? $_POST['date'] : null);
					$url=(isset($_POST['url']) ? $_POST['url'] : null);
					
					
					date_default_timezone_set("Asia/Kolkata");
					$server_time=date("h:i:s");
					
					if($count === 0)
					{
						$stmt = $conn->prepare("insert into marathi_news (title,discription,url,image,repoter_id) values (?,?,?,?,?)");
						$stmt->bind_param("ssssi", $title, $news, $url,$path,$repoter_id);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
	
						
						$count++; 	// on next iteration execute else
						
					}else{
						
						$stmt = $conn->prepare("update marathi_news SET image1='$path' WHERE marathi_news.title=?");
						$stmt->bind_param("s", $title);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
					}
					
					   	$_SESSION["MSG"]="News not added, Try Again";
						header("Location: m_news.php");	
				     
	            }else{
						$_SESSION["MSG"]="News not added, Try Again";
						header("Location: m_news.php");	
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
	                $news=(isset($_POST['news']) ? $_POST['news'] : null);
					$newsDate=(isset($_POST['date']) ? $_POST['date'] : null);
					$url=(isset($_POST['url']) ? $_POST['url'] : null);
					
					if($file_name==0)
						$path = "";
					
					date_default_timezone_set("Asia/Kolkata");
					$server_time=date("h:i:s");
					
					if($count === 0)
					{
						$stmt = $conn->prepare("insert into marathi_news (title,discription,url,image,repoter_id,date) values (?,?,?,?,?,?)");
						$stmt->bind_param("ssssis", $title, $news, $url,$path,$repoter_id,$date);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
						
						
						$count++; 	// on next iteration execute else
						
					}else{
						$stmt = $conn->prepare("update marathi_news SET image1='$path' WHERE marathi_news.title=?");
						$stmt->bind_param("s", $title);
						$stmt->execute();
						$num_affected_rows = $stmt->affected_rows;
						$stmt->close();
					}
					
					   	$_SESSION["MSG"]="News added successfully.";
						header("Location: m_news.php");	
				     
	            }else{
						$_SESSION["MSG"]="News not added, Try Again";
						header("Location: m_news.php");	
				}	
			 }//EOF foreach
		}	 
	}	 
 ?>
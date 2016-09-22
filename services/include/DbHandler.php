<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ashish Desai
 */
 
 include('sendSms.php');
 include('gcm.php');
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

	
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
}
    /* ------------- `users` table method ------------------ */

    /**
     * Creating new user
     * @param String $name User full name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function createUser($name, $mobile, $gcmid) {
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($mobile,$gcmid)) {
           
            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users(name,mobile) values(?,?)");
            $stmt->bind_param("ss",$name, $mobile);

            $result = $stmt->execute();
            $stmt->close();

            // Check for successful insertion
            if ($result) {
				
				$user_id = $this->conn->insert_id;
					$res = $this->createUserGcmApi($user_id, $gcmid,$api_key);
					if ($res) {
							$otp = rand(100000, 999999);
							$res = $this->createUserOTP($user_id, $otp);
							if ($res) {
								//sendSms($mobile, $otp);
								 // User successfully inserted
								return USER_CREATED_SUCCESSFULLY;
							} else {   
								// User failed to inserted
								return USER_FAILED_TO_OTP;
							}
					} else {
						// task failed to create
						return USER_FAILED_TO_GCM_API;
					}
               
                
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
			
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }
	
	private function isUserExists($mobile,$gcmid) {
  
        $stmt = $this->conn->prepare("SELECT id from users WHERE mobile = ?");
        $stmt->bind_param("s", $mobile);
  
		
		if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($user_id);
			$stmt->fetch();
            $stmt->close();
			//echo 'userId:'.$user_id;
			$otp = rand(100000, 999999);
			$res = $this->updateUserOtpGcmid($user_id,$otp, $gcmid);
			if ($res> 0) {
								 // User successfully Updated
			//	echo 'update otp gcm';		
				//sendSms($mobile, $otp);				
				return true;
			} else {   
				// User failed to Update
		//		echo 'fail to update otp gcm';
				return false;
			}
			
        } else {
		//	echo 'user is not present';
            return false;
        }
        
    }
	
	public function updateUserOtpGcmid($user_id, $otp, $gcmid) {
		
        $stmt = $this->conn->prepare("UPDATE user_api_gcm, sms_code SET user_api_gcm.gcmId = ?,sms_code.otp = ? WHERE user_api_gcm.userId = sms_code.userId AND user_api_gcm.userId = ?");
        $stmt->bind_param("sii", $gcmid, $otp, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
	//	echo $num_affected_rows;
        return $num_affected_rows > 0;
    }
	
	public function createUserOtp($user_id, $otp) {
        $stmt = $this->conn->prepare("INSERT INTO sms_code(userId, otp) values(?, ?)");
        $stmt->bind_param("ii", $user_id, $otp);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }
	
	public function createUserGcmApi($user_id, $gcmid,$api_key) {
        $stmt = $this->conn->prepare("INSERT INTO user_api_gcm(userId,apiKey, gcmId) values(?, ?,?)");
        $stmt->bind_param("iss", $user_id, $api_key,$gcmid);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }
	
	public function updateLang($user_id,$lang) {
		
	    $stmt = $this->conn->prepare("UPDATE users set lang = ? WHERE id = ?");
        $stmt->bind_param("ii", $lang,$user_id); 
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
        
    }
	
	public function getNews() {
		//$date = date("Y-m-d");
        $stmt = $this->conn->prepare("SELECT marathi_news.id,marathi_news.title,marathi_news.discription,marathi_news.url,marathi_news.image,marathi_news.image1,marathi_news.date,repoters.oragnasation,repoters.avatar FROM marathi_news INNER JOIN repoters ON marathi_news.repoter_id = repoters.id WHERE repoters.`status` = 1 and marathi_news.`status` = 1  ");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		$response = array();
         while ($news=  $this->fetchAssocStatement($stmt)) {
                $tmp = array();
                $tmp["id"] = $news["id"];
                $tmp["title"] = $news["title"];
				 $tmp["discription"] = $news["discription"];
				  $tmp["url"] = $news["url"];
				  
				   $tmp["image"] = $news["image"];
				   $tmp["image1"] = $news["image1"];
				   $tmp["date"] = $news["date"];
				   $tmp["oragnasation"] = $news["oragnasation"];
				   $tmp["avatar"] = $news["avatar"];
                array_push($response, $tmp);
            }
        $stmt->close();
		
		$stmt = $this->conn->prepare("SELECT marathi_news.id,marathi_news.title,marathi_news.discription,marathi_news.url,marathi_news.image, marathi_news.image1, marathi_news.date,users.`name`
FROM users INNER JOIN marathi_news ON users.id = marathi_news.user_id
WHERE marathi_news.`status` = 1");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		
         while ($news=  $this->fetchAssocStatement($stmt)) {
                $tmp = array();
                $tmp["id"] = $news["id"];
                $tmp["title"] = $news["title"];
				 $tmp["discription"] = $news["discription"];
				  $tmp["url"] = $news["url"];
				  
				   $tmp["image"] = $news["image"];
				   $tmp["image1"] = $news["image1"];
				   $tmp["date"] = $news["date"];
				   $tmp["oragnasation"] = $news["name"];
				   $tmp["avatar"] = "";
                array_push($response, $tmp);
            }
        $stmt->close();
		
        return $response;
    }
	
	public function getEvent() {
		//$date = date("Y-m-d");
        $stmt = $this->conn->prepare("SELECT m_event.id,m_event.title,m_event.image,m_event.startDate,m_event.endDate,m_event.startTime,m_event.endTime,m_event.address,m_event.discription,m_event.speeker FROM m_event WHERE m_event.`status` = 1");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		$response = array();
         while ($news=  $this->fetchAssocStatement($stmt)) {
                $tmp = array();
                $tmp["id"] = $news["id"];
                $tmp["title"] = $news["title"];
				 $tmp["image"] = $news["image"];
				  $tmp["startDate"] = $news["startDate"];
				  
				   $tmp["endDate"] = $news["endDate"];
				   $tmp["startTime"] = $news["startTime"];
				   $tmp["endTime"] = $news["endTime"];
				   
				   $tmp["address"] = $news["address"];
				   $tmp["discription"] = $news["discription"];
				   $tmp["speeker"] = $news["speeker"];
                array_push($response, $tmp);
            }
        $stmt->close();
        return $response;
    }
	
	public function getPrvchan($start,$limit) {
		//$date = date("Y-m-d");
        $stmt = $this->conn->prepare("SELECT m_pravachan.id,m_pravachan.mtitle,m_pravachan.htitle,m_pravachan.url FROM m_pravachan limit $start, $limit");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		$response = array();
         while ($news=  $this->fetchAssocStatement($stmt)) {
                $tmp = array();
                $tmp["id"] = $news["id"];
                $tmp["title"] = $news["mtitle"];
				$tmp["title"] = $news["htitle"];
				 $tmp["url"] = $news["url"];
				  
                array_push($response, $tmp);
            }
        $stmt->close();
        return $response;
    }
	
	public function getRingtone($start,$limit) {
		//$date = date("Y-m-d");
        $stmt = $this->conn->prepare("SELECT ringtone.id,ringtone.mtitle,ringtone.htitle,ringtone.url FROM ringtone limit $start, $limit");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		$response = array();
         while ($news=  $this->fetchAssocStatement($stmt)) {
                $tmp = array();
                $tmp["id"] = $news["id"];
                $tmp["title"] = $news["mtitle"];
				$tmp["title"] = $news["htitle"];
				 $tmp["url"] = $news["url"];
				  
                array_push($response, $tmp);
            }
        $stmt->close();
        return $response;
    }
	
	public function userNews($user_id, $title, $url, $disc, $image, $fileName) {
		$imagePath = "";
		if($image!=null && $fileName != null){
				
			$imagePath = "uploads/user/$fileName.png";
			$path = "../uploads/user/$fileName.png";
			file_put_contents($path,base64_decode($image));
		}
		
		
        $stmt = $this->conn->prepare("INSERT INTO marathi_news(title,discription, url,image,user_id) values(?,?,?,?,?)");
        $stmt->bind_param("ssssi", $title, $disc,$url,$imagePath,$user_id);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }
	
	public function userEvent($user_id, $title, $address, $disc,$startDate,$endDate,$startTime,$endTime, $image, $fileName) {
		$imagePath = "";
		if($image!=null && $fileName != null){
				
			$imagePath = "uploads/user/$fileName.png";
			$path = "../uploads/user/$fileName.png";
			file_put_contents($path,base64_decode($image));
		}
		
		
        $stmt = $this->conn->prepare("INSERT INTO m_event(title,image,startDate,endDate,startTime,endTime,address, discription,userId) values(?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssi", $title,$imagePath, $startDate,$endDate,$startTime,$endTime,$address,$disc,$user_id);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }
	
	
	public function getAdds() {
		//$date = date("Y-m-d");
        $stmt = $this->conn->prepare("SELECT advertise.id,advertise.title,advertise.path,advertise.`status` FROM advertise");
       // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
		$response = array();
         while ($adds=  $this->fetchAssocStatement($stmt)) {
                $tmp = array();
                $tmp["id"] = $adds["id"];
                $tmp["title"] = $adds["title"];
				$tmp["url"] = $adds["path"];
				 $tmp["status"] = $adds["status"];
				  
                array_push($response, $tmp);
            }
        $stmt->close();
        return $response;
    }
	
	public function userFeedback($user_id, $title, $disc) {
		
        $stmt = $this->conn->prepare("INSERT INTO feedback(uId,title, disc) values(?,?,?)");
        $stmt->bind_param("iss", $user_id, $title,$disc);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }
	
/************************************************************************************************************************/	
	

    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    public function checkLogin($mobile, $otp) {
        // fetching user by email
        $stmt = $this->conn->prepare("SELECT users.id FROM users INNER JOIN sms_code ON users.id = sms_code.userId WHERE users.mobile = ? AND sms_code.otp = ? ");

        $stmt->bind_param("si", $mobile,$otp);

        $stmt->execute();

        $stmt->bind_result($id);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Found user with the mobile
             $stmt->close();
             return TRUE;
           
        } else {
            $stmt->close();

            // user not existed with the email
            return FALSE;
        }
    }
	
	public function getUserByMobile($mobile) {
        $stmt = $this->conn->prepare("SELECT users.`name`,users.email,users.state,users.district,users.city,users.`status`,user_api_gcm.apiKey FROM users INNER JOIN user_api_gcm ON users.id = user_api_gcm.userId WHERE users.mobile = ?");
        $stmt->bind_param("s", $mobile);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($name, $email, $state,$district ,$city,$status,$api_key);
            $stmt->fetch();
            $user = array();
            $user["name"] = $name;
            $user["email"] = $email;
            $user["state"] = $state;
			$user["district"] = $district;
			$user["city"] = $city;
            $user["status"] = $status;
			$user["api_key"] = $api_key;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
	
	public function createProfile($user_id,$name,$email,$dob,$state,$district,$city) {
		$status =1;
	    $stmt = $this->conn->prepare("UPDATE users set name = ? , email = ?,dob = ?, state = ? , district = ?,city = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssii", $name,$email,$dob,$state,$district,$city,$status,$user_id); 
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
        
    }

   
    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT name, email, api_key, status, created_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($name, $email, $api_key, $status, $created_at);
            $stmt->fetch();
            $user = array();
            $user["name"] = $name;
            $user["email"] = $email;
            $user["api_key"] = $api_key;
            $user["status"] = $status;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($user_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT userId FROM user_api_gcm WHERE apiKey = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT userId from user_api_gcm WHERE apiKey = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    /* ------------- `tasks` table method ------------------ */

    /**
     * Creating new task
     * @param String $user_id user id to whom task belongs to
     * @param String $task task text
     */
    public function createTask($user_id, $task) {
        $stmt = $this->conn->prepare("INSERT INTO tasks(task) VALUES(?)");
        $stmt->bind_param("s", $task);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            // task row created
            // now assign the task to user
            $new_task_id = $this->conn->insert_id;
            $res = $this->createUserTask($user_id, $new_task_id);
            if ($res) {
                // task created successfully
                return $new_task_id;
            } else {
                // task failed to create
                return NULL;
            }
        } else {
            // task failed to create
            return NULL;
        }
    }

    /**
     * Fetching single task
     * @param String $task_id id of the task
     */
    public function getTask($task_id, $user_id) {
        $stmt = $this->conn->prepare("SELECT t.id, t.task, t.status, t.created_at from tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($id, $task, $status, $created_at);
            // TODO
            // $task = $stmt->get_result()->fetch_assoc();
            $stmt->fetch();
            $res["id"] = $id;
            $res["task"] = $task;
            $res["status"] = $status;
            $res["created_at"] = $created_at;
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching all user tasks
     * @param String $user_id id of the user
     */
    public function getAllUserTasks($user_id) {
        $stmt = $this->conn->prepare("SELECT t.* FROM tasks t, user_tasks ut WHERE t.id = ut.task_id AND ut.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**
     * Updating task
     * @param String $task_id id of the task
     * @param String $task task text
     * @param String $status task status
     */
    public function updateTask($user_id, $task_id, $task, $status) {
        $stmt = $this->conn->prepare("UPDATE tasks t, user_tasks ut set t.task = ?, t.status = ? WHERE t.id = ? AND t.id = ut.task_id AND ut.user_id = ?");
        $stmt->bind_param("siii", $task, $status, $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /**
     * Deleting a task
     * @param String $task_id id of the task to delete
     */
    public function deleteTask($user_id, $task_id) {
        $stmt = $this->conn->prepare("DELETE t FROM tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /* ------------- `user_tasks` table method ------------------ */

    /**
     * Function to assign a task to user
     * @param String $user_id id of the user
     * @param String $task_id id of the task
     */
    public function createUserTask($user_id, $task_id) {
        $stmt = $this->conn->prepare("INSERT INTO user_tasks(user_id, task_id) values(?, ?)");
        $stmt->bind_param("ii", $user_id, $task_id);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }

}

?>

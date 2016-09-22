<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['authorization'])) {
        $db = new DbHandler();

        // get the api key
        $api_key = $headers['authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $db->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * ----------- METHODS WITHOUT AUTHENTICATION ---------------------------------
 */
/**
 * User Registration
 * url - /register
 * method - POST
 * params - name, email, password
 */
$app->post('/register', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('name', 'mobile', 'gcmid'));

            $response = array();

            // reading post params
            $name = $app->request->post('name');
            $mobile = $app->request->post('mobile');
            $gcmid = $app->request->post('gcmid');

            // validating email address
           // validateEmail($email);

            $db = new DbHandler();
            $res = $db->createUser($name, $mobile, $gcmid);

            if ($res == USER_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully registered";
            } else if ($res == USER_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["error"] = false;
                $response["message"] = "SMS request is initiated! You will be receiving it shortly.";
            }
            // echo json response
            echoRespnse(201, $response);
        });

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('mobile', 'otp'));

            // reading post params
            $mobile = $app->request()->post('mobile');
            $otp = $app->request()->post('otp');
            $response = array();

            $db = new DbHandler();
            // check for correct email and password
            if ($db->checkLogin($mobile, $otp)) {
                // get the user by email
                $user = $db->getUserByMobile($mobile);

                if ($user != NULL) {
                   
                    $response['name'] = $user['name'];
					$response['email'] = $user['email'];
					$response['state'] = $user['state'];
					$response['district'] = $user['district'];
					$response['city'] = $user['city'];
					$response['status'] = $user['status'];
                    $response['apiKey'] = $user['api_key'];
					$response["error"] = false;
					$response["message"] = "Verify successfully.";
                } else {
                    // unknown error occurred
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                }
            } else {
                // user credentials are wrong
                $response['error'] = true;
                $response['message'] = 'Login failed. Incorrect OTP';
            }

            echoRespnse(200, $response);
        });

/*
 * ------------------------ METHODS WITH AUTHENTICATION ------------------------
 */
$app->post('/profile', 'authenticate', function() use ($app) {
			global $user_id;
            // check for required params
            verifyRequiredParams(array('name','email','dob','state','district','city'));

            $response = array();
            $name = $app->request->post('name');
			$email = $app->request->post('email');
			$dob = $app->request->post('dob');
			$state = $app->request->post('state');
			$district = $app->request->post('district');
			$city = $app->request->post('city');

            $db = new DbHandler();

            // creating new task
            $res = $db->createProfile($user_id,$name,$email,$dob,$state,$district,$city);

            if ($res) {
				$response["error"] = false;
                $response["message"] = "Profile updated successfully";
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to update profile. Please try again";
                echoRespnse(200, $response);
            }            
        });
/**
 * Updating existing task
 * method PUT
 * url - /lang/:id
 */
$app->put('/lang/:id', 'authenticate', function($lang) use($app) {
            // check for required params
      
            global $user_id;            
            
            $db = new DbHandler();
            $response = array();

            // updating task
            $result = $db->updateLang($user_id, $lang);
            if ($result) {
                // task updated successfully
                $response["error"] = false;
                $response["message"] = "language updated successfully";
            } else {
                // task failed to update
                $response["error"] = true;
                $response["message"] = "language failed to update. Please try again!";
            }
            echoRespnse(200, $response);
        });		
		
/*
 * Listing all news
 * method GET
 * url /news          
 */		
		
		$app->get('/news', 'authenticate', function() use ($app) {
           
            $response = array();
           // $task = $app->request->post('task');

            global $user_id;
            $db = new DbHandler();

            // creating new task
            $response["news"] = $db->getNews();

            if ($response["news"] != NULL) {
                $response["error"] = false;
                $response["message"] = "News getting successfull";
               
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to get news. Please try again";
                echoRespnse(200, $response);
            }            
        });
/*
 * Listing all event
 * method GET
 * url /event          
 */	
$app->get('/event', 'authenticate', function() use ($app) {
           
            $response = array();
           
            global $user_id;
            $db = new DbHandler();

            // creating new task
            $response["event"] = $db->getEvent();

            if ($response["event"] != NULL) {
                $response["error"] = false;
                $response["message"] = "Event getting successfull";
               
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to get Event. Please try again";
                echoRespnse(200, $response);
            }            
        });		
		
/*
 * Listing all event
 * method GET
 * url /pravachan          
 */	
$app->get('/pravachan/:page', 'authenticate', function($page) use ($app) {
           
            $response = array();
           $start = 0; 
			$limit = 5; 
            global $user_id;
            $db = new DbHandler();

			$start = ($page - 1) * $limit;
            // creating new task
            $response["pravachan"] = $db->getPrvchan($start,$limit);

            if ($response["pravachan"] != NULL) {
                $response["error"] = false;
                $response["message"] = "Pravachan getting successfull";
               
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to get Pravachan. Please try again";
                echoRespnse(200, $response);
            }            
        });

$app->get('/ringtone/:page', 'authenticate', function($page) use ($app) {
           
            $response = array();
           $start = 0; 
			$limit = 5; 
            global $user_id;
            $db = new DbHandler();

			$start = ($page - 1) * $limit;
            // creating new task
            $response["ringtone"] = $db->getRingtone($start,$limit);

            if ($response["ringtone"] != NULL) {
                $response["error"] = false;
                $response["message"] = "Ringtone getting successfull";
               
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to get Ringtone. Please try again";
                echoRespnse(200, $response);
            }            
        });		
		
$app->post('/userNews', 'authenticate', function() use ($app) {
            // check for required params
           // verifyRequiredParams(array('task'));

            $response = array();
            $title = $app->request->post('title');
			$url = $app->request->post('url');
			$disc = $app->request->post('disc');
			$image = $app->request->post('image');
			$fileName = $app->request->post('fileName');
			

            global $user_id;
            $db = new DbHandler();

            // creating new task
            $result = $db->userNews($user_id, $title, $url, $disc, $image, $fileName);

            if ($result) {
                $response["error"] = false;
                $response["message"] = "News submitted succefully";
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to submit news. Please try again";
                echoRespnse(200, $response);
            }            
        });		


$app->post('/userEvent', 'authenticate', function() use ($app) {
            // check for required params
           // verifyRequiredParams(array('task'));

            $response = array();
            $title = $app->request->post('title');
			$address = $app->request->post('address');
			$disc = $app->request->post('disc');
			$startDate = $app->request->post('startDate');
			$endDate = $app->request->post('endDate');
			$startTime = $app->request->post('startTime');
			$endTime = $app->request->post('endTime');
			$image = $app->request->post('image');
			$fileName = $app->request->post('fileName');
			

            global $user_id;
            $db = new DbHandler();

            // creating new task
            $result = $db->userEvent($user_id, $title, $address, $disc,$startDate,$endDate,$startTime,$endTime, $image, $fileName);

            if ($result) {
                $response["error"] = false;
                $response["message"] = "Event submitted succefully";
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to submit event. Please try again";
                echoRespnse(200, $response);
            }            
        });		

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->get('/adds', function() use ($app) {
           
            $response = array();
            // check for correct email and password
            $db = new DbHandler();

            $response["adds"] = $db->getAdds();

            if ($response["adds"] != NULL) {
                $response["error"] = false;
                $response["message"] = "Adds getting successfull";
               
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to get adds. Please try again";
                echoRespnse(200, $response);
            }     
        });		
		
		
$app->post('/userFeedback', 'authenticate', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('title','disc'));

            $response = array();
            $title = $app->request->post('title');
			$disc = $app->request->post('disc');
			
			

            global $user_id;
            $db = new DbHandler();

            // creating new task
            $result = $db->userFeedback($user_id, $title, $disc);

            if ($result) {
                $response["error"] = false;
                $response["message"] = "Feedback submitted succefully";
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to submit feedback. Please try again";
                echoRespnse(200, $response);
            }            
        });				
/************************************************************************************************************************/		
/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
$app->get('/tasks', 'authenticate', function() {
            global $user_id;
            $response = array();
            $db = new DbHandler();

            // fetching all user tasks
            $result = $db->getAllUserTasks($user_id);

            $response["error"] = false;
            $response["tasks"] = array();

            // looping through result and preparing tasks array
            while ($task = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["task"] = $task["task"];
                $tmp["status"] = $task["status"];
                $tmp["createdAt"] = $task["created_at"];
                array_push($response["tasks"], $tmp);
            }

            echoRespnse(200, $response);
        });

/**
 * Listing single task of particual user
 * method GET
 * url /tasks/:id
 * Will return 404 if the task doesn't belongs to user
 */
$app->get('/tasks/:id', 'authenticate', function($task_id) {
            global $user_id;
            $response = array();
            $db = new DbHandler();

            // fetch task
            $result = $db->getTask($task_id, $user_id);

            if ($result != NULL) {
                $response["error"] = false;
                $response["id"] = $result["id"];
                $response["task"] = $result["task"];
                $response["status"] = $result["status"];
                $response["createdAt"] = $result["created_at"];
                echoRespnse(200, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
            }
        });

/**
 * Creating new task in db
 * method POST
 * params - name
 * url - /tasks/
 */
$app->post('/tasks', 'authenticate', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('task'));

            $response = array();
            $task = $app->request->post('task');

            global $user_id;
            $db = new DbHandler();

            // creating new task
            $task_id = $db->createTask($user_id, $task);

            if ($task_id != NULL) {
                $response["error"] = false;
                $response["message"] = "Task created successfully";
                $response["task_id"] = $task_id;
                echoRespnse(201, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to create task. Please try again";
                echoRespnse(200, $response);
            }            
        });

/**
 * Updating existing task
 * method PUT
 * params task, status
 * url - /tasks/:id
 */
$app->put('/tasks/:id', 'authenticate', function($task_id) use($app) {
            // check for required params
            verifyRequiredParams(array('task', 'status'));

            global $user_id;            
            $task = $app->request->put('task');
            $status = $app->request->put('status');

            $db = new DbHandler();
            $response = array();

            // updating task
            $result = $db->updateTask($user_id, $task_id, $task, $status);
            if ($result) {
                // task updated successfully
                $response["error"] = false;
                $response["message"] = "Task updated successfully";
            } else {
                // task failed to update
                $response["error"] = true;
                $response["message"] = "Task failed to update. Please try again!";
            }
            echoRespnse(200, $response);
        });

/**
 * Deleting task. Users can delete only their tasks
 * method DELETE
 * url /tasks
 */
$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
            global $user_id;

            $db = new DbHandler();
            $response = array();
            $result = $db->deleteTask($user_id, $task_id);
            if ($result) {
                // task deleted successfully
                $response["error"] = false;
                $response["message"] = "Task deleted succesfully";
            } else {
                // task failed to delete
                $response["error"] = true;
                $response["message"] = "Task failed to delete. Please try again!";
            }
            echoRespnse(200, $response);
        });

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
?>
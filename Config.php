<?php
/**
 * Database configuration
 */
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'jainworld');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);
define('USER_FAILED_TO_GCM_API', 3);
define('USER_FAILED_TO_OTP', 4);

define('BULKSMS_AUTH_KEY', "104306AMOQVeDz6g56daf131");
// sender id should 6 character long
define('BULKSMS_SENDER_ID', 'LOFFER');
?>

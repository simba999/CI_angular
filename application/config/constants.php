<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Custome Defined
$taskFilter = array();
$taskFilter['today'] = 'Today';
$taskFilter['tomorrow'] = 'Tomorrow';
$taskFilter['next7day'] = 'Next 7 days';
$taskFilter['month'] = 'This Month';
$taskFilter['open'] = 'All Open';

$databaseFilterdatabaseFilter = array();
$today = date('Y-m-d');
$tomrrow = date('Y-m-d',strtotime('+1 days'));
$next7Days = date('Y-m-d',strtotime("+7 days"));
$thisMonth = date('m');

$databaseFilter['today'] =  "t.dueDate ="."@".$today;
$databaseFilter['tomorrow'] = "t.DueDate ="."@".$tomrrow;
$databaseFilter['next7day'] = "t.DueDate ="."@".$next7Days;
$databaseFilter['month'] =   "MONTH(t.DueDate) = "."@".$thisMonth;
$databaseFilter['open'] =   "";

defined('ASSETS_DIR')      OR define('ASSETS_DIR', 'assets'); 
defined('FRAMEWORKS_DIR')      OR define('FRAMEWORKS_DIR', '/frameworks'); 
defined('PLUGINS_DIR')      OR define('PLUGINS_DIR', '/plugins'); 
defined('UPLOAD_DIR')      OR define('UPLOAD_DIR', 'upload'); 
defined('IMAGE')      OR define('IMAGE', 'images'); 
defined('USER_IMAGE')      OR define('USER_IMAGE', 'users_image'); 
defined('USER_IMAGE_THUMB_PATH')      OR define('USER_IMAGE_THUMB_PATH', 'users_image/thumbnail'); 
defined('USER_THUMB_SIZE')      OR define('USER_THUMB_SIZE', 150); 
defined('LEAD_DOCUMENT')      OR define('LEAD_DOCUMENT', 'lead_document'); 
defined('EVENT_IMAGE')      OR define('EVENT_IMAGE', 'event_image'); 
defined('AVATAR_DIR')      OR define('AVATAR_DIR', '/avatar'); 
defined('VENDOR_DIR')      OR define('VENDOR_DIR', '/vendor'); 
defined('BOWER_COMPNENT')      OR define('BOWER_COMPNENT', '/bower_components');
//defined('MAPKEY')      OR define('MAPKEY', 'AIzaSyAGu1BIaFcOoRQbyS5xfkM7Mr306fd7Ji4');
defined('MAPKEY')      OR define('MAPKEY', 'AIzaSyD9k2nSFlkzhcdr7fzRh3ZU_K1lgxZMhT0');
//defined('CLIENT_ID')      OR define('CLIENT_ID', '329695175100-ujsq41kpgaathhetvigfdhgsa09vkg6f.apps.googleusercontent.com');
defined('CLIENT_ID')      OR define('CLIENT_ID', '329695175100-gitjf23mbennldjiqit33f588o11grms.apps.googleusercontent.com');
//defined('CLIENT_SECRET_ID')      OR define('CLIENT_SECRET_ID', 'jeeBk4-WBaOTSqEoRn4pLg-Q');
defined('CLIENT_SECRET_ID')      OR define('CLIENT_SECRET_ID', 'tTx_6xfVUOePSdbm0FWebAwd');
defined('TASKFILTER')   OR   define ("TASKFILTER", json_encode ($taskFilter));
defined('DATABASEFILTER')   OR   define ("DATABASEFILTER", serialize ($databaseFilter));
defined('LEAD_IMAGE')      OR define('LEAD_IMAGE', 'leads_image'); 
defined('LEAD_IMAGE_THUMB_PATH')      OR define('LEAD_IMAGE_THUMB_PATH', 'leads_image/thumbnail'); 
defined('LEAD_THUMB_SIZE')      OR define('LEAD_THUMB_SIZE', 150); 


// Below constants are created for Interaction Types 
defined('INTERACTION_TYPE_CALL')      OR define('INTERACTION_TYPE_CALL', 'Call'); 
defined('INTERACTION_TYPE_TEXT')      OR define('INTERACTION_TYPE_TEXT', 'Text'); 
defined('INTERACTION_TYPE_EMAIL')      OR define('INTERACTION_TYPE_EMAIL', 'Email'); 
defined('API_URL')      OR define('API_URL', 'https://printbuilder.agentcloud.com/api/me'); 
defined('API_REDIRECT_URL')      OR define('API_REDIRECT_URL', 'https://printbuilder.agentcloud.com/dashboard'); 

 
defined('TAGS_DIR')      OR define('TAGS_DIR', '/tags');

// Below constants are defined to declare and use Tasks Status for the Cron Job
defined('TASK_STATUS_OPEN')      OR define('TASK_STATUS_OPEN', 'Open');
defined('TASK_STATUS_IN_PROCESS')      OR define('TASK_STATUS_IN_PROCESS', 'In Process');
defined('TASK_STATUS_OVER_DUE')      OR define('TASK_STATUS_OVER_DUE', 'OverDue');
// Below constants are created to check Task Status From the Database
defined('TASK_STATUS_COMPLETED')      OR define('TASK_STATUS_COMPLETED', 'Completed');
defined('CALENDAR_URL')      OR define('CALENDAR_URL', 'https://calendar.agentcloud.com/');
defined('WEBSITE_BUILDER_URL')      OR define('WEBSITE_BUILDER_URL', 'https://websitebuilder.agentcloud.com/');
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

/*
|--------------------------------------------------------------------------
| BASE URL & BASE URI
|--------------------------------------------------------------------------
*/
// Base URL (keeps this crazy sh*t out of the config.php
if (isset($_SERVER['HTTP_HOST'])) {
    $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
    $base_url .= '://'. $_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

    // Base URI (It's different to base URL!)
    $base_uri = parse_url($base_url, PHP_URL_PATH);
    if (substr($base_uri, 0, 1) != '/') $base_uri = '/'.$base_uri;
    if (substr($base_uri, -1, 1) != '/') $base_uri .= '/';
} else {
    $base_url = '';
    $base_uri = '/';
}
// Define these values to be used later on
defined('BASE_URL') OR define('BASE_URL', $base_url);
defined('BASE_URI') OR define('BASE_URI', $base_uri);

defined('DION_IP1') OR define('DION_IP1', '18.177.203.122');

/*
|--------------------------------------------------------------------------
| Site Name
|--------------------------------------------------------------------------
*/
defined('THEME_NAME') OR define('THEME_NAME', 'html_default');
defined('SITE_DOMAIN') OR define('SITE_DOMAIN', 'csdion.demo-dion.xyz');
defined('SITE_NAME_KR') OR define('SITE_NAME_KR', 'Dion 관리자(가칭)');
defined('SITE_NAME_EN') OR define('SITE_NAME_EN', 'Dion Administrator');
defined('SITE_DESCRIPTION') OR define('SITE_DESCRIPTION', 'Welcome to Dion 관리자(가칭)');
defined('SITE_COPYRIGHT') OR define('SITE_COPYRIGHT', 'Copyright ©.Dion SoftTech');
defined('SITE_VERSION') OR define('SITE_VERSION', '1.0.0');

/*
|--------------------------------------------------------------------------
| FCM
|--------------------------------------------------------------------------

defined('FCM_SERVER_KEY') OR define('FCM_SERVER_KEY', 'AAAAnw3vcuI:APA91bFpe65yMPIFNuIrn3HNFeov1pfx640oCaQ_QALfTfbB8W2GKGEdn9A6hlPXvz5tZyLNoD1dJNlEDDOXUnlGg7EQ1Rn12GqgtqyNPK7Cc5YZkKlcmlWlsrHBB3yq7KegYrRIG6Xi');
defined('FCM_PROJECT_ID') OR define('FCM_PROJECT_ID', 'fir-test-7bab0');
defined('FCM_SENDER_ID') OR define('FCM_SENDER_ID', '683133596386');
defined('FCM_SEND_URL') OR define('FCM_SEND_URL', 'https://fcm.googleapis.com/fcm/send');
defined('FCM_SEND_URL_OAUTH') OR define('FCM_SEND_URL_OAUTH', 'https://fcm.googleapis.com/v1/projects/');
defined('FCM_TIMEOUT') OR define('FCM_TIMEOUT', 30);
*/

/*
|--------------------------------------------------------------------------
| User API use
|--------------------------------------------------------------------------
*/
defined('KEYWORD') OR define('KEYWORD', 'GOLFBOOKING_DION_ADMIN_KEYWORD');

/*
|--------------------------------------------------------------------------
| Kakao API Info
|--------------------------------------------------------------------------
*/
defined('KAKAO_RESTAPI_KEY') OR define('KAKAO_RESTAPI_KEY', '136ac88625d5fa66b6c1533c1d3d6df2');
defined('KAKAO_JS_KEY') OR define('KAKAO_JS_KEY', '9e1ddabd00f4d9b85bd8c359dc6490dd');



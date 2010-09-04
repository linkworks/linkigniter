<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Flash Message Types
|--------------------------------------------------------------------------
*/

define('FLASH_MESSAGE', 'message');
define('FLASH_ERROR', 'error');
define('FLASH_ALERT', 'alert');

/*
|--------------------------------------------------------------------------
| Javascript includes constants
|--------------------------------------------------------------------------
*/

define('DATATABLES_CORE', 'js/dataTables-1.7/media/js/jquery.dataTables.min');
define('JQUERY_CORE', 'js/jquery-1.4.2.min');
define('JQUERY_UI', 'js/jquery-ui-1.8.2.custom.min');
define('JQUERY_TIPTIP', 'js/jquery.tipTip.minified');
define('LINKIGNITER_UTILS', 'js/utils');
define('LINKIGNITER_CONSOLE_JS', 'js/linkigniter_console');

define('DATATABLES_LOADERS_FOLDER', 'js/datatables_loaders');


/*
|--------------------------------------------------------------------------
| CSS includes constants
|--------------------------------------------------------------------------
*/

define('FANCY_BUTTONS', 'css/buttons');
define('CSS_TIPTIP', 'css/tipTip');
define('CSS_JQUERY_UI', 'css/ui-lightness/jquery-ui-1.8.2.custom');
define('CSS_RESET', 'css/reset');
define('CSS_ALERTS', 'css/alerts');
define('LINKIGNITER_CONSOLE_CSS', 'css/linkigniter_console');

/*
|--------------------------------------------------------------------------
| Images Constants
|--------------------------------------------------------------------------
*/

define('ICON_PATH', 'images/icons/');

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */
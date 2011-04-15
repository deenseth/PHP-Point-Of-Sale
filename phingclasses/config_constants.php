<?php
/**
 * This file is pretty much index.php with a few modifications
 * which are:
 *    - the loading of the front controller is removed from the bottom since
 *      this file is now included from ci_model_remote_open.php
 *    - when setting $system_folder and $application_folder we check for previous
 *    existence of those variables so we can set them previous to including
 *    ci_model_remote_open.php. This way it's more flexible.
 *    - error reporting control has been removed
 */
 
//--------------------------------------------------------------------------------------

/*
|---------------------------------------------------------------
| SYSTEM FOLDER NAME
|---------------------------------------------------------------
|
| This variable must contain the name of your "system" folder.
| Include the path if the folder is not in the same  directory
| as this file.
|
| NO TRAILING SLASH!
|
*/
if( ! $system_folder)
    $system_folder = "system";

/*
|---------------------------------------------------------------
| APPLICATION FOLDER NAME
|---------------------------------------------------------------
|
| If you want this front controller to use a different "application"
| folder then the default one you can set its name here. The folder 
| can also be renamed or relocated anywhere on your server.
| For more info please see the user guide:
| http://www.codeigniter.com/user_guide/general/managing_apps.html
|
|
| NO TRAILING SLASH!
|
*/
if( ! $application_folder)
    $application_folder = "application";


/*
|===============================================================
| END OF USER CONFIGURABLE SETTINGS
|===============================================================
*/


/*
|---------------------------------------------------------------
| SET THE SERVER PATH
|---------------------------------------------------------------
|
| Let's attempt to determine the full-server path to the "system"
| folder in order to reduce the possibility of path problems.
|
*/
if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
{
    $system_folder = str_replace("\\", "/", realpath(dirname(__FILE__))).'/'.$system_folder;
}

/*
|---------------------------------------------------------------
| DEFINE APPLICATION CONSTANTS
|---------------------------------------------------------------
|
| EXT        - The file extension.  Typically ".php"
| FCPATH    - The full server path to THIS file
| SELF        - The name of THIS file (typically "index.php)
| BASEPATH    - The full server path to the "system" folder
| APPPATH    - The full server path to the "application" folder
|
*/
define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder.'/');

if (is_dir($application_folder))
{
    define('APPPATH', $application_folder.'/');
}
else
{
    if ($application_folder == '')
    {
        $application_folder = 'application';
    }

    define('APPPATH', BASEPATH.$application_folder.'/');
}

/*
|---------------------------------------------------------------
| DEFINE E_STRICT
|---------------------------------------------------------------
|
| Some older versions of PHP don't support the E_STRICT constant
| so we need to explicitly define it otherwise the Exception class 
| will generate errors.
|
*/
if ( ! defined('E_STRICT'))
{
    define('E_STRICT', 2048);
}


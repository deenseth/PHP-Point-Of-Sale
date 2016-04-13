#!/usr/bin/php
<?php

/*
|--------------------------------------------------------------
| CRON JOB BOOTSTRAPPER
|--------------------------------------------------------------
|
| This section is used to get a cron job going, using standard
| CodeIgniter controllers and functions.
|
| 1) Set the CRON_CI_INDEX constant to the location of your
|    CodeIgniter index.php file
| 2) Make this file executable (chmod a+x cron.php)
| 3) You can then use this file to call any controller function:
|    ./cron.php --run=/controller/method [--show-output] [--log-file=logfile] [--time-limit=N] 
|
| GOTCHA: Do not load any authentication or session libraries in
| controllers you want to run via cron. If you do, they probably
| won't run right.
|
*/

define('CRON_CI_INDEX', 'index.php');   // Your CodeIgniter main index.php file
//define('CRON_CI_INDEX', '/var/www/vhosts/myaccount/index.php');   // Your CodeIgniter main index.php file
define('CRON', TRUE);   // Test for this in your controllers if you only want them accessible via cron

// Parse the command line
$script = array_shift($argv);
$cmdline = implode(' ', $argv);
$usage = "Usage: cron.php --run=/controller/method [--show-output][-S] [--log-file=logfile] [--time-limit=N]\n\n";
$required = array('--run' => FALSE);
$uri = '';

foreach($argv as $arg)
{
    list($param, $value) = explode('=', $arg);
    
    switch($param)
    {
        case '--run':
            // Simulate an HTTP request
            $uri = $value;
            $_SERVER['PATH_INFO'] = $value;
            $_SERVER['REQUEST_URI'] = $value;
            $_SERVER['SERVER_NAME'] = 'localhost';
            $required['--run'] = TRUE;
        break;

        case '-S':
        case '--show-output':
            define('CRON_FLUSH_BUFFERS', TRUE);
        break;

        case '--log-file':
            if(is_writable($value)) define('CRON_LOG', $value);
            else die("Logfile $value does not exist or is not writable!\n\n");
        break;

        case '--time-limit':
            define('CRON_TIME_LIMIT', $value);
        break;

        default:
            die($usage);
    }
}

if (!defined('CRON_FLUSH_BUFFERS'))
{
    define('CRON_FLUSH_BUFFERS', FALSE);
}

$_SERVER['argv'][1] = $uri;

for ($i=2; $i<$argc; $i++)
    $_SERVER['argv'][$i] = '';

if( ! defined('CRON_LOG'))
{
    define('CRON_LOG', 'cron.log');
}

if( ! defined('CRON_TIME_LIMIT'))
{
    define('CRON_TIME_LIMIT', 0);
}

foreach($required as $arg => $present)
{
    if( ! $present)
    {
        die($usage);
    }
}

// Set run time limit
set_time_limit(CRON_TIME_LIMIT);

// Run CI and capture the output
ob_start();

chdir(dirname(CRON_CI_INDEX));
require(CRON_CI_INDEX);           // Main CI index.php file
$output = ob_get_contents();
 
if(CRON_FLUSH_BUFFERS === TRUE)
{
    while(@ob_end_flush());     // display buffer contents
}
else
{
    ob_end_clean();
}

// Log the results of this run
error_log("////// ".date('Y-m-d H:i:s')." cron.php $cmdline\r\n", 3, CRON_LOG);
error_log(str_replace("\n", "\r\n", $output), 3, CRON_LOG);
error_log("\r\n////// \r\n\r\n", 3, CRON_LOG);

echo "\n\n"; 


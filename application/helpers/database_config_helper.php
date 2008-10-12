<?php
/*
Returns the configuration array in order to connect to the database. The $config
object passed in to this function contains the global configuration which holds
our database connection information.
*/
function get_database_configuration($config)
{
	$db_config['hostname'] = $config->item('db_host');
	$db_config['username'] = $config->item('db_user');
	$db_config['password'] = $config->item('db_password');
	$db_config['database'] = $config->item('db_name');
	$db_config['dbdriver'] = "mysql";
	$db_config['dbprefix'] = "phppos_";
	$db_config['pconnect'] = FALSE;
	$db_config['db_debug'] = TRUE;
	$db_config['cache_on'] = FALSE;
	$db_config['cachedir'] = "";
	$db_config['char_set'] = "utf8";
	$db_config['dbcollat'] = "utf8_general_ci";
	
	return $db_config;
}

?>
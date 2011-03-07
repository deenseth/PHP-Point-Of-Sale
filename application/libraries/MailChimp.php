<?php

/**
 * 
 * CodeIgniter MailChimp API wrapper
 * Created to improve autoloading with CodeIgniter
 * 
 * USAGE: Include this in your libraries folder. Make sure the MCAPI class file is in the same folder. Autoload as usual.
 * 
 * Developed by Robert Elwell (http://robertelwell.info)
 * 
 */

require_once('MCAPI.php');

class MailChimp extends MCAPI
{
	private $MCAPI;
	
    function __construct($config=null)
    {
    	if ($config) {
	        $secure = false;
	        
	    	// determine where API key is
	    	if (is_array($config)) {
		    	if (isset($config['api_key'])) {
		    		$key = $config['api_key'];
		    	} else {
		    		$key = array_shift($config);
		    	}
		    	
		    	if (isset($config['secure'])) {
		    		$secure = $config['secure'];
		    	}
		    	
	    	} else {
	    		$key = $config;
	    	}
	    	
	    	$this->MCAPI = parent::__construct($key, $secure);
    	}
    }
    
    function __call($name, $args)
    {
    	if ($this->MCAPI && method_exists($this->MCAPI, $name)) {
    	   call_user_func(array($this->MCAPI, $name), $args);
    	} else {    	
    	   call_user_func(array($this, $name), $args);
    	}
    }
}
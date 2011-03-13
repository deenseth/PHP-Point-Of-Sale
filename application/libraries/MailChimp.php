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
	private $lists;
	private $ids_lists = array();
	private $lists_groups = array();
	
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
    
    function tableListing($email)
    {
    	$lists = $this->lists();
    	$listIDs = $this->listsForEmail($email);
    	
    	$names = array();
    	
    	$html = '';
        
    	if ($listIDs) {
    	    $html .= '<ul>';
	    	foreach ($listIDs as $id)
	    	{
	    		$html .= '<li>'.$this->ids_lists[$id]['name'];
	    		
	    		$response = $this->listMemberInfo($id, $email);
                $individual = array_shift($response['data']);
                $merge_vars = $individual['merges'];
                $groups = array();
                foreach ($merge_vars['GROUPINGS'] as $grouping)
                {
                    if ($grouping['groups']) {
                        foreach (explode(',', $grouping['groups']) as $group)
                        {
                            $groups[] = $grouping['name'].': '.$group;
                        }
                    }
                }
                if ($groups) {
                    $html .= '<ul>';
    	    		foreach ($groups as $line)
    	    		{
    	    		    $html .= "<li>{$line}</li>";
    	    		}
    	    		$html .= '</ul>';
                }
                
	    		$html .= '</li>';
	    	}
	    	$html .= '</ul>';
    	}
    	
    	return $html;
    }
    
    /**
     * Efficient wrapper for MCAPI::lists()
     */
    function lists()
    {
    	if ($this->lists) {
    		return $this->lists;
    	}
    	
    	$lists = parent::lists();
    	$this->lists = $lists['data'];
    	
    	foreach ($this->lists as $list) {
    		$this->ids_lists[$list['id']] = $list;
    	}
    	
    	return $this->lists;
    }
    
    /**
     * Efficient wrapper for MCAPI:listInterestGroupings()
     * @see application/libraries/MCAPI#listInterestGroupings()
     */
    function listInterestGroupings($id)
    {
    	if (isset($this->lists_groups[$id])) {
    		return $this->lists_groups[$id];
    	}
    	
    	return parent::listInterestGroupings($id);
    }
}
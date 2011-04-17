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
	private $listsWithGroups = array();
	
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
    
    function tableListing($email, $listid=null)
    {
        if ($listid) {
           $lists = $this->lists(array('id'=>$listid)); 
        } else {
    	   $lists = $this->lists();
        }
    	$listIDs = $this->listsForEmail($email);
    	
    	$names = array();
    	
    	$html = '';
        
    	if ($listIDs) { 
	        $html .= $listid ? '' : '<ul>';
	    	foreach ($listIDs as $id)
	    	{
	    		$html .= $listid ? '' : '<li>'.$this->ids_lists[$id]['name'];
	    		
	    		$response = $this->listMemberInfo($id, $email);
                $individual = array_shift($response['data']);
                $merge_vars = $individual['merges'];
                $groups = array();
                if (isset($merge_vars['GROUPINGS'])){
                    foreach ($merge_vars['GROUPINGS'] as $grouping)
                    {
                        if ($grouping['groups']) {
                            foreach (explode(',', $grouping['groups']) as $group)
                            {
                                $groups[] = $grouping['name'].': '.$group;
                            }
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
                
	    		$html .= $listid ? '' : '</li>';
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
    
    /**
     * Return lists with groupings already added
     * @return array $lists
     */
    function listsWithGroups()
    {
        if ($this->listsWithGroups) {
            return $this->listsWithGroups;
        }
        
        // add groups to lists
        $lists = $this->lists();
        foreach ($lists as &$list) 
        {
            $list['groupings'] = array();
            if ($groupings = $this->listInterestGroupings($list['id'])) {
                $list['groupings'] = $groupings;
            }
        }
        
        $this->listsWithGroups = $lists;
        
        return $lists;
    }
    
    /**
     * Use form data to assign lists, groups to a given person
     * @param int $personid
     * @return bool $success 
     */
    function handleSubscriptionForPerson($personid, $update_existing=false)
    {
        $CI =& get_instance();
        
        $person = $CI->Person->get_info($personid);
        if (!$person->email) {
            return true;
        }
        foreach ($this->listsWithGroups() as $list)
        {
            $response = $this->listMemberInfo($list['id'], $person->email);
            $individual = array_shift($response['data']);
            $merge_vars = $individual['merges'];
            $selected = false;
            if (!$merge_vars['GROUPINGS']) {
                $merge_vars['GROUPINGS'] = array();
            }
            
            if ($CI->input->post($list['id'])) {
                $selected = true;
            } 
                
            foreach($list['groupings'] as $grouping) 
            {
                if ($grouping['form_field'] == 'dropdown') {
                    $val = $CI->input->post($grouping['name']);
                    if ($val !== 0 && $val !== null) {
                        $selected = true;
                        $group = end(explode('---', $val));
                        foreach ($merge_vars['GROUPINGS'] as &$chimpGrouping)
                        {
                            $changed = true;
                            if (substr_count($chimpGrouping['groups'], $group)) {
                                break;
                            }
                            $chimpGrouping['groups'] = $group;
                            break;
                        }
                    }
                    continue;
                }
                
                if ($update_existing) {
                    $groupList = '';
                }
                
                foreach ($grouping['groups'] as $group)
                {
                    
                    $changed = false;
                    if ($CI->input->post(str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name'])) == 1) {
                        $selected = true;
                        
                        if ($update_existing) {
                            $changed = true;
                            $groupList = ($groupList == '') ? $group['name'] : ','.$group['name'];
                            continue;
                        }
                        
                        foreach ($merge_vars['GROUPINGS'] as &$chimpGrouping)
                        {
                            if ($chimpGrouping['name'] == $grouping['name']) {
                                $changed = true;
                                if (substr_count($chimpGrouping['groups'], $group['name'])) {
                                     break;
                                }
                                $comma = strlen($chimpGrouping['groups'] > 0)  ? ',':''; 
                                
                                $chimpGrouping['groups'] .= $comma.$group['name'];
                                break;
                            }
                        }
                        
                        if (!$changed) {
                            $merge_vars['GROUPINGS'][] = array('name'=>$grouping['name'],
                                                               'groups'=>$group['name']);
                        }
                    }
                }
                
                if($update_existing) {
                    $found = false;
                    foreach($merge_vars['GROUPINGS'] as &$oldgrouping)
                    {
                        if ($oldgrouping['name'] == $grouping['name']) {
                            $oldgrouping['groups'] = $groupList;
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $merge_vars['GROUPINGS'][] = array('name'=>$grouping['name'],
                                                           'groups'=>$groupList);
                    }
                }
            }
            
            $mv = (count($merge_vars['GROUPINGS']) > 0) ? $merge_vars : null;
            
            if ($selected) {
                if ($this->listSubscribe($list['id'], $person->email, $mv, 'html', false, true, true)) {
                    $added++;
                } else {
                    $unadded++;
                }
            } else if ($update_existing) {
                if ($this->listUnsubscribe($list['id'], $person->email, false, false, false)) {
                    $added++;
                } else {
                    $unadded++;
                }
            }        
        }
        
        return ($added > 0); 
    }

    function isEmailSubscribedToList($listId, $email)
    {
        if (!$email) {
            return false;
        }
        
        $response = $this->listMemberInfo($listId, $email);
        
        return ($response['success'] > 0);
        
    }
    
    function isEmailSubscribedToGroup($listId, $groupingName, $groupName, $email)
    {
        if (!$email) {
            return false;
        }
        
        $response = $this->listMemberInfo($listId, $email);
        
        if ($response['success'] == 0) {
            return false;
        }
        
        $individual = array_shift($response['data']);
        
        if (!isset($individual['merges']) || count($individual['merges']['GROUPINGS']) == 0) {
            return false; 
        }
        
        foreach ($individual['merges']['GROUPINGS'] as $grouping)
        {
            if ($grouping['name'] == $groupingName) {
                return (substr_count($grouping['groups'], $groupName) > 0);
            }
        }
        
        return false;
    }
    
    function campaigns()
    {
        $campaigns = parent::campaigns();
        
        if (!$this->lists) {
            $this->lists();
        }
        
        foreach ($campaigns['data'] as &$campaign)
        {
            $campaign['listname'] = ($name = $this->ids_lists[$campaign['list_id']]['name']) ? $name : "No";
        }
        
        return $campaigns;
        
    }
    
    function getPersonDataByEmail($email, $listID = null)
    {
        $person = new stdClass();
        $person->email = $email;
        
        $lists = $listID ? $this->lists(array('id'=>$listID)) : $this->lists();
        foreach ($lists as $list) 
        {
            $listID = $list['id'];
            if (($response = $this->listMemberInfo($listID, $person->email)) && $response['success'] == 1) {
                $info = array_shift($response['data']);
                $person->first_name = $info['merges']['FNAME'];
                $person->last_name = $info['merges']['LNAME'];
                break;
            } 
        }
        
        return $person;
    }
    
}
<?php
require_once "phing/Task.php";

class RepeatableCampaign extends Task {
    private $interval;
    
    public function main()
    {
        $CI = &get_instance();
        
        if ($key = $CI->Appconfig->get('mc_api_key')) {
            $CI->load->library('MailChimp', array($key), 'MailChimp');
        } else { 
            throw new Exception('You must have an API key to use this feature');
        }
        
        $query = $CI->db->query("SELECT * FROM `phppos_campaignbuilds` WHERE `interval` = ?", array($this->interval));
        
        foreach ($query->result() as $query)
        {
            
        }
        
    }
    
    
	/**
     * @return the $interval
     */
    public function getInterval ()
    {
        return $this->interval;
    }

	/**
     * @param field_type $interval
     */
    public function setInterval ($interval)
    {
        $this->interval = $interval;
    }
}
<?php
require_once ("phing/Task.php");

class RepeatableCampaign extends Task {
    private $interval;
    
    public function main()
    {
        $system_folder = "../system";
        require_once (dirname(__FILE__)."/ci_model_remote_open.php");
        require_once (APPPATH . "/controllers/reports.php");
        error_reporting('E_NONE');
        $CI = &get_instance();
        
        if ($key = $CI->Appconfig->get('mc_api_key')) {
            $CI->load->library('MailChimp', array($key), 'MailChimp');
        } else { 
            throw new Exception('You must have an API key to use this feature');
        }
        
        $CI->load->library('Report_Service', array(), 'Service');
        
        $query = $CI->db->query("SELECT * FROM `phppos_campaignbuilds` WHERE `interval` = ?", array($this->interval));
        
        foreach ($query->result() as $row)
        {
            $options = array('list_id'	    =>    $row->list_id,
                             'subject'	    =>    $row->title,
                             'from_email'	=>    $row->from_email,
                             'from_name'	=>    $row->from_name,
                             'to_name'		=>    $row->to_name,
                             'inline_css'	=>    true,
                             'generate_text'=>    true);
            
            $segmentOptions = array();
            if ($row->grouping_id && $row->grouping_value) {
                $segmentOptions = array('match'	        =>    'all',
                                        'conditions'	=>    array(array('field'=>'interests-'.$row->grouping_id),
                                                                          'op'	 =>'one',
                                                                          'value'=>$row->grouping_value));
            }
            
            // build and call the appropriate report service
            $CI->Service->setSuppressEcho(true);
            $params = ($p = unserialize($row->report_params) && is_array($p)) ? $p : array();
            $intervalDates = $this->getIntervalDates();
            $callParams = $intervalDates + $params;
            
            $report = call_user_func_array(array($CI->Service, $row->report_type), $callParams);
            $html = $CI->load->view('partial/repeatable_campaign', array('report_service'=>$report, 'data'=>$row), true);
            echo $html; die;
            $id = $CI->MailChimp->campaignCreate('regular', $options ,array('html'=>$html), $segmentOptions);
            if ($id) {
                if ($CI->MailChimp->campaignSendNow($id)) {
                    $message = ucfirst($this->interval)." campaign \"{$row->title}\" sent successfully (ID: {$id})";
                } else { 
                    $message = "Problem sending {$this->interval} campaign \"{$row->title}\" (ID: {$id}): {$CI->MailChimp->errorMessage}";
                }
            } else {
                $message = "Problem creating {$this->interval} campaign \"{$row->title}\": {$CI->MailChimp->errorMessage}";
            }
            $this->log($message);
        }
        
    }
    
    /**
     * @return array (startdate, enddate)
     * Enter description here ...
     */
    protected function getIntervalDates()
    {
        switch ($this->interval){
            case 'daily':
                return array(date('Y-m-d', strtotime('today')), date('Y-m-d', strtotime('today')));
                break;
            case 'weekly':
                return array(date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime('today')));
                break;
            case 'monthly':
                return array(date('Y-m-d', strtotime('-1 month')), date('Y-m-d', strtotime('today')));
                break;
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
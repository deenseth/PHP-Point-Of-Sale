<?php
require_once ("phing/Task.php");
require_once (APPPATH."application/controllers/reports.php");

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
        
        foreach ($query->result() as $row)
        {
            $options = array('list_id'	    =>    $row['list_id'],
                             'subject'	    =>    $row['title'],
                             'from_email'	=>    $row['from_email'],
                             'from_name'	=>    $row['from_name'],
                             'to_name'		=>    $row['to_name'],
                             'generate_text'=>    true);
            
            $segmentOptions = array();
            if ($row['grouping_id'] && $row['grouping_value']) {
                $segmentOptions = array('match'	        =>    'all',
                                        'conditions'	=>    array(array('field'=>'interests-'.$row['grouping_id']),
                                                                          'op'	 =>'one',
                                                                          'value'=>$row['grouping_value']));
            }
            
            
            $CI->load->model($row['report_model']);
            $className = str_replace('reports/', '', $row['report_model']);
            $model = $CI->{$className};
            
            $headers = $model->getDataColumns();
            
            
            $id = $this->MailChimp->campaignCreate('regular', $options ,array('html'=>$html), $segmentOptions);
            if ($id) {
                if ($this->MailChimp->campaignSendNow($id)) {
                    $message = "{ucfirst($this->interval)} campaign \"{$row['title']}\" (ID: {$id}) sent successfully";
                } else { 
                    $message = "Problem sending {$this->interval} campaign \"{$row['title']}\" (ID: {$id}): {$this->MailChimp->errorMessage}";
                }
            } else {
                $message = "Problem creating {$this->interval} campaign \"{$row['title']}\": {$this->MailChimp->errorMessage}";
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
                return array('start_date'=>date('Y-m-d', strtotime('today')), 'end_date'=>date('Y-m-d', strtotime('today')));
                break;
            case 'weekly':
                return array('start_date'=>date('Y-m-d', strtotime('-1 week')), 'end_date'=>date('Y-m-d', strtotime('today')));
                break;
            case 'monthly':
                return array('start_date'=>date('Y-m-d', strtotime('-1 month')), 'end_date'=>date('Y-m-d', strtotime('today')));
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
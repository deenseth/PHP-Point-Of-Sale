<?php
require_once ("secure_area.php");
class Reports extends Secure_area 
{	
	function __construct()
	{
		parent::__construct('reports');
		$this->load->helper('report');
		$this->load->library('Report_Service', array(), 'Service');
	}
	
	//Initial report listing screen
	function index()
	{
		$this->load->view("reports/listing",array());	
	}
	
	function _get_common_report_data()
	{
		$data = array();
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$data['months'] = get_months();
		$data['days'] = get_days();
		$data['years'] = get_years();
		$data['selected_month']=date('n');
		$data['selected_day']=date('d');
		$data['selected_year']=date('Y');	
	
		return $data;
	}
	
    function weekly($report,$sale_type=null,$specific_input=null,$format='html')
    {
        $start_date = date('Y-m-d', strtotime('-1 week'));
        $end_date = date('Y-m-d');
        
        if ($specific_input) {
            $service = $this->Service->{$report}($start_date, $end_date, $specific_input, $sale_type, ($format=='xls' ? 1 : 0));
            $service->setFormat($format);
            $service->loadWithView($this->get_view($report));
        } else {
            $service = $this->Service->{$report}($start_date, $end_date, $sale_type, ($format=='xls' ? 1 : 0));
            $service->setFormat($format);
            $service->loadWithView($this->get_view($report));
        }
        
    }
    
    function daily($report,$sale_type=null,$specific_input=null,$format='html')
    {
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        
        if ($specific_input) {
            $service = $this->Service->{$report}($start_date, $end_date, $specific_input, $sale_type, ($format=='xls' ? 1 : 0));
            $service->setFormat($format);
            $service->loadWithView($this->get_view($report));
        } else {
            $service = $this->Service->{$report}($start_date, $end_date, $sale_type, ($format=='xls' ? 1 : 0));
            $service->setFormat($format);
            $service->loadWithView($this->get_view($report));
        }
    }
    
    function monthly($report,$sale_type=null,$specific_input=null,$format='html')
    {
        $start_date = date('Y-m-d', strtotime('-1 month'));
        $end_date = date('Y-m-d');
        
        if ($specific_input) {
            $service = $this->Service->{$report}($start_date, $end_date, $specific_input, $sale_type, ($format=='xls' ? 1 : 0));
            $service->setFormat($format);
            $service->loadWithView($this->get_view($report));
        } else {
            $service = $this->Service->{$report}($start_date, $end_date, $sale_type, ($format=='xls' ? 1 : 0));
            $service->setFormat($format);
            $service->loadWithView($this->get_view($report));
        }
    }
	
	//Input for reports that require only a date range and an export to excel. (see routes.php to see that all summary reports route here)
	function date_input_excel_export()
	{
		$data = $this->_get_common_report_data();
		$this->load->view("reports/date_input_excel_export",$data);	
	}
	
	//Summary sales report
	function summary_sales($start_date, $end_date, $sale_type, $export_excel=0)
	{
        $data = array('report_service' => $this->Service->summary_sales($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary categories report
	function summary_categories($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_categories($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary customers report
	function summary_customers($start_date, $end_date, $sale_type, $export_excel=0)
	{
	    $data = array('report_service' => $this->Service->summary_customers($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary suppliers report
	function summary_suppliers($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_suppliers($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary items report
	function summary_items($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_items($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary employees report
	function summary_employees($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_employees($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary taxes report
	function summary_taxes($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_taxes($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Summary discounts report
	function summary_discounts($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_discounts($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	function summary_payments($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->summary_payments($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	//Input for reports that require only a date range. (see routes.php to see that all graphical summary reports route here)
	function date_input()
	{
		$data = $this->_get_common_report_data();
		$this->load->view("reports/date_input",$data);	
	}
	
	/**
	 * For graphical summary reports, we don't need to reuse the data anywhere, 
	 * so for brevity's sake, we'll just render the report directly through the service
	 */
	
	//Graphical summary sales report
	function graphical_summary_sales($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_sales($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_sales_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_sales_graph($start_date, $end_date, $sale_type);
	}
	
	//Graphical summary items report
	function graphical_summary_items($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_items($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_items_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_items_graph($start_date, $end_date, $sale_type);
	}
	
	//Graphical summary customers report
	function graphical_summary_categories($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_categories($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_categories_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_categories_graph($start_date, $end_date, $sale_type);
	}
	
	function graphical_summary_suppliers($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_suppliers($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_suppliers_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_suppliers_graph($start_date, $end_date, $sale_type);
	}
	
	function graphical_summary_employees($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_employees($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_employees_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_employees_graph($start_date, $end_date, $sale_type);
	}
	
	function graphical_summary_taxes($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_taxes($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_taxes_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_taxes_graph($start_date, $end_date, $sale_type);
	}
	
	//Graphical summary customers report
	function graphical_summary_customers($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_customers($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_customers_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_customers_graph($start_date, $end_date, $sale_type);
	}
	
	//Graphical summary discounts report
	function graphical_summary_discounts($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_discounts($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_discounts_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_discounts_graph($start_date, $end_date, $sale_type);
	}
	
	function graphical_summary_payments($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_payments($start_date, $end_date, $sale_type);
	}
	
	//The actual graph data
	function graphical_summary_payments_graph($start_date, $end_date, $sale_type)
	{
		$this->Service->graphical_summary_payments_graph($start_date, $end_date, $sale_type);
	}
	
	function specific_customer_input()
	{
		$data = $this->_get_common_report_data();
		$data['specific_input_name'] = $this->lang->line('reports_customer');
		
		$customers = array();
		foreach($this->Customer->get_all()->result() as $customer)
		{
			$customers[$customer->person_id] = $customer->first_name .' '.$customer->last_name;
		}
		$data['specific_input_data'] = $customers;
		$this->load->view("reports/specific_input",$data);	
	}

	function specific_customer($start_date, $end_date, $customer_id, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->specific_customer($start_date, $end_date, $customer_id, $sale_type, $export_excel));
		$this->load->view('reports/tabular_details',$data);
	}
	
	function specific_employee_input()
	{
		$data = $this->_get_common_report_data();
		$data['specific_input_name'] = $this->lang->line('reports_employee');
		
		$employees = array();
		foreach($this->Employee->get_all()->result() as $employee)
		{
			$employees[$employee->person_id] = $employee->first_name .' '.$employee->last_name;
		}
		$data['specific_input_data'] = $employees;
		$this->load->view("reports/specific_input",$data);	
	}

	function specific_employee($start_date, $end_date, $employee_id, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->specific_employee($start_date, $end_date, $employee_id, $sale_type, $export_excel));
		$this->load->view('reports/tabular_details',$data);
	}
	
    function specific_item_input($item=null)
	{
		$data = $this->_get_common_report_data();
		$data['specific_input_name'] = $this->lang->line('reports_item');
	    $items = array();
		
		foreach($this->Item->get_all()->result() as $item)
		{
			$items[$item->item_id] = $item->name;
		}
		
		$data['specific_input_data'] = $items;
		
		$this->load->view("reports/specific_input",$data);
		
	}
	
	function specific_item($start_date, $end_date, $employee_id, $sale_type, $export_excel=0)
	{
	    $data = array('report_service' => $this->Service->specific_item($start_date, $end_date, $employee_id, $sale_type, $export_excel));
		$this->load->view('reports/tabular_details',$data);
	}
	
	function detailed_sales($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->detailed_sales($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular_details',$data);
	}
	
	function detailed_receivings($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$data = array('report_service' => $this->Service->detailed_receivings($start_date, $end_date, $sale_type, $export_excel));
		$this->load->view('reports/tabular_details',$data);
	}
			
	function excel_export()
	{
		$this->load->view("reports/excel_export",array());		
	}
	
	function inventory_low($export_excel=0)
	{
		$data = array('report_service' => $this->Service->inventory_low($export_excel));
		$this->load->view('reports/tabular',$data);
	}
	
	function inventory_summary($export_excel=0)
	{
		$data = array('report_service' => $this->Service->inventory_summary($export_excel));
		$this->load->view('reports/tabular',$data);
	}	
	
	function get_view($report)
	{
	    switch ($report) {
	        case 'summary_sales':
	        case 'summary_categories':
	        case 'summary_customers':
	        case 'summary_items':
	        case 'summary_employees':
	        case 'summary_discounts':
            case 'summary_taxes':
	        case 'summary_payments':
	        case 'inventory_summary':
	        case 'intentory_low':
	            return 'reports/tabular';
	        case 'specific_item':
	        case 'specific_employee':
	        case 'specific_customer':
	        case 'detailed_sales':
	        case 'detailed_receivings':
	            //everything else is handled through the service
	            return 'reports/tabular_details';
	    }
	    
	    return null;
	}
	
}
?>
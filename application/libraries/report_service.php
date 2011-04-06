<?php

require_once (APPPATH."libraries/ofc-library/open-flash-chart.php");

/**
 * 
 * A service to handle different reports
 * @author relwell
 *
 */

class Report_Service
{
    function __construct()
    {
        // do we really need the &?
        $this->CI = &get_instance();
    }
    
    function summary_sales($start_date, $end_Date, $export_excel=0)
    {
        $this->CI->load->model('reports/Summary_sales');
		$model = $this->CI->Summary_sales;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['sale_date'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_sales_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		return $this->_display($this->CI->load->view("reports/tabular",$data, true));
    }
    
    function summary_categories($start_date, $end_date, $export_excel=0)
    {
        $this->CI->load->model('reports/Summary_categories');
		$model = $this->CI->Summary_categories;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['category'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_categories_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
    }
    
    function summary_customers($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_customers');
		$model = $this->CI->Summary_customers;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['customer'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_customers_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
	
    function summary_suppliers($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_suppliers');
		$model = $this->CI->Summary_suppliers;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['supplier'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_suppliers_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
	
    function summary_items($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_items');
		$model = $this->CI->Summary_items;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array(character_limiter($row['name'], 16), $row['quantity_purchased'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_items_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);
		
		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
	
    function summary_employees($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_employees');
		$model = $this->CI->Summary_employees;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['employee'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_employees_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
	
    function summary_taxes($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_taxes');
		$model = $this->CI->Summary_taxes;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['percent'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_taxes_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
	
    function summary_discounts($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_discounts');
		$model = $this->CI->Summary_discounts;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['discount_percent'],$row['count']);
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_discounts_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
	
    function summary_payments($start_date, $end_date, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_payments');
		$model = $this->CI->Summary_payments;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['payment_type'],to_currency($row['payment_amount']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_payments_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"export_excel" => $export_excel
		);

		$this->_display($this->CI->load->view("reports/tabular",$data,true));
	}
    
	function graphical_summary_sales($start_date, $end_date)
	{
	    $this->CI->load->model('reports/Summary_sales');
		$model = $this->CI->Summary_sales;

		$data = array(
			"title" => $this->CI->lang->line('reports_sales_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_sales_graph/$start_date/$end_date"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_sales_graph($start_date, $end_date)
	{
		$this->CI->load->model('reports/Summary_sales');
		$model = $this->CI->Summary_sales;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[date('m/d/Y', strtotime($row['sale_date']))]= $row['total'];
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_sales_summary_report'),
			"yaxis_label"=>$this->CI->lang->line('reports_revenue'),
			"xaxis_label"=>$this->CI->lang->line('reports_date'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/line",$data,true));

	}
	
    function graphical_summary_items($start_date, $end_date)
	{
		$this->CI->load->model('reports/Summary_items');
		$model = $this->CI->Summary_items;

		$data = array(
			"title" => $this->CI->lang->line('reports_items_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_items_graph/$start_date/$end_date"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_items_graph($start_date, $end_date)
	{
		$this->CI->load->model('reports/Summary_items');
		$model = $this->CI->Summary_items;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['name']] = $row['total'];
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_items_summary_report'),
			"xaxis_label"=>$this->CI->lang->line('reports_revenue'),
			"yaxis_label"=>$this->CI->lang->line('reports_items'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/hbar",$data,true));
	}
	
	
    /**
     * Sets the option to suppress echo and return HTML.
     * 
     * @param bool $val
     */
    public function setSuppressEcho($val)
    {
        $this->_suppressEcho = $val;
    }
    
    /**
     * We want the option to retain the HTML from the helper instead of echoing it out.
     * @param string $html
     */
    private function _display($html)
    {
        if ($this->_suppressEcho) {
            return $html;
        } else {
            echo $html;
            return true;
        }
    }
    
}
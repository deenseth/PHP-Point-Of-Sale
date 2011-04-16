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
    
    function summary_sales($start_date, $end_date, $sale_type, $export_excel=0)
    {
        $this->CI->load->model('reports/Summary_sales');
		$model = $this->CI->Summary_sales;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['sale_date'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_sales_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type' => $sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);
		
		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
    }
    
    function summary_categories($start_date, $end_date, $sale_type, $export_excel=0)
    {
        $this->CI->load->model('reports/Summary_categories');
		$model = $this->CI->Summary_categories;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['category'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_categories_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
    }
    
    function summary_customers($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_customers');
		$model = $this->CI->Summary_customers;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['customer'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_customers_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
	
    function summary_suppliers($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_suppliers');
		$model = $this->CI->Summary_suppliers;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['supplier'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_suppliers_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
	
    function summary_items($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_items');
		$model = $this->CI->Summary_items;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array(character_limiter($row['name'], 16), $row['quantity_purchased'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_items_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);
		
		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
	
    function summary_employees($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_employees');
		$model = $this->CI->Summary_employees;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['employee'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_employees_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
	
    function summary_taxes($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_taxes');
		$model = $this->CI->Summary_taxes;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['percent'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_taxes_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
	
    function summary_discounts($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_discounts');
		$model = $this->CI->Summary_discounts;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['discount_percent'],$row['count']);
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_discounts_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
	
    function summary_payments($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Summary_payments');
		$model = $this->CI->Summary_payments;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['payment_type'],to_currency($row['payment_amount']));
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_payments_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
	}
    
	function graphical_summary_sales($start_date, $end_date, $sale_type)
	{
	    $this->CI->load->model('reports/Summary_sales');
		$model = $this->CI->Summary_sales;

		$data = array(
			"title" => $this->CI->lang->line('reports_sales_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_sales_graph/$start_date/$end_date"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_sales_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_sales');
		$model = $this->CI->Summary_sales;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
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
	
    function graphical_summary_items($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_items');
		$model = $this->CI->Summary_items;

		$data = array(
			"title" => $this->CI->lang->line('reports_items_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_items_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_items_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_items');
		$model = $this->CI->Summary_items;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
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
	
    function graphical_summary_categories($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_categories');
		$model = $this->CI->Summary_categories;

		$data = array(
			"title" => $this->CI->lang->line('reports_categories_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_categories_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_categories_graph($start_date, $end_date)
	{
		$this->CI->load->model('reports/Summary_categories');
		$model = $this->CI->Summary_categories;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['category']] = $row['total'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_categories_summary_report'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/pie",$data,true));
	}
	
    function graphical_summary_suppliers($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_suppliers');
		$model = $this->CI->Summary_suppliers;

		$data = array(
			"title" => $this->CI->lang->line('reports_suppliers_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_suppliers_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_suppliers_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_suppliers');
		$model = $this->CI->Summary_suppliers;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['supplier']] = $row['total'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_suppliers_summary_report'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/pie",$data,true));
	}
	
    function graphical_summary_employees($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_employees');
		$model = $this->CI->Summary_employees;

		$data = array(
			"title" => $this->CI->lang->line('reports_employees_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_employees_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_employees_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_employees');
		$model = $this->CI->Summary_employees;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['employee']] = $row['total'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_employees_summary_report'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/pie",$data,true));
	}
	
	function graphical_summary_taxes($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_taxes');
		$model = $this->CI->Summary_taxes;

		$data = array(
			"title" => $this->CI->lang->line('reports_taxes_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_taxes_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_taxes_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_taxes');
		$model = $this->CI->Summary_taxes;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, $sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['percent']] = $row['total'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_taxes_summary_report'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/pie",$data,true));
	}
	
    function graphical_summary_customers($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_customers');
		$model = $this->CI->Summary_customers;

		$data = array(
			"title" => $this->CI->lang->line('reports_customers_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_customers_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_customers_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_customers');
		$model = $this->CI->Summary_customers;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['customer']] = $row['total'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_customers_summary_report'),
			"xaxis_label"=>$this->CI->lang->line('reports_revenue'),
			"yaxis_label"=>$this->CI->lang->line('reports_customers'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/hbar",$data,true));
	}
	
    function graphical_summary_discounts($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_discounts');
		$model = $this->CI->Summary_discounts;

		$data = array(
			"title" => $this->CI->lang->line('reports_discounts_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_discounts_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_discounts_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_discounts');
		$model = $this->CI->Summary_discounts;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['discount_percent']] = $row['count'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_discounts_summary_report'),
			"yaxis_label"=>$this->CI->lang->line('reports_count'),
			"xaxis_label"=>$this->CI->lang->line('reports_discount_percent'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/bar",$data,true));
	}
	
    function graphical_summary_payments($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_payments');
		$model = $this->CI->Summary_payments;

		$data = array(
			"title" => $this->CI->lang->line('reports_payments_summary_report'),
			"data_file" => site_urL("reports/graphical_summary_payments_graph/$start_date/$end_date/$sale_type"),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type))
		);

		$this->_display($this->CI->load->view("reports/graphical",$data,true));
	}
	
    function graphical_summary_payments_graph($start_date, $end_date, $sale_type)
	{
		$this->CI->load->model('reports/Summary_payments');
		$model = $this->CI->Summary_payments;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['payment_type']] = $row['payment_amount'];
		}
		
		$data = array(
			"title" => $this->CI->lang->line('reports_payments_summary_report'),
			"yaxis_label"=>$this->CI->lang->line('reports_revenue'),
			"xaxis_label"=>$this->CI->lang->line('reports_payment_type'),
			"data" => $graph_data
		);

		$this->_display($this->CI->load->view("reports/graphs/pie",$data,true));
	}
	
    function specific_customer($start_date, $end_date, $customer_id, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Specific_customer');
		$model = $this->CI->Specific_customer;
		
		$headers = $model->getDataColumns();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'customer_id' =>$customer_id, 'sale_type'=>$sale_type));
		
		$summary_data = array();
		$details_data = array();
		
		foreach($report_data['summary'] as $key=>$row)
		{
			$summary_data[] = array(anchor('sales/receipt/'.$row['sale_id'], 'POS '.$row['sale_id'], array('target' => '_blank')), $row['sale_date'], $row['items_purchased'], $row['employee_name'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']), $row['payment_type'], $row['comment']);
			
			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$key][] = array($drow['name'], $drow['category'], $drow['serialnumber'], $drow['description'], $drow['quantity_purchased'], to_currency($drow['subtotal']), to_currency($drow['total']), to_currency($drow['tax']),to_currency($drow['profit']), $drow['discount_percent'].'%');
			}
		}

		$customer_info = $this->CI->Customer->get_info($customer_id);
		$data = array(
			"title" => $customer_info->first_name .' '. $customer_info->last_name.' '.$this->CI->lang->line('reports_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"summary_data" => $summary_data,
			"details_data" => $details_data,
			"overall_summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date,'customer_id' =>$customer_id, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    'report_params'       => serialize(array('customer_id'=>$customer_id)),
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_details_report', 'data'=>$data);
		return $this;
	}
	
    function specific_employee($start_date, $end_date, $employee_id, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Specific_employee');
		$model = $this->CI->Specific_employee;
		
		$headers = $model->getDataColumns();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'employee_id' =>$employee_id, 'sale_type'=>$sale_type));
		
		$summary_data = array();
		$details_data = array();
		
		foreach($report_data['summary'] as $key=>$row)
		{
			$summary_data[] = array(anchor('sales/receipt/'.$row['sale_id'], 'POS '.$row['sale_id'], array('target' => '_blank')), $row['sale_date'], $row['items_purchased'], $row['customer_name'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']), $row['payment_type'], $row['comment']);
			
			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$key][] = array($drow['name'], $drow['category'], $drow['serialnumber'], $drow['description'], $drow['quantity_purchased'], to_currency($drow['subtotal']), to_currency($drow['total']), to_currency($drow['tax']),to_currency($drow['profit']), $drow['discount_percent'].'%');
			}
		}

		$employee_info = $this->CI->Employee->get_info($employee_id);
		$data = array(
			"title" => $employee_info->first_name .' '. $employee_info->last_name.' '.$this->CI->lang->line('reports_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"summary_data" => $summary_data,
			"details_data" => $details_data,
			"overall_summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date,'employee_id' =>$employee_id, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
			'report_params'       => serialize(array('employee_id'=>$employee_id)),
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_details_report', 'data'=>$data);
		return $this;
	}
	
    function specific_item($start_date, $end_date, $item_id, $sale_type, $export_excel=0)
	{
	    $this->CI->load->model('reports/Specific_item');
		$model = $this->CI->Specific_item;
		
		$item = $this->CI->Item->get_info($item_id);
		
		$headers = $model->getDataColumns();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'item_id' =>$item_id, 'sale_type'=>$sale_type));
        $summary_data = array();
		foreach ($report_data as $key=>$data)
		{
		    $row = array_shift($data);
		    $summary_data[]= array($row['person_id'], $row['customer_name'], $row['sale_date'], $row['quantity_purchased'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']), to_currency($row['profit']), to_currency($row['discount']));
		}
		
		$add = ($key = $this->CI->Appconfig->get('mc_api_key'));
		
		$data = array(
			"title" => ucwords($item->name).' '.$this->CI->lang->line('reports_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"summary_data" => $summary_data,
			"overall_summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date,'item_id'=>$item->item_id)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__,
		    'report_params'       => serialize(array('item_id'=>$item_id)),
		    "add_to_group" => $add
		);

		$this->renderData = array('script'=>'partial/tabular_details_report', 'data'=>$data);
		return $this;
	}
	
    function detailed_sales($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->CI->load->model('reports/Detailed_sales');
		$model = $this->CI->Detailed_sales;
		
		$headers = $model->getDataColumns();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));
		
		$summary_data = array();
		$details_data = array();
		
		foreach($report_data['summary'] as $key=>$row)
		{
			$summary_data[] = array(anchor('sales/receipt/'.$row['sale_id'], 'POS '.$row['sale_id'], array('target' => '_blank')), $row['sale_date'], $row['items_purchased'], $row['employee_name'], $row['customer_name'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']),to_currency($row['profit']), $row['payment_type'], $row['comment']);
			
			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$key][] = array($drow['name'], $drow['category'], $drow['serialnumber'], $drow['description'], $drow['quantity_purchased'], to_currency($drow['subtotal']), to_currency($drow['total']), to_currency($drow['tax']),to_currency($drow['profit']), $drow['discount_percent'].'%');
			}
		}

		$data = array(
			"title" =>$this->CI->lang->line('reports_detailed_sales_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"summary_data" => $summary_data,
			"details_data" => $details_data,
			"overall_summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type)),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_details_report', 'data'=>$data);
		return $this;
	}
	
	function detailed_receivings($start_date, $end_date, $sale_type, $export_excel=0)
	{
	    $this->CI->load->model('reports/Detailed_receivings');
		$model = $this->Detailed_receivings;
		
		$headers = $model->getDataColumns();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type' => $sale_type));
		
		$summary_data = array();
		$details_data = array();
		
		foreach($report_data['summary'] as $key=>$row)
		{
			$summary_data[] = array(anchor('receivings/receipt/'.$row['receiving_id'], 'RECV '.$row['receiving_id'], array('target' => '_blank')), $row['receiving_date'], $row['items_purchased'], $row['employee_name'], $row['supplier_name'], to_currency($row['total']), $row['payment_type'], $row['comment']);
			
			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$key][] = array($drow['name'], $drow['category'], $drow['quantity_purchased'], to_currency($drow['total']), $drow['discount_percent'].'%');
			}
		}

		$data = array(
			"title" =>$this->lang->line('reports_detailed_receivings_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"summary_data" => $summary_data,
			"details_data" => $details_data,
			"overall_summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type' => $sale_type)),
			"export_excel" => $export_excel
		);

		$this->renderData = array('script'=>'partial/tabular_details_report', 'data'=>$data);
		return $this;
	}
	
    function inventory_low($export_excel=0)
	{
		$this->CI->load->model('reports/Inventory_low');
		$model = $this->CI->Inventory_low;
		$tabular_data = array();
		$report_data = $model->getData(array());
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['name'], $row['item_number'], $row['description'], $row['quantity'], $row['reorder_level']);
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_low_inventory_report'),
			"subtitle" => '',
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array()),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
	}
	
    function inventory_summary($export_excel=0)
	{
		$this->CI->load->model('reports/Inventory_summary');
		$model = $this->CI->Inventory_summary;
		$tabular_data = array();
		$report_data = $model->getData(array());
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['name'], $row['item_number'], $row['description'], $row['quantity'], $row['reorder_level']);
		}

		$data = array(
			"title" => $this->CI->lang->line('reports_inventory_summary_report'),
			"subtitle" => '',
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array()),
			"export_excel" => $export_excel,
		    "report_name"  => __FUNCTION__
		);

		$this->renderData = array('script'=>'partial/tabular_report', 'data'=>$data);
		return $this;
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
    
    public function render()
    {
        $this->_suppressEcho = true;
        return $this->_display($this->CI->load->view($this->renderData['script'], $this->renderData['data'], true));
    }
    
}
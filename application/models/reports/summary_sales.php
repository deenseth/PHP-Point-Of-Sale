<?php
require_once("report.php");
class Summary_sales extends Report
{
	public function getDataColumns()
	{
		return array($this->lang->line('reports_date'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'));
	}
	
	public function getData(array $inputs)
	{
		return array(
			array('12/01/2009', to_currency('12.40'), to_currency('1.00'), to_currency('13.40')),
			array('12/02/2009', to_currency('12.40'), to_currency('1.00'), to_currency('13.40')),
			array('12/03/2009', to_currency('12.40'), to_currency('1.00'), to_currency('13.40')),
			array('12/04/2009', to_currency('12.40'), to_currency('1.00'), to_currency('13.40')),
			array('12/05/2009', to_currency('12.40'), to_currency('1.00'), to_currency('13.40')),
		);
	}
	
	public function getSummaryData(array $inputs)
	{
		return array(
			'Subtotal'=>'9.50',
			'Tax'=>'9.50',
			'Total'=>'9.50',
		);
	}

}
?>
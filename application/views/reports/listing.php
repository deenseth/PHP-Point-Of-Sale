
<?php $this->load->view("partial/header"); ?>
<h1><?php echo $this->lang->line('reports_reports'); ?></h1>

<div class="panel panel-default">
  		<div class="panel-heading"><?php echo $this->lang->line('reports_graphical_reports'); ?></div>
		<ul class="list-group">
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_sales');?>"><?php echo $this->lang->line('reports_sales'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_categories');?>"><?php echo $this->lang->line('reports_categories'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_customers');?>"><?php echo $this->lang->line('reports_customers'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_suppliers');?>"><?php echo $this->lang->line('reports_suppliers'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_items');?>"><?php echo $this->lang->line('reports_items'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_employees');?>"><?php echo $this->lang->line('reports_employees'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_taxes');?>"><?php echo $this->lang->line('reports_taxes'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_discounts');?>"><?php echo $this->lang->line('reports_discounts'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/graphical_summary_payments');?>"><?php echo $this->lang->line('reports_payments'); ?></a></li>
		</ul>
</div>	

<div class="panel panel-default">
  		<div class="panel-heading"><?php echo $this->lang->line('reports_summary_reports'); ?></div>
		<ul class="list-group">
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_sales');?>"><?php echo $this->lang->line('reports_sales'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_categories');?>"><?php echo $this->lang->line('reports_categories'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_customers');?>"><?php echo $this->lang->line('reports_customers'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_suppliers');?>"><?php echo $this->lang->line('reports_suppliers'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_items');?>"><?php echo $this->lang->line('reports_items'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_employees');?>"><?php echo $this->lang->line('reports_employees'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_taxes');?>"><?php echo $this->lang->line('reports_taxes'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_discounts');?>"><?php echo $this->lang->line('reports_discounts'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/summary_payments');?>"><?php echo $this->lang->line('reports_payments'); ?></a></li>
		</ul>
</div>

<div class="panel panel-default">
  		<div class="panel-heading"><?php echo $this->lang->line('reports_summary_reports'); ?></div>
		<ul class="list-group">
			<li class="list-group-item"><a href="<?php echo site_url('reports/detailed_sales');?>"><?php echo $this->lang->line('reports_sales'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/detailed_receivings');?>"><?php echo $this->lang->line('reports_receivings'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/specific_customer');?>"><?php echo $this->lang->line('reports_customer'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/specific_employee');?>"><?php echo $this->lang->line('reports_employee'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/specific_item');?>"><?php echo $this->lang->line('reports_items'); ?></a></li>
		</ul>
</div>	

<div class="panel panel-default">
  		<div class="panel-heading"><?php echo $this->lang->line('reports_summary_reports'); ?></div>
		<ul class="list-group">
			<li class="list-group-item"><a href="<?php echo site_url('reports/inventory_low');?>"><?php echo $this->lang->line('reports_low_inventory'); ?></a></li>
			<li class="list-group-item"><a href="<?php echo site_url('reports/inventory_summary');?>"><?php echo $this->lang->line('reports_inventory_summary'); ?></a></li>
		</ul>
</div>	

<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>

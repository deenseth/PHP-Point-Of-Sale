<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>
<div id="welcome_message"><?php echo $this->lang->line('reports_welcome_message'); ?>
<ul id="report_list">
	<li>Summary Reports
		<ul>
			<li><a href="<?php echo site_url('reports/summary_sales');?>">Sales</a></li>
			<li><a href="<?php echo site_url('reports/summary_categories');?>">Categories</a></li>
			<li><a href="<?php echo site_url('reports/summary_customers');?>">Customers</a></li>
			<li><a href="<?php echo site_url('reports/summary_items');?>">Items</a></li>
			<li><a href="<?php echo site_url('reports/summary_employees');?>">Employees</a></li>
		</ul>
</ul>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
});
</script>

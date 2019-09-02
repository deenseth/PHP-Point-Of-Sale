<?php $this->load->view("partial/header"); ?>
<div class="panel panel-default">
	<div class="panel-heading">Daily Totals</div>
	<ul class="list-group">	
	<?php foreach($sales_totals as $sales_total) { ?>
		<li class="list-group-item"><?php echo $sales_total['payment_type']. ': '.to_currency($sales_total['total']); ?></li>
	<?php }?>
		<li class="list-group-item">Total: <?php echo to_currency($final_total); ?></li>
	</ul>
	<div class="panel-body">
		<div class="row">
		  <div class="col-xs-6"><a id="print_btn" href="<?php echo site_url("home/print_totals");?>" type="button" class="btn btn-primary btn-lg btn-block"><?php echo $this->lang->line('common_print_totals'); ?></a></div>
		  <div class="col-xs-6"><a id="logout_btn" href="<?php echo site_url("home/logout");?>" type="button" class="btn btn-default btn-lg btn-block"><?php echo $this->lang->line('common_logout'); ?></a></div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>
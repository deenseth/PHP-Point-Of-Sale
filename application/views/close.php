<?php $this->load->view("partial/header"); ?>
<div class="panel panel-default">
	<div class="panel-heading">Daily Totals</div>
	<ul class="list-group">	
	<?php foreach($sales_totals as $sales_total) { ?>
		<li class="list-group-item"><?php echo $sales_total['payment_type']. ': '.to_currency($sales_total['total']); ?></li>
	<?php }?>
	</ul>
</div>
<?php $this->load->view("partial/footer"); ?>
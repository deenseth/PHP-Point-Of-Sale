<?php $this->load->view("partial/header"); ?>
<div id="receipt_wrapper">
	<div id="receipt_header">
		<div id="company_name"><?php echo $this->config->item('company'); ?></div>
		<div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
		<div id="sale_receipt"><?php echo $this->lang->line('sales_receipt'); ?></div>
		<div id="sale_time"><?php echo date('m/d/Y h:i:s a'); ?></div>
	</div>
	<div id="recipt_general_info">
		<?php if(isset($customer))
		{
		?>
			<div id="customer"><?php echo $this->lang->line('customers_customer').": ".$customer; ?></div>
		<?php
		}
		?>
		<div id="sale_id"><?php echo $this->lang->line('sales_id').": ".$sale_id; ?></div>
		<div id="employee"><?php echo $this->lang->line('employees_employee').": ".$employee; ?></div>
	</div>
	
	<table id="receipt_items">
	<tr>
	<th style="width:50%;"><?php echo $this->lang->line('items_name'); ?></th>
	<th style="width:17%;"><?php echo $this->lang->line('items_unit_price'); ?></th>
	<th style="width:16%;text-align:center;"><?php echo $this->lang->line('sales_quantity'); ?></th>
	<th style="width:17%;text-align:right;"><?php echo $this->lang->line('sales_total'); ?></th>
	</tr>
	<?php
	foreach($cart as $item_id=>$item)
	{
	?>
		<tr>
		<td><?php echo $item['name']; ?></td>
		<td><?php echo to_currency($item['price']); ?></td>
		<td style='text-align:center;'><?php echo $item['quantity']; ?></td>
		<td style='text-align:right;'><?php echo to_currency($item['price']*$item['quantity']); ?></td>
		</tr>
	<?php
	}
	?>
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td style='text-align:left;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
	<td style='text-align:right;border-top:2px solid #000000;'><?php echo $subtotal; ?></td>
	</tr>
	
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>	
	<td style='text-align:left'><?php echo $this->lang->line('sales_tax'); ?></td>
	<td style='text-align:right;'><?php echo $tax; ?></td>
	</tr>
	
	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>	
	<td style='text-align:left'><?php echo $this->lang->line('sales_total'); ?></td>
	<td style='text-align:right'><?php echo $total; ?></td>	
	</tr>
	</table>
</div>

<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript">
$(document).ready(function()
{
	window.print();
});
</script>

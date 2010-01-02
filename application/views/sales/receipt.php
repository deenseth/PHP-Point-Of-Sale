<?php $this->load->view("partial/header"); ?>
<div id="receipt_wrapper">
	<div id="receipt_header">
		<div id="company_name"><?php echo $this->config->item('company'); ?></div>
		<div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
		<div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
		<div id="sale_receipt"><?php echo $receipt_title; ?></div>
		<div id="sale_time"><?php echo $transaction_time ?></div>
	</div>
	<div id="receipt_general_info">
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
	<th style="width:50%;"><?php echo $this->lang->line('items_item'); ?></th>
	<th style="width:17%;"><?php echo $this->lang->line('common_price'); ?></th>
	<th style="width:16%;text-align:center;"><?php echo $this->lang->line('sales_quantity'); ?></th>
	<th style="width:17%;text-align:right;"><?php echo $this->lang->line('sales_total'); ?></th>
	</tr>
	<?php
	foreach($cart as $item_id=>$item)
	{
	?>
		<tr>
		<td><span class='long_name'><?php echo $item['name']; ?></span><span class='short_name'><?php echo character_limiter($item['name'],10); ?></span></td>
		<td><?php echo to_currency($item['price']); ?></td>
		<td style='text-align:center;'><?php echo $item['quantity']; ?></td>
		<td style='text-align:right;'><?php echo to_currency($item['price']*$item['quantity']); ?></td>
		</tr>
	<?php
	}
	?>
	<tr>
	<td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('sales_sub_total'); ?></td>
	<td style='text-align:right;border-top:2px solid #000000;'><?php echo $subtotal; ?></td>
	</tr>
	
	<?php foreach($taxes as $name=>$value) { ?>
		<tr>
			<td colspan="3" style='text-align:right;'><?php echo $name; ?>:</td>
			<td style='text-align:right;'><?php echo to_currency($value); ?></td>
		</tr>
	<?php }; ?>
	
	<tr>
	<td colspan="3" style='text-align:right;'><?php echo $this->lang->line('sales_total'); ?></td>
	<td style='text-align:right'><?php echo $total; ?></td>	
	</tr>
	</table>
	
	<div id="sale_return_policy">
	<?php echo nl2br($this->config->item('return_policy')); ?>	
	</div>
	<div id='barcode'>
	<?php echo "<img src='index.php?c=barcode&barcode=$sale_id&text=$sale_id&width=250&height=50' />"; ?>
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}

if (isset($warning))
{
	echo "<div class='warning_mesage'>".$warning."</div>";
}

if (isset($success))
{
	echo "<div class='success_message'>".$success."</div>";
}
?>
<div class="row"></div>
<div class="col-md-9 sale_register_leftbox">
	<div class="panel panel-default">
		<div class="panel-body">
			<table width="100%">
				<tbody>
					<tr>
						<td style="width:10%;">
							<?php echo form_open("sales/change_mode",array('id'=>'mode_form', 'class'=>'form-inline')); ?>
								<?php echo form_dropdown('mode', $modes, $mode,'class="selectpicker mode-dropdown" data-width="100%"'); ?>
							</form>
						</td>
						<td style="width:80%;">
							<?php echo form_open("sales/add",array('id'=>'add_item_form', 'class'=>'content-form')); ?>
								<?php echo form_input(array('name'=>'item','id'=>'item', 'class'=>'form-control item-search' ,'placeholder'=>$this->lang->line('sales_find_or_scan_item_or_receipt')));?>
							</form>
						</td>
						<td style="width:10%; text-align:right;"><?php echo anchor("items/view/-1", $this->lang->line('sales_new_item'), array('class'=>'new-item btn btn-primary','title'=>$this->lang->line('sales_new_item'))); ?></td>
					</tr>
				</tbody>
			</table>
			<br/>
			<?php /* echo anchor("sales/suspended", $this->lang->line('sales_suspended_sales'), array('class'=>'btn btn-primary','title'=>$this->lang->line('sales_suspended_sales'))); */ ?>
			<div class="table-responsive">
				<table id="register" class="item-table table table-striped table-bordered">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('common_delete'); ?></th>
							<th><?php echo $this->lang->line('sales_item_number'); ?></th>
							<th><?php echo $this->lang->line('sales_item_name'); ?></th>
							<th><?php echo $this->lang->line('sales_price'); ?></th>
							<th><?php echo $this->lang->line('sales_quantity'); ?></th>
							<th><?php echo $this->lang->line('sales_discount'); ?></th>
							<th><?php echo $this->lang->line('sales_total'); ?></th>
						</tr>
					</thead>
					<tbody id="cart_contents">
						<?php if(count($cart)==0) { ?>
							<tr class="warning">
								<td colspan='8' style="text-align:center;">
									<b><?php echo $this->lang->line('sales_no_items_in_cart'); ?></b>
								</tr>
							</tr>
						<?php } else { ?>

							<?php foreach(array_reverse($cart, true) as $line=>$item) {
								$cur_item_info = $this->Item->get_info($item['item_id']); ?>
								<tr>
									<td><?php echo anchor("sales/delete_item/$line"," ", array('class'=>'content-submit glyphicon glyphicon-remove'));?></td>
									<td><?php echo $item['item_number']; ?></td>
									<td style="align:center;"><?php echo $item['name']; ?><br /> [<?php echo $cur_item_info->quantity; ?> in stock]</td>

									<?php if ($items_module_allowed) { ?>
										<td>
											<?php echo form_open("sales/edit_item/$line", array('id'=>'edit-iten-' . $line, 'class'=>'content-form')); ?>
												<?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?>
											</form>
										</td>
									<?php } else { ?>
										<td><?php echo $item['price']; ?></td>
									<?php } ?>
									<td>
										<?php if($item['is_serialized']==1) {
											echo $item['quantity'];
										} else { ?>
											<?php echo form_open("sales/edit_item/$line", array('id'=>'edit-iten-' . $line, 'class'=>'content-form')); ?>
												<?php echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2')); ?>
											</form>
										<?php } ?>
									</td>
									<td>
										<?php echo form_open("sales/edit_item/$line", array('id'=>'edit-iten-' . $line, 'class'=>'content-form')); ?>
											<?php echo form_input(array('name'=>'discount','value'=>$item['discount'],'size'=>'3'));?>
										</form>
									</td>
									<td><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3 sale_register_rightbox">
	<div class="panel panel-default">
  		<div class="panel-body">
  			<?php if(count($cart) > 0) { ?>
	  			<?php echo form_open("sales/cancel_sale",array('id'=>'cancel_sale_form', 'class'=>'content-form')); ?></form>
	  			<?php echo form_open("sales/suspend",array('id'=>'suspend_sale_form', 'class'=>'content-form')); ?></form>
	  			<div class="btn-group btn-group-justified">
	  				<div class='btn btn-warning' id='suspend_sale_button'><?php echo $this->lang->line('sales_suspend_sale') ?></div>
	  				<div class='btn btn-danger' id='cancel_sale_button'><?php echo $this->lang->line('sales_cancel_sale'); ?></div>
	  			</div>
  				<hr>
  			<?php } ?>	
				<?php if(isset($customer)) { ?>
					<table width="100%">
						<tbody>
							<tr>
								<td><h4><?php echo $customer . " " ?></h4></td>
								<td style="text-align:right;"><?php echo anchor("sales/delete_customer", " ", array('class'=>'content-submit glyphicon glyphicon-remove')); ?></td>
							</tr>
						</tbody>
					</table>
				<?php } else { ?>
					<?php echo form_open("sales/select_customer",array('role'=>'form', 'class'=>'form content-form', 'id'=>'select_customer_form')); ?>
						<table width="100%">
							<tbody>
								<tr>
									<td style="width:90%;"><?php echo form_input(array('class'=>'form-control', 'name'=>'customer','id'=>'customer','placeholder'=>$this->lang->line('sales_start_typing_customer_name')));?></td>
									<td style="width:10%; text-align:right;"><?php echo anchor("customers/view/-1", "New", array('class'=>'new-customer btn btn-primary','title'=>$this->lang->line('sales_new_customer'))); ?></td>
								</tr>
							</tbody>
						</table>
					</form>
				<?php } ?>
		<hr>
		<h4><?php echo $this->lang->line('totals'); ?></h4>
		<table width="100%" class="totals">
			<tr class="bg-info">
				<td>
					<?php echo $this->lang->line('sales_sub_total'); ?>:	
				</td>
				<td style="text-align:right;">
					<?php echo to_currency($subtotal); ?>
				</td>
			</tr>
			<?php foreach($taxes as $name=>$value) { ?>
				<tr class="bg-warning">
					<td>
						<?php echo $name; ?>:	
					</td>
					<td style="text-align:right;">
						<?php echo to_currency($value); ?>
					</td>
				</tr>
			<?php }; ?>
			<tr class="bg-success">
				<td>
					<b><?php echo $this->lang->line('sales_total'); ?>:</b>
				</td>
				<td style="text-align:right;">
					<b><?php echo to_currency($total); ?></b>
				</td>
			</tr>
		</table>

		<hr>
		<h4><?php echo $this->lang->line('payments'); ?></h4>
		<?php echo form_open("sales/add_payment",array('id'=>'add_payment_form', 'class'=>'form-inline content-form')); ?>
			<table width="100%">
				<tbody>
					<tr>
						<td style="width:90%;"><?php echo form_input(array('class'=>'form-control', 'name'=>'amount_tendered','id'=>'amount_tendered','value'=>to_currency_no_money($amount_due), 'placeholder'=>$this->lang->line('sales_amount_tendered')));?></td>
						<td style="width:10%;"><?php echo form_dropdown('payment_type', $payment_options, array(), 'class="payment-type selectpicker" data-width="100%"');?></td>
					</tr>
				</tbody>
			</table>	
		</form>
		<div class='btn btn-primary form-control' id='sales-add-payment'><?php echo $this->lang->line('sales_add_payment') ?></div>
		<?php if(count($payments) > 0) { ?>
			<table class="table table-bordered" id="register">
				<thead>
					<tr>
						<th style="width:11%;"><?php echo $this->lang->line('common_delete'); ?></th>
						<th style="width:60%;"><?php echo 'Type'; ?></th>
						<th style="width:18%;"><?php echo 'Amount'; ?></th>
					</tr>
				</thead>
				<tbody id="payment_contents">
					<?php
					foreach($payments as $payment_id=>$payment)
					{
						echo form_open("sales/edit_payment/$payment_id",array('id'=>'edit_payment_form'.$payment_id, 'class'=>'content-form'));
						?>
						<tr>
							<td><?php echo anchor("sales/delete_payment/$payment_id", ' ', array('class'=>'content-submit glyphicon glyphicon-remove'));?></td>
							<td><?php echo  $payment['payment_type']    ?> </td>
							<td style="text-align:right;"><?php echo  to_currency($payment['payment_amount'])  ?>  </td>
						</tr>
					</form>
					<?php
				}
				?>
				</tbody>
			</table>
			<table width="100%" class="totals">
			<tr class="bg-warning">
				<td><?php echo 'Payments Total:' ?></td>
				<td style="text-align:right;"><?php echo to_currency($payments_total); ?></td>
			</tr>
			<tr class="bg-danger">
				<td><b><?php echo 'Amount Due:' ?></b></td>
				<td style="text-align:right;"><b><?php echo to_currency($amount_due); ?></b></td>
			</tr>
		</table>
		<hr>
		<?php } ?>

		<?php if(count($cart) > 0) { ?>
			<?php if(count($payments) > 0) { ?>	
					<?php echo form_open("sales/complete",array('id'=>'finish_sale_form')); ?></form>
					<div class="form-group">
						<?php echo form_textarea(array('name'=>'comment','value'=>'','rows'=>'4','class'=>'form-control', 'placeholder'=>$this->lang->line('common_comments')));?>
					</div>
					<div class="btn-group btn-group-justified">
						<div class='btn btn-success' id='finish_sale_button'><?php echo $this->lang->line('sales_complete_sale') ?></div>	
					</div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
</div>

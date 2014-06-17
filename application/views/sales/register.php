<?php $this->load->view("partial/header"); ?>
<h1><?php echo $this->lang->line('sales_register'); ?></h1>
<hr>
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
			<?php echo form_open("sales/change_mode",array('id'=>'mode_form')); ?>
			<span><?php echo $this->lang->line('sales_mode') ?></span>
			<?php echo form_dropdown('mode',$modes,$mode,'onchange="$(\'#mode_form\').submit();"'); ?>
			<div id="show_suspended_sales_button">
				<?php echo anchor("sales/suspended",
					"<div class='small_button'><span style='font-size:73%;'>".$this->lang->line('sales_suspended_sales')."</span></div>",
					array('class'=>'thickbox none','title'=>$this->lang->line('sales_suspended_sales')));
					?>
				</div>
			</form>

			<?php
			$itemPlaceHolder;

			if($mode=='sale')
			{
				$itemPlaceHolder = $this->lang->line('sales_find_or_scan_item');
			}
			else
			{
				$itemPlaceHolder = $this->lang->line('sales_find_or_scan_item_or_receipt');
			}
			?>

			<?php echo form_open("sales/add",array('id'=>'add_item_form')); ?>
			<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40','placeholder'=>$itemPlaceHolder));?>
			<div id="new_item_button_register" >
				<?php echo anchor("items/view/-1",
					"<div class='small_button'><span>".$this->lang->line('sales_new_item')."</span></div>",
					array('class'=>'thickbox none','title'=>$this->lang->line('sales_new_item')));
					?>
				</div>

			</form>
			<table id="register">
				<thead>
					<tr>
						<th style="width:11%;"><?php echo $this->lang->line('common_delete'); ?></th>
						<th style="width:30%;"><?php echo $this->lang->line('sales_item_number'); ?></th>
						<th style="width:30%;"><?php echo $this->lang->line('sales_item_name'); ?></th>
						<th style="width:11%;"><?php echo $this->lang->line('sales_price'); ?></th>
						<th style="width:11%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
						<th style="width:11%;"><?php echo $this->lang->line('sales_discount'); ?></th>
						<th style="width:15%;"><?php echo $this->lang->line('sales_total'); ?></th>
					</tr>
				</thead>
				<tbody id="cart_contents">
					<?php
					if(count($cart)==0)
					{
						?>
						<tr><td colspan='8'>
							<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
						</tr></tr>
						<?php
					}
					else
					{
						foreach(array_reverse($cart, true) as $line=>$item)
						{
							$cur_item_info = $this->Item->get_info($item['item_id']);
							echo form_open("items/view/$line");
							?>
							<tr>
								<td><?php echo anchor("sales/delete_item/$line",'['.$this->lang->line('common_delete').']');?></td>
								<td><?php echo $item['item_number']; ?></td>
								<td style="align:center;"><?php echo $item['name']; ?><br /> [<?php echo $cur_item_info->quantity; ?> in stock]</td>



								<?php if ($items_module_allowed)
								{
									?>
									<td><?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
									<?php
								}
								else
								{
									?>
									<td><?php echo $item['price']; ?></td>
									<?php echo form_hidden('price',$item['price']); ?>
									<?php
								}
								?>

								<td>
									<?php
									if($item['is_serialized']==1)
									{
										echo $item['quantity'];
										echo form_hidden('quantity',$item['quantity']);
									}
									else
									{
										echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2'));
									}
									?>
								</td>

								<td><?php echo form_input(array('name'=>'discount','value'=>$item['discount'],'size'=>'3'));?></td>
								<td><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
							</tr>
							<tr>
								<td style="color:#2F4F4F";><?php echo $this->lang->line('sales_description_abbrv').':';?></td>
								<td colspan=2 style="text-align:left;">

									<?php
									if($item['allow_alt_description']==1)
									{
										echo form_input(array('name'=>'description','value'=>$item['description'],'size'=>'20'));
									}
									else
									{
										if ($item['description']!='')
										{
											echo $item['description'];
											echo form_hidden('description',$item['description']);
										}
										else
										{
											echo 'None';
											echo form_hidden('description','');
										}
									}
									?>
								</td>
								<td>&nbsp;</td>
								<td style="color:#2F4F4F";>
									<?php
									if($item['is_serialized']==1)
									{
										echo $this->lang->line('sales_serial').':';
									}
									?>
								</td>
								<td colspan=3 style="text-align:left;">
									<?php
									if($item['is_serialized']==1)
									{
										echo form_input(array('name'=>'serialnumber','value'=>$item['serialnumber'],'size'=>'20'));
									}
									else
									{
										echo form_hidden('serialnumber', '');
									}
									?>
								</td>


							</tr>
							<tr style="height:3px">
								<td colspan=8 style="background-color:white"> </td>
							</tr>		</form>
							<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="col-md-3 sale_register_rightbox">
	<div class="panel panel-default">
  		<div class="panel-body">
				<?php
				if(isset($customer))
				{
					echo $this->lang->line("sales_customer").': <b>'.$customer. '</b><br />';
					echo anchor("sales/delete_customer",'['.$this->lang->line('common_delete').' '.$this->lang->line('customers_customer').']'); ?>
				<?php } else { ?>
					<?php echo form_open("sales/select_customer",array('role'=>'form', 'class'=>'form')); ?>
						<div class="form-group">
							<?php echo form_input(array('class'=>'form-control', 'name'=>'customer','id'=>'customer','placeholder'=>$this->lang->line('sales_start_typing_customer_name')));?>
						</div>
						<?php echo anchor("customers/view/-1", $this->lang->line('sales_new_customer'), array('class'=>'btn btn-primary','title'=>$this->lang->line('sales_new_customer'))); ?>
					</form>
				<?php
				}
				?>
		<hr>

		<table width="100%">
			<tr>
				<td>
					<?php echo $this->lang->line('sales_sub_total'); ?>:	
				</td>
				<td style="text-align:right;">
					<?php echo to_currency($subtotal); ?>
				</td>
			</tr>
			<?php foreach($taxes as $name=>$value) { ?>
				<tr>
					<td>
						<?php echo $name; ?>:	
					</td>
					<td style="text-align:right;">
						<?php echo to_currency($value); ?>
					</td>
				</tr>
			<?php }; ?>
			<tr>
				<td>
					<?php echo $this->lang->line('sales_total'); ?>:
				</td>
				<td style="text-align:right;">
					<?php echo to_currency($total); ?>
				</td>
			</tr>
		</table>

		<hr>

		<?php echo form_open("sales/add_payment",array('id'=>'add_payment_form')); ?>
			<table width="100%">
				<tr>
					<td>
						<?php echo form_dropdown('payment_type',$payment_options,array(), 'id="payment_types"');?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo form_input(array('class'=>'form-control', 'name'=>'amount_tendered','id'=>'amount_tendered','value'=>to_currency_no_money($amount_due),'size'=>'10', 'placeholder'=>$this->lang->line('sales_amount_tendered')));?>
					</td>
					<td style="text-align:right;">
						<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('sales_add_payment'); ?>" />
					</td>
				</tr>
			</table>
		</form>

		<?php if(count($payments) > 0) { ?>
			<br>
			<table class="table" id="register">
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
						echo form_open("sales/edit_payment/$payment_id",array('id'=>'edit_payment_form'.$payment_id));
						?>
						<tr>
							<td><?php echo anchor("sales/delete_payment/$payment_id", ' ', array('class'=>'glyphicon glyphicon-trash'));?></td>


							<td><?php echo  $payment['payment_type']    ?> </td>
							<td style="text-align:right;"><?php echo  to_currency($payment['payment_amount'])  ?>  </td>
						</tr>
					</form>
					<?php
				}
				?>
				</tbody>
			</table>
			<table width="100%">
			<tr>
				<td><?php echo 'Payments Total:' ?></td>
				<td style="text-align:right;"><b><?php echo to_currency($payments_total); ?></b></td>
			</tr>
			<tr>
				<td><?php echo 'Amount Due:' ?></td>
				<td style="text-align:right;"><b><?php echo to_currency($amount_due); ?></b></td>
			</tr>
		</table>
		<hr>
		<?php } ?>

		<?php if(count($cart) > 0) { ?>
			<?php if(count($payments) > 0) { ?>
					<?php echo form_open("sales/complete",array('id'=>'finish_sale_form')); ?></form>
					<?php echo form_open("sales/cancel_sale",array('id'=>'cancel_sale_form')); ?></form>
					<div class="form-group">
						<?php echo form_textarea(array('name'=>'comment','value'=>'','rows'=>'4','class'=>'form-control', 'placeholder'=>$this->lang->line('common_comments')));?>
					</div>
					<div class="btn-group">
						<div class='btn btn-default	' id='cancel_sale_button'><?php echo $this->lang->line('sales_cancel_sale'); ?></div>
						<div class='btn btn-default' id='suspend_sale_button'><?php echo $this->lang->line('sales_suspend_sale') ?></div>
						<div class='btn btn-success' id='finish_sale_button'><?php echo $this->lang->line('sales_complete_sale') ?></div>	
					</div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#item").autocomplete({source: function (request, response) {

		$.ajax({
			url: "<?php echo site_url("sales/item_search"); ?>",
			data: request,
			dataType: "json",
			type: "POST",
			success: function(data){
				response(data);
			}
		});
  	}, delay:10, minLength:0});

  	$("#customer").autocomplete({source: function (request, response) {

		$.ajax({
			url: "<?php echo site_url("sales/customer_search"); ?>",
			data: request,
			dataType: "json",
			type: "POST",
			success: function(data){
				response(data);
			}
		});
  	}, delay:10, minLength:0});

	$('#item').focus();

    $("#finish_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("sales_confirm_finish_sale"); ?>'))
    	{
    		$('#finish_sale_form').submit();
    	}
    });

	$("#suspend_sale_button").click(function()
	{
		if (confirm('<?php echo $this->lang->line("sales_confirm_suspend_sale"); ?>'))
    	{
			$('#finish_sale_form').attr('action', '<?php echo site_url("sales/suspend"); ?>');
    		$('#finish_sale_form').submit();
    	}
	});

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("sales_confirm_cancel_sale"); ?>'))
    	{
    		$('#cancel_sale_form').submit();
    	}
    });

	$("#add_payment_button").click(function()
	{
	   $('#add_payment_form').submit();
    });

	$("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard)
});

function post_item_form_submit(response)
{
	if(response.success)
	{
		$("#item").attr("value",response.item_id);
		$("#add_item_form").submit();
	}
}

function post_person_form_submit(response)
{
	if(response.success)
	{
		$("#customer").attr("value",response.person_id);
		$("#select_customer_form").submit();
	}
}

function checkPaymentTypeGiftcard()
{
	if ($("#payment_types").val() == "<?php echo $this->lang->line('sales_giftcard'); ?>")
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
		$("#amount_tendered").val('');
		$("#amount_tendered").focus();
	}
	else
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");		
	}
}

</script>

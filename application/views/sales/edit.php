<?php $this->load->view("partial/header"); ?>
<div id="edit_sale_wrapper">
	<h1><?php echo $this->lang->line('sales_edit_sale'); ?> <?php echo $sale_info['sale_id']; ?></h1>
	
	<?php echo form_open("sales/save/".$sale_info['sale_id'],array('id'=>'sales_edit_form')); ?>
	<ul id="error_message_box"></ul>
	
		<div class="field_row clearfix">
		<?php echo form_label($this->lang->line('sales_receipt').':', 'customer'); ?>
			<div class='form_field'>
				<?php echo anchor('sales/receipt/'.$sale_info['sale_id'], 'POS '.$sale_info['sale_id'], array('target' => '_blank'));?>
			</div>
		</div>
	
	<div class="field_row clearfix">
	<?php echo form_label($this->lang->line('sales_customer').':', 'customer'); ?>
		<div class='form_field'>
			<?php echo ($cust_info = $this->Customer->get_info($sale_info['customer_id'])) ? $cust_info->first_name . ' '.$cust_info->last_name : ''?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label($this->lang->line('sales_balance').':', 'balance'); ?>
		<div class='form_field'>
		<?php echo form_input(array(
			'name'=>'balance',
			'id'=>'balance',
			'value'=>$sale_info['balance'])
		);?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label($this->lang->line('sales_delivery_date').':', 'delivery_date'); ?>
		<div class='form_field'>
		<?php echo form_input(array(
			'name'=>'delivery_date',
			'id'=>'delivery_date',
			'value'=>date('m/d/Y', strtotime($sale_info['delivery_date'])))
		);?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label($this->lang->line('sales_delivery_time').':', 'delivery_time'); ?>
		<div class='form_field'>
			<?php echo form_dropdown('delivery_time',array('AM' => 'AM', 'PM' => 'PM'), $sale_info['delivery_time'], 'id="delivery_time"');?>
		</div>
	</div>
	
	<div class="field_row clearfix">
	<?php echo form_label($this->lang->line('sales_comment').':', 'comment'); ?>
		<div class='form_field'>
			<?php echo form_textarea(array('name'=>'comment','value'=>$sale_info['comment'],'rows'=>'4','cols'=>'23', 'id'=>'comment'));?>
		</div>
	</div>
	
	<?php
	echo form_submit(array(
		'name'=>'submit',
		'id'=>'submit',
		'value'=>$this->lang->line('common_submit'),
		'class'=>'submit_button float_left')
	);
	?>
	</form>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$('#delivery_date').datePicker({startDate: '01/01/1970'});
	
	$('#sales_edit_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				console.log(response);
				if(response.success)
				{
					set_feedback(response.message,'success_message',false);
				}
				else
				{
					set_feedback(response.message,'error_message',true);	
					
				}
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			balance: "required",
			delivery_date: "required",
    		delivery_time: "required"
   		},
		messages: 
		{
     		balance: "<?php echo $this->lang->line('sales_balance_required'); ?>",
     		delivery_date: "<?php echo $this->lang->line('sales_delivery_date_required'); ?>",
     		delivery_time: "<?php echo $this->lang->line('sales_delivery_time_required'); ?>"
		}
	});
});
</script>
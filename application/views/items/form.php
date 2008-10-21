<?php
echo form_open('items/save/'.$item_info->item_id,array('id'=>'item_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="item_basic_info">
<legend><?php echo $this->lang->line("items_basic_information"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_name').':', 'name'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$item_info->name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_category').':', 'category'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'category',
		'id'=>'category',
		'value'=>$item_info->category)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_buy_price').':', 'buy_price'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'buy_price',
		'id'=>'buy_price',
		'value'=>$item_info->buy_price)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_unit_price').':', 'unit_price'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'unit_price',
		'id'=>'unit_price',
		'value'=>$item_info->unit_price)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_tax_percent').':', 'tax_percent'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tax_percent',
		'id'=>'tax_percent',
		'value'=>$item_info->tax_percent)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_sale_markdown_percent').':', 'sale_markdown_percent'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'sale_markdown_percent',
		'id'=>'sale_markdown_percent',
		'value'=>$item_info->sale_markdown_percent)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_employee_markdown_percent').':', 'employee_markdown_percent'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'employee_markdown_percent',
		'id'=>'employee_markdown_percent',
		'value'=>$item_info->employee_markdown_percent)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_quantity').':', 'quantity'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'quantity',
		'id'=>'quantity',
		'value'=>$item_info->quantity)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_reorder_level').':', 'reorder_level'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'reorder_level',
		'id'=>'reorder_level',
		'value'=>$item_info->reorder_level)
	);?>
	</div>
</div>



</fieldset>
<?php 
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#item_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
   		},
		messages: 
		{
		}
	});
});
</script>
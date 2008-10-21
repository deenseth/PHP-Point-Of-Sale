<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('items/find_item_info/'.$item_info->item_id,array('id'=>'item_number_form'));
?>
<fieldset id="item_number_info">
<legend><?php echo $this->lang->line("items_number_information"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_item_number').':', 'name',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'scan_item_number',
		'id'=>'scan_item_number',
		'value'=>$item_info->item_number)
	);?>
	</div>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('items_retrive_item_info'),
	'class'=>'submit_button float_right')
);
?>
<div id="info_provided_by"></div>
<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='form_spinner' />

</fieldset>
<?php
echo form_close();
echo form_open('items/save/'.$item_info->item_id,array('id'=>'item_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo $this->lang->line("items_basic_information"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_name').':', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$item_info->name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_category').':', 'category',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'category',
		'id'=>'category',
		'value'=>$item_info->category)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_buy_price').':', 'buy_price',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'buy_price',
		'id'=>'buy_price',
		'value'=>$item_info->buy_price)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_unit_price').':', 'unit_price',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'unit_price',
		'id'=>'unit_price',
		'value'=>$item_info->unit_price)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_tax_percent').':', 'tax_percent',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tax_percent',
		'id'=>'tax_percent',
		'value'=>$item_info->tax_percent)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_sale_markdown_percent').':', 'sale_markdown_percent',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'sale_markdown_percent',
		'id'=>'sale_markdown_percent',
		'value'=>$item_info->sale_markdown_percent)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_employee_markdown_percent').':', 'employee_markdown_percent',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'employee_markdown_percent',
		'id'=>'employee_markdown_percent',
		'value'=>$item_info->employee_markdown_percent)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_quantity').':', 'quantity',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'quantity',
		'id'=>'quantity',
		'value'=>$item_info->quantity)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_reorder_level').':', 'reorder_level',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'reorder_level',
		'id'=>'reorder_level',
		'value'=>$item_info->reorder_level)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_description').':', 'description',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'description',
		'id'=>'description',
		'value'=>$item_info->description,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
<input type='hidden' name='item_number' id='item_number' value='<?php echo $item_info->item_number; ?>' />
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{	
	//hack to get focus to work
	setTimeout(function()
	{
		$("#scan_item_number").focus();
	},100);
		
	$('#item_number_form').ajaxForm(
	{
		beforeSubmit:function()
		{
			$('#form_spinner').show();
		},
		success:function(response)
		{
			$('#form_spinner').hide();
			
			if(typeof response.provider!='undefined')
			{
				$('#name').val(response.name);
				$('#category').val(response.category);
				$('#description').val(response.description);
				$('#unit_price').val(response.unit_price);
				$('#tax_percent').val(response.tax_percent);
				var a = document.createElement("a");
				a.setAttribute("href",response.url);
				a.setAttribute("target","_blank");
				a.appendChild(document.createTextNode(response.provider));
				$('#info_provided_by').html("<?php echo $this->lang->line('items_info_provided_by');?> ");
				$('#info_provided_by').append(a);
				$('#info_provided_by').show();
	
			}
		},
		dataType:'json'
	});
	
	
	$('#item_form').validate({
		submitHandler:function(form)
		{
			/*
			make sure the hidden field #item_number gets set
			to the visible scan_item_number value
			*/
			$('#item_number').val($('#scan_item_number').val());
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
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
<?php echo form_label($this->lang->line('items_unit_price').':', 'unit_price',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'unit_price',
		'size'=>'8',
		'id'=>'unit_price',
		'value'=>$item_info->unit_price)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_tax_1').':', 'tax_percent_1',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tax_names[]',
		'id'=>'tax_name_1',
		'size'=>'10',
		'value'=> isset($item_tax_info[0]['name']) ? $item_tax_info[0]['name'] : $this->lang->line('items_sales_tax'))
	);?>
	</div>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tax_percents[]',
		'id'=>'tax_percent_name_1',
		'size'=>'4',
		'value'=> isset($item_tax_info[0]['percent']) ? $item_tax_info[0]['percent'] : $default_tax_rate)
	);?>
	%
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('items_tax_2').':', 'tax_percent_2',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tax_names[]',
		'id'=>'tax_name_2',
		'size'=>'10',
		'value'=> isset($item_tax_info[1]['name']) ? $item_tax_info[1]['name'] : '')
	);?>
	</div>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'tax_percents[]',
		'id'=>'tax_percent_name_2',
		'size'=>'4',
		'value'=> isset($item_tax_info[1]['percent']) ? $item_tax_info[1]['percent'] : '')
	);?>
	%
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
	
	$("#category").autocomplete("<?php echo site_url('items/suggest_category');?>",{max:100,minChars:0,delay:10});
    $("#category").result(function(event, data, formatted)
    {
    });
	$("#category").search();
	
	$('#item_number_form').ajaxForm(
	{
		beforeSubmit:function()
		{
			$('#scan_item_number').addClass('loading');
		},
		success:function(response)
		{
			$('#scan_item_number').removeClass('loading');
			
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
			else
			{
				$('#info_provided_by').html("<?php echo $this->lang->line('items_cannot_find_item');?> ");
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
				post_item_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			name:"required",
			category:"required",
			unit_price:
			{
				required:true,
				number:true
			},
			tax_percent:
			{
				required:true,
				number:true
			},
			quantity:
			{
				required:true,
				number:true
			},
			reorder_level:
			{
				required:true,
				number:true
			}
   		},
		messages: 
		{
			name:"<?php echo $this->lang->line('items_name_required'); ?>",
			category:"<?php echo $this->lang->line('items_category_required'); ?>",
			unit_price:
			{
				required:"<?php echo $this->lang->line('items_unit_price_required'); ?>",
				number:"<?php echo $this->lang->line('items_unit_price_number'); ?>"
			},
			tax_percent:
			{
				required:"<?php echo $this->lang->line('items_tax_percent_required'); ?>",
				number:"<?php echo $this->lang->line('items_tax_percent_number'); ?>"
			},
			quantity:
			{
				required:"<?php echo $this->lang->line('items_quantity_required'); ?>",
				number:"<?php echo $this->lang->line('items_quantity_number'); ?>"
			},
			reorder_level:
			{
				required:"<?php echo $this->lang->line('items_reorder_level_required'); ?>",
				number:"<?php echo $this->lang->line('items_reorder_level_number'); ?>"
			}

		}
	});
});
</script>
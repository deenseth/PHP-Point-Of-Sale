<?php $this->load->view("partial/header"); ?>
<ul id="error_message_box"></ul>
<?php
echo form_open('items/bulk_update/',array('id'=>'item_form'));
?>
<fieldset id="item_basic_info">

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_name'), 'name' ,array('class'=>'required')); ?>
			<?php echo form_input(array(
				'class'=>'form-control',
				'placeholder'=>$this->lang->line('items_name'),
				'name'=>'name',
				'id'=>'name'
			));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_category'), 'category' ,array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_category'),
			'name'=>'category',
			'id'=>'category'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_supplier'), 'supplier_id'); ?>
		<?php echo form_dropdown('supplier_id', $suppliers, $selected_supplier, 'class="selectpicker"  data-width="100%"');?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_cost_price'), 'cost_price' ,array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_cost_price'),
			'name'=>'cost_price',
			'size'=>'8',
			'id'=>'cost_price'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_unit_price'), 'unit_price' ,array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_unit_price'),
			'name'=>'unit_price',
			'size'=>'8',
			'id'=>'unit_price'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_tax_1'), 'tax_names[]'); ?>
		<div class="row">
		  	<div class="col-lg-6">
				<?php echo form_input(array(
					'class'=>'form-control',
					'placeholder'=>$this->lang->line('items_tax_1'),
					'name'=>'tax_names[]',
					'id'=>'tax_name_1',
					'size'=>'8'
				));?>
			</div>
			<div class="col-lg-6">
				<div class="input-group">
					<?php echo form_input(array(
						'class'=>'form-control',
						'placeholder'=>$this->lang->line('items_percent'),
						'name'=>'tax_percents[]',
						'id'=>'tax_percent_name_1'
					));?>
					<span class="input-group-addon">%</span>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_tax_2'), 'tax_names[]'); ?>
		<div class="row">
		  	<div class="col-lg-6">
				<?php echo form_input(array(
					'class'=>'form-control',
					'placeholder'=>$this->lang->line('items_tax_2'),
					'name'=>'tax_names[]',
					'id'=>'tax_name_2',
					'size'=>'8'
				));?>
			</div>
			<div class="col-lg-6">
				<div class="input-group">
					<?php echo form_input(array(
						'class'=>'form-control',
						'placeholder'=>$this->lang->line('items_percent'),
						'name'=>'tax_percents[]',
						'id'=>'tax_percent_name_2',
						'type'=>'text',
						'size'=>'3'
					));?>
					<span class="input-group-addon">%</span>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_quantity'), 'quantity' ,array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_quantity'),
			'name'=>'quantity',
			'id'=>'quantity'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_reorder_level'), 'reorder_level', array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_reorder_level'),
			'name'=>'reorder_level',
			'id'=>'reorder_level'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_location'), 'location'); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_location'),
			'name'=>'location',
			'id'=>'location'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_description'), 'description'); ?>
		<?php echo form_textarea(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_description'),
			'name'=>'description',
			'id'=>'description',
			'rows'=>'5',
			'cols'=>'17'
		));?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_allow_alt_desciption'), 'allow_alt_description'); ?>
		<?php echo form_checkbox(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_allow_alt_desciption'),
			'name'=>'allow_alt_description',
			'id'=>'allow_alt_description',
			'checked'=>isset($item_info->allow_alt_description)? 1  :0)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_is_serialized'), 'is_serialized'); ?>
		<?php echo form_checkbox(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_is_serialized'),
			'name'=>'is_serialized',
			'id'=>'is_serialized',
			'checked'=>isset($item_info->is_serialized)? 1 : 0)
		);?>
	</div>

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-primary float_right')
);
?>
</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{	
	$('.selectpicker').selectpicker();

	$("#category").autocomplete({source:"<?php echo site_url('items/suggest_category');?>", delay:10, minLength:0});
	$("#category").autocomplete("search", "");
	
	$('#item_form').validate({
		submitHandler:function(form)
		{
			if(confirm("<?php echo $this->lang->line('items_confirm_bulk_edit') ?>"))
			{
				//Get the selected ids and create hidden fields to send with ajax submit.
				//var selected_item_ids=get_selected_values();
				//TODO: Maybe PHP should handle this?
				var selected_item_ids = JSON.parse(window.localStorage.getItem("selected_values"));
				window.localStorage.removeItem('selected_values');
				for(k=0;k<selected_item_ids.length;k++)
				{
					$(form).append("<input type='hidden' name='item_ids[]' value='"+selected_item_ids[k]+"' />");
				}
				
				
				$(form).ajaxSubmit({
				success:function(response)
				{
					post_bulk_form_submit(response);
				},
				dataType:'json'
				});
			}

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			unit_price:
			{
				number:true
			},
			tax_percent:
			{
				number:true
			},
			quantity:
			{
				number:true
			},
			reorder_level:
			{
				number:true
			}
   		},
		messages: 
		{
			unit_price:
			{
				number:"<?php echo $this->lang->line('items_unit_price_number'); ?>"
			},
			tax_percent:
			{
				number:"<?php echo $this->lang->line('items_tax_percent_number'); ?>"
			},
			quantity:
			{
				number:"<?php echo $this->lang->line('items_quantity_number'); ?>"
			},
			reorder_level:
			{
				number:"<?php echo $this->lang->line('items_reorder_level_number'); ?>"
			}

		}
	});

	function post_bulk_form_submit(response)
	{
		if(!response.success)
		{
			set_feedback(response.message,'error',true);
		}
		else
		{
			var message = {'text': response.message, 'type': 'success'};
			window.localStorage.setItem("message", JSON.stringify(message));
			window.location.href = '<?php echo site_url("items")?>';
		}
	}
});
</script>
<?php $this->load->view("partial/footer"); ?>
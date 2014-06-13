<?php $this->load->view("partial/header"); ?>
<h1><?php echo $this->lang->line("items_basic_information"); ?></h1>
<hr>
<ul id="error_message_box"></ul>
<?php
echo form_open('items/save/'.$item_info->item_id,array('id'=>'item_form'));
?>
<fieldset id="item_basic_info">
	<div class="form-group">
		<?php echo form_label($this->lang->line('items_item_number'), 'item_number',array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_item_number'),
			'name'=>'item_number',
			'id'=>'item_number',
			'value'=>$item_info->item_number)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_name'), 'name' ,array('class'=>'required')); ?>
			<?php echo form_input(array(
				'class'=>'form-control',
				'placeholder'=>$this->lang->line('items_name'),
				'name'=>'name',
				'id'=>'name',
				'value'=>$item_info->name)
			);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_category'), 'category' ,array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_category'),
			'name'=>'category',
			'id'=>'category',
			'value'=>$item_info->category)
		);?>
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
			'id'=>'cost_price',
			'value'=>$item_info->cost_price)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_unit_price'), 'unit_price' ,array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_unit_price'),
			'name'=>'unit_price',
			'size'=>'8',
			'id'=>'unit_price',
			'value'=>$item_info->unit_price)
		);?>
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
					'size'=>'8',
					'value'=> isset($item_tax_info[0]['name']) ? $item_tax_info[0]['name'] : $this->config->item('default_tax_1_name'))
				);?>
			</div>
			<div class="col-lg-6">
				<div class="input-group">
					<?php echo form_input(array(
						'class'=>'form-control',
						'placeholder'=>$this->lang->line('items_percent'),
						'name'=>'tax_percents[]',
						'id'=>'tax_percent_name_1',
						'value'=> isset($item_tax_info[0]['percent']) ? $item_tax_info[0]['percent'] : $default_tax_1_rate)
					);?>
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
					'size'=>'8',
					'value'=> isset($item_tax_info[1]['name']) ? $item_tax_info[1]['name'] : $this->config->item('default_tax_2_name'))
				);?>
			</div>
			<div class="col-lg-6">
				<div class="input-group">
					<?php echo form_input(array(
						'class'=>'form-control',
						'placeholder'=>$this->lang->line('items_percent'),
						'name'=>'tax_percents[]',
						'id'=>'tax_percent_name_2',
						'type'=>'text',
						'size'=>'3',
						'value'=> isset($item_tax_info[1]['percent']) ? $item_tax_info[1]['percent'] : $default_tax_2_rate)
					);?>
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
			'id'=>'quantity',
			'value'=>$item_info->quantity)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_reorder_level'), 'reorder_level', array('class'=>'required')); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_reorder_level'),
			'name'=>'reorder_level',
			'id'=>'reorder_level',
			'value'=>$item_info->reorder_level)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_location'), 'location'); ?>
		<?php echo form_input(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_location'),
			'name'=>'location',
			'id'=>'location',
			'value'=>$item_info->location)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_description'), 'description'); ?>
		<?php echo form_textarea(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_description'),
			'name'=>'description',
			'id'=>'description',
			'value'=>$item_info->description,
			'rows'=>'5',
			'cols'=>'17')
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_allow_alt_desciption'), 'allow_alt_description'); ?>
		<?php echo form_checkbox(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_allow_alt_desciption'),
			'name'=>'allow_alt_description',
			'id'=>'allow_alt_description',
			'value'=>1,
			'checked'=>($item_info->allow_alt_description)? 1  :0)
		);?>
	</div>

	<div class="form-group">
		<?php echo form_label($this->lang->line('items_is_serialized'), 'is_serialized'); ?>
		<?php echo form_checkbox(array(
			'class'=>'form-control',
			'placeholder'=>$this->lang->line('items_is_serialized'),
			'name'=>'is_serialized',
			'id'=>'is_serialized',
			'value'=>1,
			'checked'=>($item_info->is_serialized)? 1 : 0)
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
	$("#category").autocomplete({source:"<?php echo site_url('items/suggest_category');?>", delay:10, minLength:0});
	$("#category").autocomplete("search", "");

	$('.selectpicker').selectpicker();

	$('#item_form').validate({
		submitHandler:function(form)
		{
			/*
			make sure the hidden field #item_number gets set
			to the visible scan_item_number value
			*/
			//$('#item_number').val($('#scan_item_number').val());
			$(form).ajaxSubmit({
			success:function(response)
			{
				post_item_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			item_number:"required",
			name:"required",
			category:"required",
			cost_price:
			{
				required:true,
				number:true
			},

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
			item_number:"<?php echo $this->lang->line('items_number_required'); ?>",
			name:"<?php echo $this->lang->line('items_name_required'); ?>",
			category:"<?php echo $this->lang->line('items_category_required'); ?>",
			cost_price:
			{
				required:"<?php echo $this->lang->line('items_cost_price_required'); ?>",
				number:"<?php echo $this->lang->line('items_cost_price_number'); ?>"
			},
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

	function post_item_form_submit(response)
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
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
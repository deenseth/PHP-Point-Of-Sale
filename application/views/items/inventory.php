<?php $this->load->view("partial/header"); ?>
<ul id="error_message_box"></ul>
<?php
echo form_close();
echo form_open('items/save_inventory/'.$item_info->item_id,array('id'=>'item_form'));
?>
<h1><?php echo $this->lang->line("items_basic_information"); ?></h1>
<fieldset id="item_basic_info">

<table border="0" bgcolor="#CCCCCC" class="table">
	<div class="field_row clearfix">
		<tr>
			<td>	
				<?php echo form_label($this->lang->line('items_item_number').':', 'name',array('class'=>'wide')); ?>
			</td>
			<td>
				<?php $inumber = array (
					'name'=>'item_number',
					'id'=>'item_number',
					'value'=>$item_info->item_number,
					'style'       => 'border:none',
					'readonly' => 'readonly'
					);

				echo form_input($inumber)
				?>
			</td>
		</tr>
		<tr>
			<td>	
				<?php echo form_label($this->lang->line('items_name').':', 'name',array('class'=>'wide')); ?>
			</td>
			<td>	
				<?php $iname = array (
					'name'=>'name',
					'id'=>'name',
					'value'=>$item_info->name,
					'style'       => 'border:none',
					'readonly' => 'readonly'
					);
				echo form_input($iname);
				?>
			</td>
		</tr>
		<tr>
			<td>	
				<?php echo form_label($this->lang->line('items_category').':', 'category',array('class'=>'wide')); ?>
			</td>
			<td>	
				<?php $cat = array (

					'name'=>'category',
					'id'=>'category',
					'value'=>$item_info->category,
					'style'       => 'border:none',
					'readonly' => 'readonly'
					);

				echo form_input($cat);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo form_label($this->lang->line('items_current_quantity').':', 'quantity',array('class'=>'wide')); ?>
			</td>
			<td>
				<?php $qty = array (

					'name'=>'quantity',
					'id'=>'quantity',
					'value'=>$item_info->quantity,
					'style'       => 'border:none',
					'readonly' => 'readonly'
					);

				echo form_input($qty);
				?>
			</td>
		</tr>
	</div>	
</table>

<div class="form-group">	
	<?php echo form_label($this->lang->line('items_add_minus').':', 'quantity',array('class'=>'required')); ?>
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'newquantity',
		'id'=>'newquantity'
		)
	);?>
</div>

<div class="form-group">	
	<?php echo form_label($this->lang->line('items_inventory_comments').':', 'description'); ?>
	<?php echo form_textarea(array(
		'class'=>'form-control',
		'name'=>'trans_comment',
		'id'=>'trans_comment',
		'rows'=>'3',
		'cols'=>'17')		
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
	$('#item_form').validate({
		submitHandler:function(form)
		{
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
			newquantity:
			{
				required:true,
				number:true
			}
   		},
		messages: 
		{
			
			newquantity:
			{
				required:"<?php echo $this->lang->line('items_quantity_required'); ?>",
				number:"<?php echo $this->lang->line('items_quantity_number'); ?>"
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
<?php $this->load->view("partial/footer"); ?>
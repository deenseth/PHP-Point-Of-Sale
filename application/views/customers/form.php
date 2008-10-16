<?php
echo form_open('customers/save/'.$customer_info->id,array('id'=>'customer_form'));
?>

<div class="field_row clearfix">	
<label>First Name:</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'first_name',
		'value'=>$customer_info->first_name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<label>Last Name:</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'value'=>$customer_info->last_name)
	);?>
	</div>
</div>


<div class="field_row clearfix">	
<label>Email:</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'value'=>$customer_info->email)
	
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Phone Number:</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'value'=>$customer_info->phone_number));?>
	</div>
</div>

<div class="field_row clearfix">	
<label>Comments:</label>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'comments',
		'value'=>$customer_info->comments)		
	);?>
	</div>
</div>
<?php 
echo form_submit(array(
	'name'=>'submit',
	'value'=>'Submit')
);
echo form_close();
?>
<script type='text/javascript'>
$(document).ready(function()
{
	$('#customer_form').validate({
		submitHandler:function(form)
		{
			customer_form_submit(form);
		},
		messages: 
		{
     		first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
     		last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});
</script>
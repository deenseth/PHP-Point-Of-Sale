<?php
if($customer_info->id!='')
{
	echo '<h2>'.$this->lang->line('customer_update_customer').'</h2>';
}
else
{
	echo '<h2>'.$this->lang->line('customer_new_customer').'</h2>';
}
echo form_open('customers/save/'.$customer_info->id,array('id'=>'customer_form'));
?>
First Name: 
<?php echo form_input(array(
	'name'=>'first_name',
	'value'=>$customer_info->first_name,
	'class'=>'required')
);?>
<br /><br />
Last Name:
<?php echo form_input(array(
	'name'=>'last_name',
	'value'=>$customer_info->last_name,
	'class'=>'required')
);?>
<br /><br />
Email:
<?php echo form_input(array(
	'name'=>'email',
	'value'=>$customer_info->email,
	'class'=>'email')

);?>
<br /><br />
Phone Number:
<?php echo form_input(array(
	'name'=>'phone_number',
	'value'=>$customer_info->phone_number));?>
<br /><br />
Comments:
<?php echo form_input(array(
	'name'=>'comments',
	'value'=>$customer_info->comments)		
);?>

<br /><br />

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
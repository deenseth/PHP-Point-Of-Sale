<script type='text/javascript'>
$(document).ready(function()
{	
	$('#customers_form').submit(function(event)
	{
		event.preventDefault();
		
		$.post($(this).attr('action'), $(this).serializeArray(),function()
		{
			tb_remove();
			do_search();	
		});
 	});
});
</script>

<?php
if($customer_info->id!='')
{
	echo '<h2>'.$this->lang->line('customer_update_customer').'</h2>';
}
else
{
	echo '<h2>'.$this->lang->line('customer_new_customer').'</h2>';
}
echo form_open('customers/save/'.$customer_info->id,array('id'=>'customers_form'));
?>

First Name: 
<?php echo form_input(array(
	'name'=>'first_name',
	'value'=>$customer_info->first_name)
);?>
<br /><br />
Last Name:
<?php echo form_input(array(
	'name'=>'last_name',
	'value'=>$customer_info->last_name)
);?>
<br /><br />
Email:
<?php echo form_input(array(
	'name'=>'email',
	'value'=>$customer_info->email)
);?>
<br /><br />
Phone Number:
<?php echo form_input(array(
	'name'=>'phone_number',
	'value'=>$customer_info->phone_number)
);?>
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
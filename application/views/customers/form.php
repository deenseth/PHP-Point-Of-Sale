<?php
if($customer_info->id!=-1)
{
	echo '<h2>'.$this->lang->line('customer_update_customer').'</h2>';
	echo form_open('customers/update/'.$customer_info->id);
}
else
{
	echo '<h2>'.$this->lang->line('customer_new_customer').'</h2>';
	echo form_open('customers/add');
}
?>

<div class="form_row clearfix">
	<div class="form_label">
		<label style="line-height:2.4;">Login ID:</label>
	</div>
	<div class="form_field">
		<input type="text" name="first_name" id="first_name" class="fValidate['required']" value="<?php echo $userInfo->loginId; ?>"/>
	</div>
</div>

<?php 
echo form_close();
?>
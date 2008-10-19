<?php
echo form_open('customers/save/'.$person_info->person_id,array('id'=>'customer_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="customer_basic_info">
<legend><?php echo $this->lang->line("customers_basic_information"); ?></legend>
<?php $this->load->view("people/form_basic_info"); ?>
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
	$('#customer_form').validate({
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
			first_name: "required",
			last_name: "required",
    		email: "email"
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
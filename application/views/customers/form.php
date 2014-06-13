<?php $this->load->view("partial/header"); ?>
<?php
echo form_open('customers/save/'.$person_info->person_id,array('id'=>'customer_form'));
?>
<ul id="error_message_box"></ul>
<h1><?php echo $this->lang->line("customers_basic_information"); ?></h1>
<hr>
<fieldset id="customer_basic_info">
<?php $this->load->view("people/form_basic_info"); ?>
<div class="form-group">	
	<?php echo form_label($this->lang->line('customers_account_number'), 'account_number'); ?>
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'account_number',
		'id'=>'account_number',
		'value'=>$person_info->account_number)
	);?>
</div>

<div class="form-group">	
	<?php echo form_label($this->lang->line('customers_taxable').':', 'taxable'); ?>
	<?php echo form_checkbox('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean)$person_info->taxable);?>
</div>

<?php echo $this->load->view('partial/list_manage_form_wrapper.php', array('email'=>$person_info->email))?>

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
	$('#customer_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				post_person_form_submit(response);
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

	function post_person_form_submit(response)
	{
		if(!response.success)
		{
			set_feedback(response.message,'error_message',true);	
		}
		else
		{
			var message = {'text': response.message, 'type': 'success'};
			window.localStorage.setItem("message", JSON.stringify(message));
			window.location.href = '<?php echo site_url("customers")?>';	
		}
	}
});
</script>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
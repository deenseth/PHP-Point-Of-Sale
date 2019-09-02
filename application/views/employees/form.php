<?php $this->load->view("partial/header"); ?>
<?php
echo form_open('employees/save/'.$person_info->person_id,array('id'=>'employee_form'));
?>
<fieldset id="employee_basic_info">
<legend><?php echo $this->lang->line("employees_basic_information"); ?></legend>
<?php $this->load->view("people/form_basic_info"); ?>
</fieldset>

<fieldset id="employee_login_info">
<legend><?php echo $this->lang->line("employees_login_info"); ?></legend>
<div class="form-group">	
<?php echo form_label($this->lang->line('employees_username'), 'username',array('class'=>'required')); ?>
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'username',
		'id'=>'username',
		'value'=>$person_info->username));?>
</div>

<?php
$password_label_attributes = $person_info->person_id == "" ? array('class'=>'required'):array();
?>

<div class="form-group">	
<?php echo form_label($this->lang->line('employees_password'), 'password', $password_label_attributes); ?>
	<?php echo form_password(array(
		'class'=>'form-control',
		'name'=>'password',
		'id'=>'password'
	));?>
</div>


<div class="form-group">	
<?php echo form_label($this->lang->line('employees_repeat_password'), 'repeat_password', $password_label_attributes); ?>
	<?php echo form_password(array(
		'class'=>'form-control',
		'name'=>'repeat_password',
		'id'=>'repeat_password'
	));?>
</div>
</fieldset>

<fieldset id="employee_permission_info">
<legend><?php echo $this->lang->line("employees_permission_info"); ?></legend>

<ul id="permission_list" class="list-group">
	<?php foreach($all_modules->result() as $module) { ?>
		<li class="list-group-item">	
			<?php echo form_checkbox("permissions[]",$module->module_id,$this->Employee->has_permission($module->module_id,$person_info->person_id)); ?>
			<span class="medium"><?php echo $this->lang->line('module_'.$module->module_id);?>:</span>
			<span class="small"><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></span>
		</li>
	<?php } ?>
</ul>

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-primary float_right')
);?>

</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#employee_form').validate({
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
			username:
			{
				required:true,
				minlength: 5
			},
			
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:true,
				<?php
				}
				?>
				minlength: 8
			},	
			repeat_password:
			{
 				equalTo: "#password"
			},
    		email: "email"
   		},
		messages: 
		{
     		first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
     		last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		username:
     		{
     			required: "<?php echo $this->lang->line('employees_username_required'); ?>",
     			minlength: "<?php echo $this->lang->line('employees_username_minlength'); ?>"
     		},
     		
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:"<?php echo $this->lang->line('employees_password_required'); ?>",
				<?php
				}
				?>
				minlength: "<?php echo $this->lang->line('employees_password_minlength'); ?>"
			},
			repeat_password:
			{
				equalTo: "<?php echo $this->lang->line('employees_password_must_match'); ?>"
     		},
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
			window.location.href = '<?php echo site_url("employees")?>';	
		}
	}
});
</script>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
<div class="form-group">	
<?php echo form_label($this->lang->line('common_first_name'), 'first_name',array('class'=>'required')); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'first_name',
		'id'=>'first_name',
		'value'=>$person_info->first_name)
	);?>
</div>
<div class="form-group">	
<?php echo form_label($this->lang->line('common_last_name'), 'last_name',array('class'=>'required')); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'last_name',
		'id'=>'last_name',
		'value'=>$person_info->last_name)
	);?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_email'), 'email'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'email',
		'id'=>'email',
		'value'=>$person_info->email)
	);?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_phone_number'), 'phone_number'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'phone_number',
		'id'=>'phone_number',
		'value'=>$person_info->phone_number));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_address_1'), 'address_1'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'address_1',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_address_2'), 'address_2'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'address_2',
		'id'=>'address_2',
		'value'=>$person_info->address_2));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_city'), 'city'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'city',
		'id'=>'city',
		'value'=>$person_info->city));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_state'), 'state'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'state',
		'id'=>'state',
		'value'=>$person_info->state));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_zip'), 'zip'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'zip',
		'id'=>'zip',
		'value'=>$person_info->zip));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_country'), 'country'); ?>
	
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'country',
		'id'=>'country',
		'value'=>$person_info->country));?>
</div>

<div class="form-group">	
<?php echo form_label($this->lang->line('common_comments'), 'comments'); ?>
	
	<?php echo form_textarea(array(
		'class'=>'form-control',
		'name'=>'comments',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
</div>
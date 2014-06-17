<?php $this->load->view("partial/header"); ?>
<h1><?php echo $this->lang->line("giftcards_basic_information"); ?></h1>
<hr>
<ul id="error_message_box"></ul>
<?php
echo form_open('giftcards/save/'.$giftcard_info->giftcard_id,array('id'=>'giftcard_form'));
?>
<fieldset id="giftcard_basic_info">
<div class="form-group">
<?php echo form_label($this->lang->line('giftcards_giftcard_number'), 'name',array('class'=>'required wide')); ?>
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'giftcard_number',
		'size'=>'8',
		'id'=>'giftcard_number',
		'value'=>$giftcard_info->giftcard_number)
	);?>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('giftcards_card_value')	, 'name',array('class'=>'required wide')); ?>
	<?php echo form_input(array(
		'class'=>'form-control',
		'name'=>'value',
		'size'=>'8',
		'id'=>'value',
		'value'=>$giftcard_info->value)
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
	$('#giftcard_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				post_giftcard_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			giftcard_number:
			{
				required:true,
				number:true
			},
			value:
			{
				required:true,
				number:true
			}
   		},
		messages:
		{
			giftcard_number:
			{
				required:"<?php echo $this->lang->line('giftcards_number_required'); ?>",
				number:"<?php echo $this->lang->line('giftcards_number'); ?>"
			},
			value:
			{
				required:"<?php echo $this->lang->line('giftcards_value_required'); ?>",
				number:"<?php echo $this->lang->line('giftcards_value'); ?>"
			}
		}
	});

	function post_giftcard_form_submit(response)
	{
		if(!response.success)
		{
			set_feedback(response.message,'error',true);
		}
		else
		{
			var message = {'text': response.message, 'type': 'success'};
			window.localStorage.setItem("message", JSON.stringify(message));
			window.location.href = '<?php echo site_url("giftcards")?>';
		}
	}
});
</script>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
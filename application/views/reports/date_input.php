<?php $this->load->view("partial/header"); ?>
<h1><?php echo $this->lang->line('reports_report_input'); ?></h1>
<hr>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
	<?php echo form_label($this->lang->line('reports_date_range'), 'report_date_range_label', array('class'=>'required')); ?>
	<div id='report_date_range_simple'>
		<input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
		<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, '', 'id="report_date_range_simple" class="selectpicker" data-width="auto"'); ?>
	</div>
	
	<div id='report_date_range_complex'>
		<input type="radio" name="report_type" id="complex_radio" value='complex' />
		<?php echo form_dropdown('start_month',$months, $selected_month, 'id="start_month" class="selectpicker" data-width="auto"'); ?>
		<?php echo form_dropdown('start_day',$days, $selected_day, 'id="start_day" class="selectpicker" data-width="auto"'); ?>
		<?php echo form_dropdown('start_year',$years, $selected_year, 'id="start_year" class="selectpicker" data-width="auto"'); ?>
		-
		<?php echo form_dropdown('end_month',$months, $selected_month, 'id="end_month" class="selectpicker" data-width="auto"'); ?>
		<?php echo form_dropdown('end_day',$days, $selected_day, 'id="end_day" class="selectpicker" data-width="auto"'); ?>
		<?php echo form_dropdown('end_year',$years, $selected_year, 'id="end_year" class="selectpicker" data-width="auto"'); ?>
	</div>
	
	<?php echo form_label($this->lang->line('reports_sale_type'), 'reports_sale_type_label', array('class'=>'required')); ?>
	<div id='report_sale_type'>
		<?php echo form_dropdown('sale_type',array('all' => $this->lang->line('reports_all'), 'sales' => $this->lang->line('reports_sales'), 'returns' => $this->lang->line('reports_returns')), 'all', 'id="sale_type" class="selectpicker" data-width="auto"'); ?>
	</div>
<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report',
	'content'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-primary submit_button')
);
?>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$('.selectpicker').selectpicker();

	$("#generate_report").click(function()
	{		
		var sale_type = $("#sale_type").val();
		
		if ($("#simple_radio").is(':checked'))
		{
			window.location = window.location+'/'+$("#report_date_range_simple option:selected").val() + '/' + sale_type;
		}
		else
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val();
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val();
	
			window.location = window.location+'/'+start_date + '/'+ end_date+ '/' + sale_type;
		}
	});
	
	$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").click(function()
	{
		$("#complex_radio").attr('checked', 'checked');
	});
	
	$("#report_date_range_simple").click(function()
	{
		$("#simple_radio").attr('checked', 'checked');
	});
	
});
</script>
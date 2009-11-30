<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>

<?php echo form_label($this->lang->line('reports_type'), 'report_type_label', array('class'=>'required')); ?>
<div id='report_type_container'>
	<?php echo form_dropdown('report_type', array(), ''); ?>
</div>

<?php echo form_label($this->lang->line('reports_date_range'), 'report_date_range_label', array('class'=>'required')); ?>
<div id='report_date_range_simple'>
	<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, $report_date_range_simple_selected); ?>
</div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
}
</script>

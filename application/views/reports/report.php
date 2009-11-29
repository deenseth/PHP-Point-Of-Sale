<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('reports_type'), 'report_type_label', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('report_type', array(), ''); ?>
	</div>
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

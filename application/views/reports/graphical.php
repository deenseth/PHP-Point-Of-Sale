<?php
$this->load->view("partial/header");
?>
<h1>
	<?php echo $title ?>
	<small><?php echo $subtitle ?></small>
</h1>
<hr>
<div style="text-align: center;">
<script type="text/javascript">
swfobject.embedSWF(
"<?php echo base_url(); ?>open-flash-chart.swf", "chart",
"100%", "100%", "9.0.0", "expressInstall.swf",
{"data-file":"<?php echo $data_file; ?>"} )
</script>
</div>
<div id="chart_wrapper">
	<div id="chart"></div>
</div>
<ul class="list-group">
	<?php foreach($summary_data as $name=>$value) { ?>
	<li class="list-group-item"><?php echo $this->lang->line('reports_'.$name). ': '.to_currency($value); ?></li>
	<?php }?>
</ul>
<div id="feedback_bar"></div>
<?php
$this->load->view("partial/footer"); 
?>
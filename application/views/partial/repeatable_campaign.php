<html>
	<style>
		<?php echo file_get_contents(dirname(__FILE__).'../../../../css/phppos.css')?>
		<?php echo file_get_contents(dirname(__FILE__).'../../../../css/general.css')?>
        <?php echo file_get_contents(dirname(__FILE__).'../../../../css/tables.css')?>
		<?php echo file_get_contents(dirname(__FILE__).'../../../../css/reports.css')?>
	</style>
	<body>
		
		<div id="content-area-wrapper">
			<div id"content-area">
    			<div id="page_title" style="margin-bottom:8px;"><?php echo $data->title?></div>
    			<div id="blurb"><?php echo $data->blurb?></div>
    			<?php echo $report_service->render()?>
			</div>
		</div>
	</body>
</html>
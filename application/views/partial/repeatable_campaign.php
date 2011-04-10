<html>
	<style>
		<?=file_get_contents(dirname(__FILE__).'../../../../css/phppos.css')?>
		<?=file_get_contents(dirname(__FILE__).'../../../../css/general.css')?>
        <?=file_get_contents(dirname(__FILE__).'../../../../css/tables.css')?>
		<?=file_get_contents(dirname(__FILE__).'../../../../css/reports.css')?>
	</style>
	<body>
		
		<div id="content-area-wrapper">
			<div id"content-area">
    			<div id="page_title" style="margin-bottom:8px;"><?=$data->title?></div>
    			<div id="blurb"><?=$data->blurb?></div>
    			<?=$report_service->render()?>
			</div>
		</div>
	</body>
</html>
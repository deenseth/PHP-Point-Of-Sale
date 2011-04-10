<html>
	<body>
		<style>
			<?=file_get_contents(base_url().'css/phppos.css')?>
			<?=file_get_contents(base_url().'css/general.css')?>
            <?=file_get_contents(base_url().'css/tables.css')?>
			<?=file_get_contents(base_url().'css/reports.css')?>
		</style>
		<div id="content-area-wrapper">
			<div id"content-area">
    			<div id="page_title" style="margin-bottom:8px;"><?=$data->title?></div>
    			<?=$report_service->render()?>
			</div>
		</div>
	</body>
</html>
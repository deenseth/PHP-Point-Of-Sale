<?php 
//OJB: Check if for excel export process
if($report_service->renderData['data']['export_excel'] == 1){
	ob_start();
	$this->load->view("partial/header_excel");
}else{
	$this->load->view("partial/header");
} 
?>
<?php echo $report_service->render()?>
<?php 
if($report_service->renderData['data']['export_excel'] == 1){
	$this->load->view("partial/footer_excel");
	$content = ob_end_flush();
	
	$filename = trim($filename);
	$filename = str_replace(array(' ', '/', '\\'), '', $report_service->renderData['data']['title']);
	$filename .= "_Export.xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	echo $content;
	exit();
	
}else{
	$this->load->view("partial/footer"); 
?>

<script type="text/javascript" language="javascript">
function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(); 
	}
}
$(document).ready(function()
{
	init_table_sorting();
});
</script>
<?php 
} // end if not is excel export 
?>
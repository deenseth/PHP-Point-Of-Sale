<?php
class Sync extends CI_Controller
{

	function index()
	{
		$isCLI = ($this->input->is_cli_request())? true : false;
		$this->Sync_items->sync_sales($isCLI);
		$this->Sync_items->sync_inventory($isCLI);
	}
}
?>
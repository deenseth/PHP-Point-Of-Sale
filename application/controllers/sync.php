<?php
class Sync extends CI_Controller
{

	function index()
	{
		$this->Sync_items->sync_sales();
		$this->Sync_items->sync_inventory();
	}
}
?>
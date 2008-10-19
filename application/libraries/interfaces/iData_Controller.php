<?php
interface iData_Controller
{
	public function index();
	public function search();
	public function get_row();
	public function view($data_item_id=-1);
	public function save($data_item_id=-1);
	public function delete();
	public function _get_form_width();
	public function _get_form_height();
}
?>
<?php
/*
This interface is implemented by any controller that keeps track of data items, such
as the customers, employees, and items controllers.
*/
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
<?php
interface iPerson_Controller
{
	public function index();
	public function search();
	public function get_row();
	public function view($person_id=-1);
	public function save($person_id=-1);
	public function delete();
	public function mailto();
	public function _get_form_width();
	public function _get_form_height();
}
?>
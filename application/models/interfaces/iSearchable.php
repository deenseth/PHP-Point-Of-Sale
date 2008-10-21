<?php
interface iSearchable
{
	public function get_search_suggestions($search,$limit=25);
	public function search($search);
}
?>
<?php
interface iSearchable_Person
{
	public function get_search_suggestions($search,$limit=25);
	public function search($search);
}
?>
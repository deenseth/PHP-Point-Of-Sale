<?php
abstract class Report extends Model 
{
	//Returns the column names used for the report
	abstract public function getDataColumns();
	
	//Returns all the data to be populated into the report
	abstract public function getData(array $inputs);
	
	//Returns key=>value pairing of summary data for the report
	abstract public function getSummaryData(array $inputs);
}
?>
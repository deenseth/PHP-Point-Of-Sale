<?php
function to_currency($number)
{
	return '$'.number_format($number, 2, '.', '');
}
?>
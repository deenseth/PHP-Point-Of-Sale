<?php
function to_currency($number)
{
	setlocale(LC_MONETARY, 'en_US');
	return money_format('%n', $number);
}
?>
<?php
/**
 * Again, cannibalized from the end of "system/codeigniter/CodeIgniter.php",
 * this takes care of cleaning up after a model
 */
 
//--------------------------------------------------------------------------------------


/*
 * ------------------------------------------------------
 *  Close the DB connection if one exists
 * ------------------------------------------------------
 */
if (class_exists('CI_DB') AND isset($CI->db))
{
    $CI->db->close();
}

?> 
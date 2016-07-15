<?php

//ezSQL Database Class Core.
include_once ('ez_sql_core.php');
include_once ('ez_sql_mysql.php');

$db_host 		= "localhost";// set database host
$db_user_name	= "root";// set database user
$db_user_pass 	= "";// set database password
$db_name 		= "system";// set database name



// Dtabase Connect
$db = new ezSQL_mysql($db_user_name, $db_user_pass, $db_name, $db_host);


$site_info = $db->get_row("SELECT * FROM settings WHERE id = '1' ");

//echo $site_info->email;
error_reporting(0);
?>
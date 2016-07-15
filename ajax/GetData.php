<?php
session_start();
ob_start();
/* Database Config*/
include ("../includes/db_config.php");

$id 	= mysql_real_escape_string($_GET['id']);
$query 	= "SELECT * FROM rooms WHERE id='$id'";
$result = mysql_query($query);
$data 	= mysql_fetch_array($result);

echo json_encode($data); 

?>
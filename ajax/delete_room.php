<?php
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);

 
if($_POST['room_id'])
{
$room_id=$_POST['room_id'];

$delete = $db->query("DELETE FROM rooms WHERE id = '$room_id'");
 
}
 
?>
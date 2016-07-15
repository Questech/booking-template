<?php 
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);

if($_POST){
	
	$id					= $_POST['id'];
	$note 				= $_POST['note']; 
	$approval_status	= $_POST['status'];
	
	
	$save = $db->query("UPDATE bookings SET status ='2', approval_status ='$approval_status', note ='$note' WHERE id ='$id'");
	?>
    
	<div class="alert alert-success"><?php echo $lang['APPROVAL_SUCCASSFULLY'] ;?></div>
	
	
	
	<?php
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=new_booking.php\">";
	
	}

?>





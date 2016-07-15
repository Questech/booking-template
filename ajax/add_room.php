<?php 
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);
if($_POST){
	
	$sort				= $_POST['sort'];
	$room_name 			= $_POST['room_name']; 
	$price 				= $_POST['price']; 
	
	/*Check the free space*/
		if(!$sort || !$room_name)
		{

		?>
        <div class="alert alert-danger"><?php echo $lang['DO_NOT_LEAVE_SPACE'];?></div>	
		
		<?php
		}else{

	$save =$db->query("INSERT INTO rooms SET room_name ='$room_name', sort ='$sort', price='$price'");
 
	
	?>
    
	<div class="alert alert-success"><?php echo $lang['DATA_SUCCASSFULLY'] ;?></div>
	
	
	
	<?php
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=rooms.php\">";
		}
	}

?>





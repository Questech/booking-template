<?php
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);

/* Post Control*/
if($_POST){
	

		
	/*Form Post*/
	$hotel_name			= $_POST['hotel_name'];
	$email 				= $_POST['email']; 
	$date_format 		= $_POST['date_format']; 
	$language			= $_POST['language'];
	$paypal_pay			= $_POST['paypal_pay'];
	$paypal_email		= $_POST['paypal_email'];
	$cc_pay				= $_POST['cc_pay'];
	$sistem_base		= $_POST['sistem_base'];	
	$currency			= $_POST['currency'];	
		/*Check the free space*/
		if(!$hotel_name || !$email || !$date_format || !$date_format || !$paypal_email || !$paypal_email || !$currency)
		{

		?>
        <div class="alert alert-danger"><?php echo $lang['DO_NOT_LEAVE_SPACE'];?></div>	
		
		<?php
		}else{

		
		/*UPDATE database*/
		$update_db = $db->query("UPDATE settings SET hotel_name='$hotel_name', email='$email', language='$language',date_format='$date_format', paypal_pay='$paypal_pay', cc_pay='$cc_pay',paypal_email='$paypal_email',sistem_base='$sistem_base' ,currency='$currency' WHERE id='1'");
	
					  
						 
						  
								  
		?>
        <div class="alert alert-success"><?php echo $lang['DATA_SUCCASSFULLY'] ;?></div>
		
		<?php
			}

	
	}else{
		?>
        <div class="alert alert-danger">Legal...</div>	
		
		<?php
		}

 ?>
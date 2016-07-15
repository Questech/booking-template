<?php
session_start();
ob_start();
/* Database Config*/
include ('../includes/db_config.php');
include ("../language/".$site_info->language);


/* Post Control*/
if($_POST){
	

		
	/*Form Post*/
	$user_email				= $_POST["user_email"];
	$from_email 			= $_POST["from_email"]; 
	$subject				= strip_tags($_POST["subject"]);
	$message				= strip_tags($_POST["message"]);
	$book_id 				= $_POST["book"];
	$time					= time();

		
		/*Check the free space*/
		if(!$user_email || !$from_email || !$subject || !$message)
		{

		?>
        <div class="alert alert-danger"><?php echo $lang['DO_NOT_LEAVE_SPACE'];?></div>	
		
		<?php
		}else{
			
		/*Sen E-mail*/
		
		$headers  = "MIME-Version: 1.0" . "\r\n";  
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";  
		$headers .= "To: <'".$user_email."'>" . "\r\n";  
		$headers .= "From: <'".$from_email."'>" . "\r\n";  
		$headers .= "Reply-To:<'".$from_email."'>" . "\r\n";  
		$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";  
		
		
		
		
		mail($user_email, $subject, $message, $headers); 
			
			



				
		/*Insert database*/
		$save = $db->query("INSERT INTO email SET user_email='$user_email', from_email='$from_email', subject='$subject', message='$message', book='$book_id', date='$time'");
	
			?>
       		 <div class="alert alert-success"><?php echo $lang["SEND_EMAIL_OK"];?></div>
			<?php
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=booking_details.php?booking=$book_id\">";
		

		
			
				
		


		}

	
	}else{
		?>
        <div class="alert alert-danger">Legal...</div>	
		
		<?php
		}

 ?>
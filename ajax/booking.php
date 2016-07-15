<?php
session_start();
ob_start();
/* Database Config*/
include ("../includes/db_config.php");

		if(isset($_SESSION['lan']))
			{

			include('../language/'.$_SESSION['lan'].'.php');
				
			}else{
			
			include ("../language/".$site_info->language);

			}


sleep(2);


/* Post Control*/
if($_POST){
	

		
	/*Form Post*/
	$name			= strip_tags($_POST['name']);
	$email 			= strip_tags($_POST['email']); 
	$phone 			= strip_tags($_POST['phone']); 
	$adults			= strip_tags($_POST['adults']);
	$children 		= strip_tags($_POST['children']);
	$room 			= strip_tags($_POST['room']);  
	$in_date  		= strip_tags($_POST['in_date']);  
	$out_date  		= strip_tags($_POST['out_date']);  
	$comments  		= strip_tags($_POST['comments']);
	$pay_type  		= strip_tags($_POST['pay_type']);
	$time			= time();
	
	
		
		/*Check the free space*/
		if(!$name || !$email || !$phone || !$room || !$in_date || !$out_date || !$pay_type )
		{

		?>
        <div class="alert alert-danger"><?php echo $lang['DO_NOT_LEAVE_SPACE'];?></div>	
		
		<?php
		}else{
		
			if ( filter_var($email, FILTER_VALIDATE_EMAIL) )
				{
					
				}else{ 
			   	?>
                <div class="alert alert-danger"><?php echo $lang['VALIDATE_EMAIL'];?></div>	
                <?php
				
				exit;
				
				} 
		
			
		
		/*Captcha Security Control
		if( $_SESSION['captcha'] == $captchaa && !empty($_SESSION['captcha'] ) ) {
					unset($_SESSION['captcha']);
			   }else{
					?>
                    
                    <div class="alert alert-danger">Security code is incorrect</div>	
                    
				<?php
                            
               
			   }
		
		
		*/

		$data_row = $db->get_var("SELECT email, in_date, status FROM bookings WHERE email='$email' AND in_date='$in_date' AND status='0'");
		if(isset($data_row))
			{

			?>
        		<div class="alert alert-danger"><?php echo $lang['ONE_ALREADY_EXITING']; ?></div>	
		
			<?php
				 exit;
			}else{
				
				
				
		$indate 	= strtotime($in_date." 00:00:00"); 
		$outdate 	= strtotime($out_date." 00:00:00"); 
		$days 		= ($outdate - $indate) / (60*60*24); 
		$user_ip		= $_SERVER["REMOTE_ADDR"]; 
			
				
		$room_info = $db->get_row("SELECT id,price FROM rooms WHERE id = '".$room."'");		
				
				
		/*Insert database*/
		$db->query("INSERT INTO bookings SET name='$name', email='$email', phone='$phone',adults='$adults', children='$children', room='$room', in_date='$in_date', out_date='$out_date', comments='$comments', status='0', time='$time', price='".$room_info->price."', days='$days', user_ip='$user_ip', pay_type='$pay_type', approval_status='0'");
				
				
			
		/*Send E-mail*/

		$subject 	= $site_info->hotel_name.' - '.$lang['BOOKING_SERVICE'];
		$your_email = $site_info->email;
		$comments 	= '<p>'.$lang['FEEDBACK_EMAIL_COMMENTS'].'</p><p>'.$lang['DATE'].' : '.date($site_info->date_formet, time()).'</p> 
		'.$lang['NAME'].': '.$name.'<br>'.$lang['EMAIL'].': '.$email.'<br>'.$lang['PHONE'].': '.$phone;

		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'To: <'.$your_email.'>'. "\r\n";
		$headers .= 'From: <'.$your_email.'>' . "\r\n";
		$headers .= 'Reply-To: Yanit <'.$email.'>' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
			
		mail($your_email, $subject, $comments, $headers);	
		
		
		$lost_query = $db->get_row("SELECT id, time, user_ip FROM bookings WHERE time ='$time' AND user_ip ='$user_ip'");
		$book_id =  $lost_query->id; 
		
		
		
		
		
		if($pay_type == 'paypal')
		{	
			/*Go to paypal page*/
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0;URL=paypal.php?page=PaypalForm&booking=$book_id\">";
		
		exit;	
			
		}
		elseif($pay_type == 'cc')
		{
			/*Go to paypal page*/
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0;URL=cc.php?page=ccForm&booking=$book_id\">";
			
			exit;
		}elseif($pay_type == 'hotel'){
			
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0;URL=paylater.php?page=paylaterForm&booking=$book_id\">";
			exit;
			}else{}

		
		
		
			
				
		?>
        <div class="alert alert-success"><?php echo $lang['BOOK_SUCCASSFULLY'] ;?></div>
		
		<?php	
		
			}

		}

	
	}else{
		?>
        <div class="alert alert-danger">Legal...</div>	
		
		<?php
		}

 ?>
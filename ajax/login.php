<?php
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);

/* Post Control*/
if($_POST){
	

		
	/*Form Post*/
	$email			= $_POST['email'];
	$password		= $_POST['password']; 
	$captchaa 		= $_POST['captchaa'];
	
	
		
		/*Check the free space*/
		if(!$email || !$password || !$captchaa)
		{

		?>
        <div class="alert alert-danger"><?php echo $lang['DO_NOT_LEAVE_SPACE'];?></div>	
		
		<?php
		
		}else{
		
		if( $_SESSION['captcha'] == $_POST['captchaa'] && !empty($_SESSION['captcha'] ) ) {
		unset($_SESSION['captcha']);
			   } else {
			
				?>
        	<div class="alert alert-danger"><?php echo $lang['SECURITY_ERROR'];?></div>	
			<?php
						
			exit;
			   }
					
					
			
			
			/*Login*/	
			$user	= $db->get_row("SELECT id,email,password FROM users WHERE email='$email' AND password='". md5($password)."'");

			$user_num = $db->get_var("SELECT count(*) FROM users WHERE email='$email' AND password='". md5($password)."'");


					if($user_num > 0){
					$_SESSION['password'] = md5($password);
					$_SESSION['user_id'] = $user->id; 
					
					?>
                  
                    <div class="alert alert-success"><?php echo $lang['LOGIN_SUCCASSFULLY'] ;?> </div>
                    <?php
					echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=index.php\">";
					
					
					
					}else{
					?>
                    <div class="alert alert-danger"><?php echo $lang['LOGIN_ERROR'] ;?></div>
                    <?php
					}   
						 
						  
								  
		
			}

	
	}else{
		?>
        <div class="alert alert-danger">Legal...</div>	
		
		<?php
		}

 ?>
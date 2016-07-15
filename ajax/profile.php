<?php
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);


 $user = $db->get_row("SELECT * FROM users WHERE id ='".$_SESSION["user_id"]."'");		
	
/* Post Control*/
if($_POST){
	

		
	/*Form Post*/
	$name			= $_POST['name'];
	$email 			= $_POST['email']; 
	$password 		= $_POST['password']; 
	$re_password	= $_POST['re_password'];
	$old_password	= $_POST['old_password'];
	$pass			= md5($password);

	
		
		/*Check the free space*/
		if(!$name || !$email || !$password || !$re_password || !$old_password)
		{

		?>
        <div class="alert alert-danger"><?php echo $lang['DO_NOT_LEAVE_SPACE'];?></div>	
		
		<?php
		}else{
		
		if(md5($old_password) != $user->password){
			
			?>
            
			<div class="alert alert-danger"><?php echo $lang['OLD_PASSWORD_ERROR'];?></div>	
			
			<?php
			
			exit;
			}
	
		
		
		if($password != $re_password){
			?>
            
			<div class="alert alert-danger"><?php echo $lang['RE_PASSWORD_ERROR'];?></div>	
			
			<?php
			
			exit;
			}
		
		/*UPDATE database*/
		$update_db = $db->query("UPDATE users SET name='$name', email='$email', password='$pass' WHERE id='".$_SESSION['user_id']."'");
		
					  
						 
						  
								  
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
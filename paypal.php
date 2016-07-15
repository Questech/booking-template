<?php 
session_start(); 
ob_start(); 
include ('includes/db_config.php');
include ('includes/functions.php');
?>
 <?php


			if(isset($_SESSION['lan']))
			{

			include('language/'.$_SESSION['lan'].'.php');
				
			}else{
			
			include ("language/".$site_info->language);

			}
			
			
			$book = $db->get_row("SELECT * FROM bookings WHERE id='".$_GET['booking']."'");
			$room_info = $db->get_row("SELECT id,room_name FROM rooms WHERE id = '".$book->room."'");	
  
   ?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8" />
    <title><?php echo $site_info->hotel_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    
    <!-- Puligins -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker-hotel/css/datepicker.css" />
    
  </head>
  
  <body>
  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="/index.html">Sirak</a>
            </div>

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


    <div class="container">
    <div id="row">
    <div class="col-md-6 col-md-offset-3"> 

    
    <h2 class="text-center">Hotel Booking Form</h2>
    <hr>
 
    
			<div class="panel panel-primary">
              <div class="panel-heading"><?php echo $lang['FORM_NAME']; ?></div>
               <div class="panel-body">
               
               
	<?php 
    
    switch($_GET['page']){
		
		/*Paypal Form*/
		case"PaypalForm":
			if($book->status !='0'){
			
			?>
		<div class="alert alert-warning">
        	<strong>Warning!</strong> <?php echo $lang['BOOKING_FOUND']; ?> 
      	</div>
        
			
		<?php	
			}else{
		?>
        
		<table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-md-4"><?php echo $lang['NAME']; ?></td>
              <td><?php echo $book->name; ?> (<?php echo $book->user_ip; ?>)</td>
            </tr>
            <tr>
              <td><?php echo $lang['EMAIL']; ?></td>
              <td><?php echo $book->email; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['PHONE']; ?></td>
              <td><?php echo $book->phone; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['ADULTS']; ?></td>
              <td><?php echo $book->adults; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['CHILDREN']; ?></td>
              <td><?php echo $book->children; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['TYPE_OF_ROOM']; ?></td>
              <td><?php echo $room_info->room_name; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['IN_OUT_DATE']; ?></td>
              <td><?php echo $book->in_date; ?> - <?php echo $book->out_date; ?> </td>
            </tr>
            <tr>
              <td><?php echo $lang['TOTAL_DAYS']; ?></td>
              <td><?php echo $book->days; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['DATE']; ?></td>
              <td><?php echo date($site_info->date_format, $book->time); ?> (<?php echo nicetime(date("Y-m-d H:i", $book->time)); ?>)</td>
            </tr>
            <tr>
              <td><?php echo $lang['NOTE']; ?></td>
              <td><?php echo $book->comments; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['TOTAL_PRICE']; ?></td>
              <td><?php echo number_format($book->price,2); ?> x <?php echo $book->days; ?> = <?php $total = $book->price * $book->days; echo number_format($total,2); ?> <?php echo $site_info->currency;?> </td>
            </tr>
            <tr>
              <td><?php echo $lang['PAYMENT_TYPE']; ?></td>
              <td>
			  <?php if($book->pay_type =='paypal'){
				  
					  	echo $lang['PAYPAL_PAY']; 
						
						}elseif($book->pay_type =='cc'){
						
						echo $lang['CC_PAY']; 
						  
						}elseif($book->pay_type =='hotel'){
						echo $lang['HOTEL_PAY'];	
						}else{}
				  
				  ?>
             
			  </td>
            </tr>
            <tr>
              <td></td>
              <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"> 
            <input type="hidden" name="cmd" value="_xclick"> 
            <input type="hidden" name="business" value="<?php echo $site_info->paypal_email;?>"> 
            <input type="hidden" name="lc" value="TR"> 
            <input type="hidden" name="item_name" value="<?php echo $site_info->hotel_name; ?> - <?php echo $room_info->room_name; ?> [<?php echo $book->days; ?> DAY]"> 
            <input type="hidden" name="item_number" value="<?php echo $book->id; ?>"> 
            <input type="hidden" name="amount" value="<?php echo number_format($total,2); ?>"> 
            <input type="hidden" name="currency_code" value="<?php echo $site_info->currency;?>"> 
            <input type="hidden" name="button_subtype" value="services"> 
            <input type="hidden" name="no_note" value="1"> 
            <input type="hidden" name="no_shipping" value="1"> 
            <input type="hidden" name="rm" value="1"> 
            <input type="hidden" name="return" value="<?php echo $site_info->sistem_base; ?>paypal.php?page=PaypalSuccess&booking=<?php echo $book->id; ?>"> 
            <input type="hidden" name="cancel_return" value="<?php echo $site_info->sistem_base; ?>paypal.php?page=PaypalForm&booking=<?php echo $book->id; ?>"> 
            <button type="submit" class="btn btn-success"><?php echo $lang['PAYPAL_PAY'] ?></button>
        </form> </td>
            </tr>
          </tbody>
        </table> 
		<hr>     
                     
         
        
        <div class="row">
              <div class="col-md-12 col-md-offset-3">
			 	<?php echo $lang['OTHER_PAY'] ?> <br>
            	<a href="cc.php?page=ccForm&booking=<?php echo $book->id; ?>" class="btn btn-default"><?php echo $lang['CC_PAY'] ?></a> or 
            	 <a href="paylater.php?page=paylaterForm&booking=<?php echo $book->id; ?>" class="btn btn-default"><?php echo $lang['HOTEL_PAY'] ?></a>
            </div>
            </div>
		
		<?php
        }// Status Kontor if
		
		/*Paypal Form*/
		break;
		
		case"PaypalSuccess":
		
		
		$bbok_id = $_GET['booking'];
		
		$update_db = $db->query("UPDATE bookings SET status='1', approval_status='0', pay_type='paypal' WHERE id='$bbok_id'");
		
		
		
		/*Sen E-mail*/
		
		$headers  = "MIME-Version: 1.0" . "\r\n";  
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";  
		$headers .= "To: <'".$book->email."'>" . "\r\n";  
		$headers .= "From: <'".$site_info->email."'>" . "\r\n";  
		$headers .= "Reply-To:<'".$site_info->email."'>" . "\r\n";  
		$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";  
		
		
		$to_email = $book->email;  
		
		$subject = $site_info->hotel_name.'-'.$lang['BOOKING_SERVICE'];  
		
		$message = $lang['PAY_SUCCESSFUL']."<br> <br> <br> <br> <br>'".$site_info-hotel_name."' <br>
		
		";  
		
		mail($to_email, $subject, $message, $headers); 
		
		
		
		
		
		
		?>
        
        <div class="alert alert-success">
        	<strong>Well done! </strong> <?php echo $lang['PAY_SUCCESSFUL'];?>
      	</div>
        
        
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-md-4"><?php echo $lang['NAME']; ?></td>
              <td><?php echo $book->name; ?> (<?php echo $book->user_ip; ?>)</td>
            </tr>
            <tr>
              <td><?php echo $lang['ADULTS']; ?></td>
              <td><?php echo $book->adults; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['CHILDREN']; ?></td>
              <td><?php echo $book->children; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['TYPE_OF_ROOM']; ?></td>
              <td><?php echo $room_info->room_name; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['IN_OUT_DATE']; ?></td>
              <td><?php echo $book->in_date; ?> - <?php echo $book->out_date; ?> </td>
            </tr>
            <tr>
              <td><?php echo $lang['TOTAL_DAYS']; ?></td>
              <td><?php echo $book->days; ?></td>
            </tr>
            <tr>
              <td><?php echo $lang['TOTAL_PRICE']; ?></td>
              <td><?php echo number_format($book->price,2); ?> x <?php echo $book->days; ?> = <?php $total = $book->price * $book->days; echo number_format($total,2); ?> <?php echo $site_info->currency;?> </td>
            </tr>
            <tr>
              <td><?php echo $lang['PAYMENT_TYPE']; ?></td>
              <td>
			  <?php if($book->pay_type =='paypal'){
				  
					  	echo $lang['PAYPAL_PAY']; 
						
						}elseif($book->pay_type =='cc'){
						
						echo $lang['CC_PAY']; 
						  
						}elseif($book->pay_type =='hotel'){
						echo $lang['HOTEL_PAY'];	
						}else{}
				  
				  ?>
             
			  </td>
            </tr>
          </tbody>
        </table> 
        
		
		<?php 
		break;
		
		
		
		}
    
    ?>
               
               
    
                
      
              
    
    </div>
    </div>
    </div>
    
    
    <!-- JavaScript plugins (requires jQuery) -->
    <script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
 

  </body>
</html>


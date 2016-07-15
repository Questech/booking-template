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
		case"ccForm":
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
          </tbody>
        </table> 
		<hr>     
          <?php 
		  
		  /*cc Form*/ 
		  
		  ?> 
          
           <form class="form-horizontal" action="#" method="post" role="form">
              
              <div class="form-group">
                <label for="inputPassword" class="col-sm-4 control-label">Full Name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="fulname" id="fulname" placeholder="Enter Full Name">
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputPassword" class="col-sm-4 control-label">Cart Number</label>
                <div class="col-sm-8">
                  <input name="cart_number" type="text" class="form-control" id="cart_number" placeholder="Enter Cart Number" maxlength="16">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-4 control-label">Cart Date</label>
                <div class="col-sm-4">
                  <input name="month" type="text" class="form-control" id="month" placeholder="mm" maxlength="2">
                  </div>
                  <div class="col-xs-4">
                  <input name="year" type="text" class="form-control" id="yer" placeholder="YY" maxlength="2">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-4 control-label">CVV Number</label>
                <div class="col-sm-4">
                  <input name="cvv" type="text" class="form-control" id="cvv" placeholder="CVV Code" maxlength="16">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                  <button type="submit" class="btn btn-success"><?php echo $lang['CC_PAY'] ?></button>
                </div>
              </div>
             
            </form>   
            <hr>
            
            
            <div class="row">
              <div class="col-md-12 col-md-offset-3">
			 <?php echo $lang['OTHER_PAY'] ?> <br>
            <a href="paypal.php?page=PaypalForm&booking=<?php echo $book->id; ?>" class="btn btn-default"><?php echo $lang['PAYPAL_PAY'] ?></a> or 
            <a href="paylater.php?page=paylaterForm&booking=<?php echo $book->id; ?>" class="btn btn-default"><?php echo $lang['HOTEL_PAY'] ?></a>
            </div>
            </div>
                
     
     
     
		
		<?php
        }// Status Kontor if
		
		
		break;
		
		case"ccSuccess":
		
		
		$bbok_id = $_GET['booking'];
		
		$update_db = $db->query("UPDATE bookings SET status='1', approval_status='0', pay_type='cc' WHERE id='$bbok_id'");
		
		
		
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


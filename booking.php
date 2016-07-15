<?php 
session_start(); 
ob_start(); 
include ('includes/db_config.php');
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8" />
    <title>Contact Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    
    <!-- Plugins -->
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
                <a class="navbar-brand page-scroll" href="./index.html">Sirak</a>
            </div>

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

  <div align="center"><img class="logo" src="assets/images/example_logo.png" title="LOGO" alt="SIRAK"></div>
  
  
 <?php
			if($_GET){

			$_SESSION['lan'] = $_GET["lng"];

			}
		


			if(isset($_SESSION['lan']))
			{

			include('language/'.$_SESSION['lan'].'.php');
				
			}else{
			
			include ("language/".$site_info->language);

			}
  
   ?>
    <div class="container">
    <div id="row">
    <div class="col-md-6 col-md-offset-3"> 

    
    <h2 class="text-center">Hotel Booking Form</h2>
    <hr>
 
    
			<div class="panel panel-primary">
              <div class="panel-heading"><?php echo $lang['FORM_NAME']; ?></div>
               <div class="panel-body">
               
         
               
               
                
                <p></p>
                
        
                             
              <div id="reservation-div"></div>
              
             
             
	<form id="form-reservation" method="post" action="reservation.php">

		<div class="row">
			<div class="col-lg-6">
				<p>
					<label><?php echo $lang['NAME'] ?></label>
					<input id="name" class="form-control" name="name" type="text" />
				</p>
			</div>
			
			<div class="col-lg-6">
				<p>
					<label for="phone"><?php echo $lang['EMAIL'] ?>:</label>
					<input id="email" class="form-control" name="email" type="text" />
				</p>
			</div>
		</div>
			
			
		<div class="row">
            <div class="col-lg-6">
				<p>
					<label for="phone"><?php echo $lang['PHONE'] ?>:</label>
					<input id="phone" class="form-control" name="phone" type="text" />
			  </p>
			</div>
			<div class="col-lg-3">
				<p>
					<label><?php echo $lang['ADULTS'] ?>:</label>
					<select id="adults" class="form-control" name="adults">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
					</select>
				</p>
			 </div>
			<div class="col-lg-3">
				<p>
					<label><?php echo $lang['CHILDREN'] ?>:</label>
					<select id="children" class="form-control" name="children">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</p>
		   </div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<p>
				<label><?php echo $lang['TYPE_OF_ROOM'] ?>:</label>
					<select id="room" class="form-control" name="room">
						<option value=""><?php echo $lang['SELECT_ROOM'] ?></option>
				
						<?php
						$results = $db->get_results("SELECT id,room_name,price FROM rooms ORDER BY sort ASC");
						foreach ( $results as $row )
						{
						?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->room_name; ?> [ <?php echo number_format($row->price,2); ?> <?php echo $site_info->currency; ?> / Day ]</option>
                        <?php
						}
						?> 
                                              
					</select>
				</p>
			</div>
		</div>
			
		<div class="row">
			<div class="col-lg-6">	
				<p>
                	<label><?php echo $lang['CHECK_IN_DATE'] ?>:</label>
                	<input name="in_date" type="text" class="form-control" id="dpd1" value="" >
                </p>
			</div>
            
			<div class="col-lg-6">
				<p>
                	<label><?php echo $lang['CHECK_OUT_DATE'] ?>:</label>
                	<input name="out_date" type="text" class="form-control" id="dpd2" value="" >
				</p>
			</div>
			</div>
			
			
		<div class="row"> 
			<div class="col-lg-12">	
				<p>
					<label for="comments"><?php echo $lang['WANT_TO_SAY'] ?></label>
					<textarea id="comments" class="form-control" name="comments" rows="3"></textarea>
				</p>
			</div>
		 </div>
         
         
		<div class="row"> 
			<div class="col-lg-12">	
				<p>
					<label for="comments"><?php echo $lang['PAYMENT_OPTIONS'] ?></label>
					<select id="pay_type" class="form-control" name="pay_type">
						<option value=""><?php echo $lang['SELECT_PAYMENT_OPTIONS'] ?></option>
						<?php if($site_info->paypal_pay=='1'){ ?>
                        <option value="paypal"><?php echo $lang['PAYPAL_PAY'] ?></option>
                        <?php } ?>
                        <?php if($site_info->cc_pay=='1'){ ?>
                        <option value="cc"><?php echo $lang['CC_PAY'] ?></option> 
                         <?php } ?>
                        <option value="hotel"><?php echo $lang['HOTEL_PAY'] ?></option>                    
					</select>
				</p>
			</div>
		 </div>
         <br>
         
       
		
		<div class="row"> 
		
			<div class="col-lg-12">	

		<p>
			<button type="submit" id="submit" class="btn btn-primary btn-lg btn-block">
            <div class="loading" style="display:none"><img src="assets/images/ajax-loader.gif"> </div>
			<span><?php echo $lang['BOOKING_NOW'] ?></span>
            </button>
		</p>
        
        </div>
        </div>
	
	</form>
                
      
              
    
    </div>
    </div>
    </div>
    
    
    <!-- JavaScript plugins (requires jQuery) -->
    <script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
     
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   
    
    <!-- plugins -->
    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker-hotel/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
	<script>
	if (top.location != location) {
    top.location.href = document.location.href ;
  		}
		$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'mm-dd-yyyy'
			});
			$('#dp2').datepicker();
		

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});
	</script>


	<!-- Form Post -->
    <script type="text/javascript">
    $(document).ready(function(){
        $("#submit").click(function(){
            var data = $("#form-reservation").serialize();
				var t = $(this);
				$("span",this).hide();
				$(".loading",this).show();
            $.ajax({
                type	: "POST",
                url 	: "ajax/booking.php",
                data 	: data,
                success : function(q)
					{
                    $("#reservation-div").html(q);
					$(".loading",t).hide();
						$("span",t).show();
					}
            	});
            return false;
        });
    });
    </script>  
    
    

    

  </body>
</html>


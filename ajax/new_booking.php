<?php
session_start();
ob_start();
include ('../includes/db_config.php');
include ("../language/".$site_info->language);
include ("../includes/functions.php");


sleep(2);

if(isset($_POST["id"]) && $_POST["id"] != "0")
{
  $lost_id= $_POST["id"]; 

                  $query = $db->get_results("SELECT * FROM bookings WHERE status='1' AND approval_status='0' AND id < '$lost_id' ORDER BY id DESC LIMIT 10");
                  
                  foreach ( $query as $row )
                  {
          
                  $room =  $db->get_row("SELECT id,room_name FROM rooms WHERE id='".$row->room."'"); 
                ?>
                
                   <tr id="<?php echo $row->id; ?>">
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->email; ?> <br> <?php echo $row->phone; ?></td>
                    <td><?php echo $room->room_name; ?></td>
                    <td><?php echo $row->in_date; ?> <br> <?php echo $row->out_date; ?></td>
                    <td><?php echo date($site_info->date_format, $row->time); ?><br /> (<?php echo nicetime(date("Y-m-d H:i", $row->time)); ?>)</td>
                    <td>
                   <a href="booking_details.php?booking=<?php echo $row->id; ?>" class="btn btn-info"><span class="glyphicon glyphicon-check"></span> <?php echo $lang['MANAGE']; ?></a>
                  <?php
				  /* 
                    <a data-toggle="modal" data-target="#myModal" data-id="<?php echo $row->id; ?>" class="open-AddBookDialog btn btn-info" href="#addBookDialog"><?php echo $lang['MANAGE']; ?></a>
                    
                    */ ?> 
                    </td>
                  </tr>
            <?php } 
}
?> 

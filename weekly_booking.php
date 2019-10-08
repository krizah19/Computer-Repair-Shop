<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

// Get Record

if(date("w")==1)
{
	$condition=" CURDATE() <= ticket_date";
}
else
{
	$start_date=date('Y-m-d', strtotime('Last Monday', time()));
	$condition=" ticket_date>='$start_date'";
}

$sql = "SELECT * FROM `booking_ticket` WHERE ".$condition." AND ticket_condition!='D' ORDER BY ticket_auto_id DESC ";
$query = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($query);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <title>CMS :: Dashboard</title>

   <?php include("script.php"); ?>
  </head>

  <body>
    <?php include("admin_header.php"); ?>
	
    <div class="container-fluid">
      <div class="row">        
        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
          <!--<h1 class="page-header">Dashboard</h1>-->
          
          <h2 class="sub-header">All Booking Weekly</h2>		  
		  		   
          <div class="table-responsive">
		  <form name="form1" id="form1" action="" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Booking Date</th>
                  <th>Booking For</th>
                  <th>Customer&nbsp;Source</th>
                  <th>Booking Status</th>
                  <th>Booking&nbsp;Amount</th>				  
                </tr>
              </thead>
              <tbody>
			  <?php 
			  $booking_total=0.00;
			  
			  if($rows>0){
			  while($fetch = mysql_fetch_array($query))
			  {	
			   $booking_total=$booking_total+$fetch['ticket_grand_total'];	
			   
			    $sql_601 = "SELECT * FROM `booking_customer` WHERE `customer_auto_id`='".$fetch['ticket_customer_id']."' ";
				$query_601 = mysql_query($sql_601) or die(mysql_error());
				$rowCustos = mysql_fetch_array($query_601);

				$sql_602 = "SELECT * FROM `booking_ticket_status` WHERE status_id='".$fetch['ticket_status']."' ";
				$query_602 = mysql_query($sql_602) or die(mysql_error());
				$rowTicketStatus = mysql_fetch_array($query_602);
	  
			  ?>
                <tr>
                  <td><?php echo $fetch['ticket_date'];?></td>
                  <td><?php echo $rowCustos['customer_title']." ".$rowCustos['customer_name']; ?></td>
                  <td><?php if($fetch['ticket_onsite_booking']=='Y'){?>Onsite<?php } else{?>Workshop<?php }?></td>
                  <td><?php echo $rowTicketStatus['name']; ?></td>
                  <td><?php echo number_format(($fetch['ticket_grand_total']),2,".",","); ?></td>				  
                </tr>
              <?php }} ?>  
              </tbody>
			  
			  <?php if($rows>0) { ?>
			  <tfoot>
				<tr>
					<td colspan="4">&nbsp;</td>
					<td><strong>Total: <?php echo number_format($booking_total,2,".",","); ?></strong></td>
				  </tr>
				</tfoot>
			  <?php } ?>
            </table>
			</form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	 <?php include("footer.php"); ?>
	
   
  </body>
</html>

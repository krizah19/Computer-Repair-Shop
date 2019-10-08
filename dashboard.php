<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}
	
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
	
    <div class="container theme-showcase" role="main">
	  <div class="page-header">
        <h1>Dashboard</h1>
      </div>
	  
	  <div class="row">
        <div class="col-sm-4">         
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Booking Summary (Weekly)</h3>			  
            </div>
            <div class="panel-body">
			<?php 
			
			// Booking Summary (Weekly)
			
			if(date("w")==1)
				$condition=" AND CURDATE() <= ticket_date";
			else
				$start_date=date('Y-m-d', strtotime('Last Monday', time()));
			
			if($start_date)
	  		$condition=" AND ticket_date>='$start_date'";	
				
			$sql_301 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition." ";
			$query_301 = mysql_query($sql_301) or die(mysql_error());
			$rows_301 = mysql_num_rows($query_301);
			
			$sql_302 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition." AND ticket_status='6' ";
			$query_302 = mysql_query($sql_302) or die(mysql_error());
			$rows_302 = mysql_num_rows($query_302);
			
			$sql_303 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition." AND ticket_status='7' ";
			$query_303 = mysql_query($sql_303) or die(mysql_error());
			$rows_303 = mysql_num_rows($query_303);
			
			$sql_304 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition." AND ticket_status='11' ";
			$query_304 = mysql_query($sql_304) or die(mysql_error());
			$rows_304 = mysql_num_rows($query_304);
			
			$sql_305 = "SELECT sum(ticket_grand_total) as booking_amount FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition." ";
			$query_305 = mysql_query($sql_305) or die(mysql_error());
			$rows_305 = mysql_fetch_array($query_305);
				
			?>
              <table class="table table-striped">
			  	<tr>
					<td>Total Ticket</td>
					<td>:</td>
					<td><?php echo $rows_301; ?></td>
				</tr>
				<tr>
					<td>Ready Ticket</td>
					<td>:</td>
					<td><?php echo $rows_302; ?></td>
				</tr>
				<tr>
					<td>Finished Ticket</td>
					<td>:</td>
					<td><?php echo $rows_303; ?></td>
				</tr>
				<tr>
					<td>Cancelled Ticket</td>
					<td>:</td>
					<td><?php echo $rows_304; ?></td>
				</tr>
				<tr>
					<td>Booking Amount</td>
					<td>:</td>
					<td><?php echo $rows_305['booking_amount']; ?></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><a href="weekly_booking.php"><button type="button" class="btn btn-lg btn-success">Details</button></a></td>					
				</tr>				
			  </table>
            </div>
          </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-4">          
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Booking Summary (Monthly)</h3>
            </div>
            <div class="panel-body">
			<?php 
			// Booking Summary (Monthly)
			
			$start_date2=date('Y-m-01');
						
			if($start_date2)
	  		$condition2=" AND ticket_date>='$start_date2'";	
				
			$sql_3012 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition2." ";
			$query_3012 = mysql_query($sql_3012) or die(mysql_error());
			$rows_3012 = mysql_num_rows($query_3012);
			
			$sql_3022 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition2." AND ticket_status='6' ";
			$query_3022 = mysql_query($sql_3022) or die(mysql_error());
			$rows_3022 = mysql_num_rows($query_3022);
			
			$sql_3032 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition2." AND ticket_status='7' ";
			$query_3032 = mysql_query($sql_3032) or die(mysql_error());
			$rows_3032 = mysql_num_rows($query_3032);
			
			$sql_3042 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition2." AND ticket_status='11' ";
			$query_3042 = mysql_query($sql_3042) or die(mysql_error());
			$rows_3042 = mysql_num_rows($query_3042);
			
			$sql_3052 = "SELECT sum(ticket_grand_total) as booking_amount FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition2." ";
			$query_3052 = mysql_query($sql_3052) or die(mysql_error());
			$rows_3052 = mysql_fetch_array($query_3052);
	

			
			?>
              <table class="table table-striped">
			  	<tr>
					<td>Total Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3012; ?></td>
				</tr>
				<tr>
					<td>Ready Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3022; ?></td>
				</tr>
				<tr>
					<td>Finished Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3032; ?></td>
				</tr>
				<tr>
					<td>Cancelled Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3042; ?></td>
				</tr>
				<tr>
					<td>Booking Amount</td>
					<td>:</td>
					<td><?php echo $rows_3052['booking_amount']; ?></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><a href="monthly_booking.php"><button type="button" class="btn btn-lg btn-primary">Details</button></a></td>					
				</tr>				
			  </table>
            </div>
          </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-4">          
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Booking Summary (Yearly)</h3>
            </div>
            <div class="panel-body">
			<?php 
			// Booking Summary (Yearly)
			
			$start_date3=date('Y-01-01');
			
			if($start_date3)
	  		$condition3=" AND ticket_date>='$start_date3'";	
				
			$sql_3013 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition3." ";
			$query_3013 = mysql_query($sql_3013) or die(mysql_error());
			$rows_3013 = mysql_num_rows($query_3013);
			
			$sql_3023 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition3." AND ticket_status='6' ";
			$query_3023 = mysql_query($sql_3023) or die(mysql_error());
			$rows_3023 = mysql_num_rows($query_3023);
			
			$sql_3033 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition3." AND ticket_status='7' ";
			$query_3033 = mysql_query($sql_3033) or die(mysql_error());
			$rows_3033 = mysql_num_rows($query_3033);
			
			$sql_3043 = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition3." AND ticket_status='11' ";
			$query_3043 = mysql_query($sql_3043) or die(mysql_error());
			$rows_3043 = mysql_num_rows($query_3043);
			
			$sql_3053 = "SELECT sum(ticket_grand_total) as booking_amount FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition3." ";
			$query_3053 = mysql_query($sql_3053) or die(mysql_error());
			$rows_3053 = mysql_fetch_array($query_3053);	

			
			?>
              <table class="table table-striped">
			  	<tr>
					<td>Total Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3013; ?></td>
				</tr>
				<tr>
					<td>Ready Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3023; ?></td>
				</tr>
				<tr>
					<td>Finished Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3033; ?></td>
				</tr>
				<tr>
					<td>Cancelled Ticket</td>
					<td>:</td>
					<td><?php echo $rows_3043; ?></td>
				</tr>
				<tr>
					<td>Booking Amount</td>
					<td>:</td>
					<td><?php echo $rows_3053['booking_amount']; ?></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><a href="yearly_booking.php"><button type="button" class="btn btn-lg btn-warning">Details</button></a></td>					
				</tr>				
			  </table>
            </div>
          </div>
        </div><!-- /.col-sm-4 -->
      </div>
		
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	 <?php include("footer.php"); ?>
	
   
  </body>
</html>

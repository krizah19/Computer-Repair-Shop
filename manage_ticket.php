<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

$ticket_auto_id=$_REQUEST['ticket_auto_id'];
$cusId = $_REQUEST['cusId'];

$caption="Add New";

$sqlCugfhs = "SELECT * FROM `booking_ticket_status` WHERE status='A' ORDER BY name ASC ";
$queryghCus = mysql_query($sqlCugfhs) or die(mysql_error());

$sql401 = "SELECT * FROM `booking_admin` WHERE admin_type='Engineer' and admin_status='A' ORDER BY admin_fname ASC ";
$query401 = mysql_query($sql401) or die(mysql_error());


$sql402 = "SELECT * FROM `booking_item` WHERE item_status='A' ORDER BY item_name ASC ";
$query402 = mysql_query($sql402) or die(mysql_error());

$dataPro = array(); 
while (($allPro = mysql_fetch_array($query402, MYSQL_ASSOC)) !== false){
  $dataPro[] = $allPro; 
}

$sql403 = "SELECT * FROM `booking_customer` WHERE customer_auto_id='".$cusId."' ";
$query403 = mysql_query($sql403) or die(mysql_error());
$rowCustos = mysql_fetch_array($query403);


$sql404 = "SELECT * FROM `booking_ticket_update` WHERE update_ticket_id='".$ticket_auto_id."' ORDER BY update_auto_id DESC ";
$query404 = mysql_query($sql404) or die(mysql_error());



/*+++++++++++++++++++++++++++++Auto Generated No+++++++++++++++++++++++++++++*/
	
		$sqlxCount = "SELECT * FROM `booking_ticket`";
		$sqlCQuer = mysql_query($sqlxCount) or die(mysql_error());			
		$totalrows = mysql_num_rows($sqlCQuer);
		
		$setno=$totalrows+1;
	
		if($setno<10)
		{
			$autono = "000".$setno;
		}
		elseif($setno<100 && $setno>=10)
		{
			$autono = "00".$setno;
		}
		elseif($setno<1000 && $setno>=100)
		{
			$autono = "0".$setno;
		}
		else
		{
			$autono = $setno;
		}				
	
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// Insert & Update Query 


if($_POST['Submit'])
{	

	$_POST['ticket_items']=$_POST['ticket_addon_items'];	
    if(count($_POST['ticket_addon_items'])>0) 
	{
		$_POST['ticket_addon_items']=implode(NAME_VAL_SEP,$_POST['ticket_addon_items']);
	}
				
	if($ticket_auto_id)
	{		
		$sqlUpdate = "UPDATE `booking_ticket` SET 
		ticket_date='".$_POST['ticket_date']."' ,
		ticket_priority='".$_POST['ticket_priority']."' ,
		ticket_product_make='".$_POST['ticket_product_make']."' ,		
		ticket_addon_items='".$_POST['ticket_addon_items']."' ,
		ticket_windows_password='".$_POST['ticket_windows_password']."' ,
		ticket_problem_describtion='".$_POST['ticket_problem_describtion']."' ,
		ticket_enginner='".$_POST['ticket_enginner']."' ,		
		ticket_status='".$_POST['ticket_status']."' ,	
		ticket_diagnose='".$_POST['ticket_diagnose']."' ,								
		ticket_mddt=NOW()		
		WHERE ticket_auto_id='".$ticket_auto_id."' ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
		
		
		$_POST['update_admin_id']= $_SESSION['admin_id'] ;
		$_POST['update_ticket_id']= $ticket_auto_id;		
		$_POST['update_engineer']= $_SESSION['admin_fname'] ;
		$_POST['update_status']= $_POST['ticket_status'] ;				
		$_POST['update_description']= $_POST['ticket_diagnose'] ;		
				
		$sql601 = "INSERT INTO `booking_ticket_update` SET 
		update_admin_id='".$_POST['update_admin_id']."' ,
		update_ticket_id='".$_POST['update_ticket_id']."' ,
		update_engineer='".$_POST['update_engineer']."' ,		
		update_status='".$_POST['update_status']."' ,
		update_description='".$_POST['update_description']."' ,			
		update_crdate=NOW()		
		";
		$query601 = mysql_query($sql601) or die(mysql_error());		
				
		echo '<script>window.location.href="manage_ticket.php?ticket_auto_id='.$ticket_auto_id.'&msg=success"</script>';				
	}
	else
	{		
		$ticketId = "T".$autono;
							
		$sqlInsert = "INSERT INTO `booking_ticket` SET 
		ticketId='".$ticketId."' ,
		ticket_customer_id='".$_POST['ticket_customer_id']."' ,
		ticket_date='".$_POST['ticket_date']."' ,
		ticket_priority='".$_POST['ticket_priority']."' ,
		ticket_product_make='".$_POST['ticket_product_make']."' ,		
		ticket_addon_items='".$_POST['ticket_addon_items']."' ,
		ticket_windows_password='".$_POST['ticket_windows_password']."' ,
		ticket_problem_describtion='".$_POST['ticket_problem_describtion']."' ,
		ticket_enginner='".$_POST['ticket_enginner']."' ,		
		ticket_diagnose='".$_POST['ticket_diagnose']."' ,								
		ticket_crdt=NOW(),
		ticket_status=1			
		";
		$queryInsert = mysql_query($sqlInsert) or die(mysql_error());
		
		$tk_inser_Id = mysql_insert_id();
				
		echo '<script>window.location.href="manage_ticket.php?ticket_auto_id='.$tk_inser_Id.'&msg=success"</script>';
	}		
	
	
}

// Get Record

if($ticket_auto_id)
{
	$caption="Edit";
	
	$sqlxCoGGunt = "SELECT * FROM `booking_ticket` WHERE ticket_auto_id='".$ticket_auto_id."' ";
	$sqlCQuKKer = mysql_query($sqlxCoGGunt) or die(mysql_error());	
	$row = mysql_fetch_array($sqlCQuKKer);	
	
	$sqlCus = "SELECT * FROM `booking_customer` WHERE customer_auto_id='".$row['ticket_customer_id']."' ";
    $queryCus = mysql_query($sqlCus) or die(mysql_error());
    $rowTkCustos = mysql_fetch_array($queryCus);
	
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
   
<link rel="stylesheet" href="js/time_picker/include/jquery-ui-1.8.14.custom.css" type="text/css" />
<link rel="stylesheet" href="js/time_picker/jquery-ui-timepicker.css?v=0.2.4" type="text/css" />
<script type="text/javascript" src="js/time_picker/jquery-ui.min.js"></script>
<link rel="stylesheet" href="js/time_picker/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="js/time_picker/include/jquery.ui.position.min.js"></script>
<script type="text/javascript" src="js/time_picker/jquery.ui.timepicker.js?v=0.2.4"></script>

<script language="javascript">
$(document).ready(function() {
$("#ticket_date").datepicker({
	yearRange: "2000:2100"  ,
	changeMonth: true,
	changeYear: true,
	dateFormat: "yy-mm-dd",
	showAnim: "fadeIn",
	duration: 1	
	});		

});
</script>

<style type="text/css">
#ui-datepicker-div{
display:none;
}
</style>

  </head>

  <body>
    <?php include("admin_header.php"); ?>
	
    <div class="container">        
        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
      
		  <?php if(!empty($_GET['msg']) && $_GET['msg']=="success"){?>
		  <div class="alert alert-success">
			<?php echo UPDATE; ?>
		  </div>
		  <?php } ?>
		  <?php if(!empty($_GET['msg']) && $_GET['msg']=="error"){?>
		  <div class="alert alert-danger">
			<?php echo USER_EXIST; ?>
		  </div>
		  <?php } ?>
						
		 <div class="table-responsive">      
			 <form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
    	
      <h2><?php echo $caption;?> Ticket</h2>
	  
	  <table class="table table-striped">
	  
	    <?php //if($caption!='Edit'){ ?>
        <?php /*?>
		<tr>
          <td>Customer Name </td>
          <td>
		  <select name="ticket_customer_id" id="ticket_customer_id" class="textbox1" style="width:258px; height:32px;" validate="{required:true,messages:{required:'Please select Customer.'}}">
		  <option value="">Select</option>
		  <?php while($customer = mysql_fetch_array($rowCustomers)){?>
			<OPTION  value="<?php echo $customer['customer_auto_id']; ?>" 
			<?php if($row['ticket_customer_id']==$customer['customer_auto_id']) echo 'selected';?>><?php echo $customer['customer_name']; ?></OPTION>
		  <?php } ?> 
		  </select>
          </td>
        </tr>
		<?php */?>
		
		<?php if($caption!='Edit'){ ?>
		<tr>
          <td>Customer Name : </td>
          <td>
		  <b><?php echo $rowCustos['customer_title']." ".$rowCustos['customer_name']; ?></b>
		  <input type="hidden" name="ticket_customer_id" id="ticket_customer_id" value="<?php echo $rowCustos['customer_auto_id'];?>" />	
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  Customer ID : <b><?php echo $rowCustos['customerId']; ?></b>	  
          </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<?php }?>
		
		<?php if($caption=='Edit'){ ?>
		<tr>
          <td>Customer Name : </td>
          <td>
		  <b><?php echo $rowTkCustos['customer_title']." ".$rowTkCustos['customer_name']; ?></b>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  Customer ID : <b><?php echo $rowTkCustos['customerId']; ?></b>	  
          </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<?php }?>
			
		<tr>
          <td>Date </td>
          <td><input type="text" name="ticket_date" id="ticket_date" readonly="readonly" class="textbox1" style="width:250px" value="<?php echo $row['ticket_date'];?>" validate="{required:true,messages:{required:'Please enter Date.'}}" />
          </td>
        </tr>	
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
          <td>Priority </td>
          <td>
		  <input type="radio" name="ticket_priority" value="None" <?php if($row['ticket_priority']=='None') echo 'checked';?>/>None
		  <input type="radio" name="ticket_priority" value="Low Priority" <?php if($row['ticket_priority']=='Low Priority') echo 'checked';?>/>Low Priority
		  <input type="radio" name="ticket_priority" value="Medium" <?php if($row['ticket_priority']=='Medium') echo 'checked';?>/>Medium
		  <input type="radio" name="ticket_priority" value="High" <?php if($row['ticket_priority']=='High') echo 'checked';?>/>High
          </td>
        </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
          <td>Product and Make </td>
          <td><input type="text" name="ticket_product_make"  class="textbox1" style="width:250px" value="<?php echo $row['ticket_product_make'];?>" validate="{required:true,messages:{required:'Please enter Product and Make.'}}" />
          </td>
        </tr>

		<tr><td colspan="2">&nbsp;</td></tr>
		
		<?php //if($caption!='Edit'){ ?>
		<tr>
          <td>Add-on Items </td>
          <td>
		  <table class="table table-striped">
			<?php			
			for($i=0;$i<count($dataPro);$i=$i+4){ ?>
			<tr>
			  <?php for($j=$i;$j<$i+4;$j++){?>
			  <td><?php if($dataPro[$j]){?>
				<input name="ticket_addon_items[]" type="checkbox" id="ticket_addon_items<?php echo $j; ?>" 
				value="<?php echo $dataPro[$j]["item_auto_id"]; ?>" <?php if (in_array($dataPro[$j]["item_auto_id"], explode(NAME_VAL_SEP,$row['ticket_addon_items']))) { echo 'checked';}?> class="user_perm" />
			  <?php echo $dataPro[$j]["item_name"]; ?><? }else{?>&nbsp;<? }?>
			  </td>
			  <?php }?>
			</tr>
			<?php }?>
		  </table>
          </td>
        </tr>
		
		<?php //} ?>
		
		<tr>
          <td>Windows Password </td>
          <td><input type="text" name="ticket_windows_password"  class="textbox1" style="width:250px" value="<?php echo $row['ticket_windows_password'];?>" validate="{required:true,messages:{required:'Please enter Windows Password.'}}" />
          </td>
        </tr>
		<tr>
          <td>Problem Describtion </td>
          <td><textarea name="ticket_problem_describtion"  class="textbox1" validate="{required:true,messages:{required:'Please enter Problem Describtion.'}}" rows="10" cols="50" /><?php echo $row['ticket_problem_describtion'];?></textarea>
          </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<?php //} ?>
		
		<tr>
          <td>Assigne To Enginner </td>
          <td>
		  <select name="ticket_enginner" id="ticket_enginner" class="textbox1" style="width:258px; height:32px;" validate="{required:false,messages:{required:'Please select Enginner.'}}" <?php if($caption=='Edit1212'){ ?>disabled="disabled"<?php }?>>
		    <option value="">Select</option>
		  <?php while($engineer = mysql_fetch_array($query401)){?>
			<OPTION  value="<?php echo $engineer['admin_id']; ?>" <?php if($row['ticket_enginner']==$engineer['admin_id']) echo 'selected';?>><?php echo $engineer['admin_fname']." ".$engineer['admin_lname']; ?></OPTION>
		  <?php } ?> 
		  </select>
          </td>
        </tr>		
		
		<tr><td colspan="2">&nbsp;</td></tr>
				
        <?php /*?><tr>
          <td valign="top" style="vertical-align:top!important">Status</td>
          <td><input type="radio" name="customer_status" value="A" <?php if($row['customer_status']=='A' || empty($row['customer_status'])) echo 'checked';?>>Active &nbsp;
		  <input type="radio" name="customer_status" value="I" <?php if($row['customer_status']=='I') echo 'checked';?>>Inactive</td>
        </tr><?php */?>
		
		<?php if($caption=='Edit'){ ?>
		<tr>
          <td>Status </td>
          <td>
		  <select name="ticket_status" id="ticket_status" class="textbox1" style="width:258px; height:32px;" validate="{required:true,messages:{required:'Please select Ticket Status.'}}">
		    <option value="">Select</option>
		  <?php while($ticketStatus = mysql_fetch_array($queryghCus)){?>
			<OPTION  value="<?php echo $ticketStatus['status_id']; ?>" <?php if($row['ticket_status']==$ticketStatus['status_id']) echo 'selected';?>><?php echo $ticketStatus['name']; ?></OPTION>
		  <?php } ?> 
		  </select>
          </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
          <td>Diagnose Outcome </td>
          <td><textarea name="ticket_diagnose"  class="textbox1" validate="{required:true,messages:{required:'Please enter Diagnose Outcome.'}}" rows="10" cols="50" /><?php echo $row['ticket_diagnose'];?></textarea>
          </td>
        </tr>		
		<?php } ?>
				
		</table>
		
	  <?php if($caption=="Edit"){?>
	  <div style="float:right; margin-right:4px;">
	  <a href="manage_invoice.php?ticket_auto_id=<?php echo $ticket_auto_id; ?>"><input type="button" name="pctk12" value="Create Invoice"  class="btn btn-lg btn-warning"/></a>
	  
	  <a href="moneyReceipt/MR-<?php echo $row['ticketId']; ?>.pdf" target="_blank"><input type="button" name="pctk1233" value="View Invoice"  class="btn btn-lg btn-info" /></a>
	  
 	  <a href="manage_customer.php?customer_auto_id=<?php echo $row['ticket_customer_id']; ?>" target="_blank"><input type="button" name="pctk123366" value="Edit Customer"  class="btn btn-lg btn-primary" /></a>		
	  </div>
	  <?php } ?>
	  
	  <div class="button button1"><input type="submit"  class="btn btn-lg btn-success" name="Submit" value="Save" />		   
	  <a href="all_ticket.php"><button type="button" class="btn btn-lg btn-primary">Back</button></a>
	  </div>
	  	
	  </form>  
	  
	  
	  <?php if($caption=='Edit'){ ?>
		<br><br>

		<table class="table table-striped">
		<tr>
			<td><div class="alert alert-success"><strong>History:</strong></div></td>	
		</tr>
		<?php while($tkupdat = mysql_fetch_array($query404)){
		
		$sql4035 = "SELECT * FROM `booking_ticket_status` WHERE status_id='".$tkupdat['update_status']."' ";
		$query4035 = mysql_query($sql4035) or die(mysql_error());
		$rowTicSts = mysql_fetch_array($query4035);		
		?>
		<tr>
			<td><strong>Engineer Name:</strong><?php echo $tkupdat['update_engineer']; ?>&nbsp;&nbsp;<strong>Posted:</strong><?php echo $tkupdat['update_crdate']; ?>&nbsp;&nbsp;<strong>Status Changed To:</strong><?php echo $rowTicSts['name']; ?><br />
		<strong>Message:</strong><?php echo $tkupdat['update_description']; ?>
		</td>	
		</tr>	
		<?php } ?>
		</table>
				
		<?php } ?>		
	  
		 </div>
          
        </div>      
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	 <?php include("footer.php"); ?>
	
   
  </body>
</html>

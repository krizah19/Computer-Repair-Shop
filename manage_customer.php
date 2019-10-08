<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

$customer_auto_id=$_REQUEST['customer_auto_id'];
$caption="Add New";


/*+++++++++++++++++++++++++++++Auto Generated No+++++++++++++++++++++++++++++*/
	
		$sqlxCount = "SELECT * FROM `booking_customer`";
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
	if(count($_POST['customer_preferd_contact'])>0) 
	{
		$_POST['customer_preferd_contact']=implode(NAME_VAL_SEP,$_POST['customer_preferd_contact']);
	}
		
	if($customer_auto_id)
	{		
		$sqlUpdate = "UPDATE `booking_customer` SET 
		customer_type='".$_POST['customer_type']."' ,
		customer_title='".$_POST['customer_title']."' ,
		customer_name='".$_POST['customer_name']."' ,		
		customer_address='".$_POST['customer_address']."' ,
		customer_city='".$_POST['customer_city']."' ,
		customer_pincode='".$_POST['customer_pincode']."' ,
		customer_telephone='".$_POST['customer_telephone']."' ,		
		customer_mobile='".$_POST['customer_mobile']."' ,	
		customer_email='".$_POST['customer_email']."' ,	
		customer_notes='".$_POST['customer_notes']."' ,	
		customer_preferd_contact='".$_POST['customer_preferd_contact']."' ,		
		customer_source='".$_POST['customer_source']."' ,					
		customer_mddt=NOW()		
		WHERE customer_auto_id='".$customer_auto_id."' ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
		
		echo '<script>window.location.href="manage_customer.php?customer_auto_id='.$customer_auto_id.'&msg=success"</script>';
				
	}
	else
	{		
		$cusID = "C".$autono;
							
		$sqlInsert = "INSERT INTO `booking_customer` SET 
		customerId='".$cusID."' ,
		customer_type='".$_POST['customer_type']."' ,
		customer_title='".$_POST['customer_title']."' ,
		customer_name='".$_POST['customer_name']."' ,		
		customer_address='".$_POST['customer_address']."' ,
		customer_city='".$_POST['customer_city']."' ,
		customer_pincode='".$_POST['customer_pincode']."' ,
		customer_telephone='".$_POST['customer_telephone']."' ,		
		customer_mobile='".$_POST['customer_mobile']."' ,	
		customer_email='".$_POST['customer_email']."' ,	
		customer_notes='".$_POST['customer_notes']."' ,	
		customer_preferd_contact='".$_POST['customer_preferd_contact']."' ,		
		customer_source='".$_POST['customer_source']."' ,					
		customer_crdt=NOW()		
		";
		$queryInsert = mysql_query($sqlInsert) or die(mysql_error());		
		$customer_inser_Id = mysql_insert_id();
		
		echo '<script>window.location.href="manage_ticket.php?cusId='.$customer_inser_Id.'&msg=success"</script>';
	}		
	
	
}


// Get Record

if($customer_auto_id)
{
	$caption="Edit";
	
	$sqlxCoGGunt = "SELECT * FROM `booking_customer` WHERE customer_auto_id='".$customer_auto_id."' ";
	$sqlCQuKKer = mysql_query($sqlxCoGGunt) or die(mysql_error());	
	$row = mysql_fetch_array($sqlCQuKKer);	
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
      <h2><?php echo $caption;?> Customer  
	  
	  <?php if($caption=="Edit"){?>
	  <div style="float:right; margin-bottom:10px;">
	  <a href="view_label.php?cusId=<?php echo $customer_auto_id; ?>" rel="shadowbox;width=500;height=400;"><input type="button" name="pctk" value="Print Label"  class="btn btn-lg btn-success" /></a>
	  </div>
	  <?php } ?>
	  
	  </h2>
	  
      <table class="table table-striped">
        <tr>
          <td>Customer Type </td>
          <td>
		  <select name="customer_type" id="customer_type" class="textbox1" style="width:258px; height:32px;" validate="{required:true,messages:{required:'Please select Customer Type.'}}">
			<OPTION  value="Business" <?php if($row['customer_type']=='Business') echo 'selected';?>>Business</OPTION>
			<OPTION  value="Individual" <?php if($row['customer_type']=='Individual') echo 'selected';?>>Individual</OPTION>
		  </select>
          </td>
        </tr>
		<tr>
          <td>Title </td>
          <td>
		<select name="customer_title" id="customer_title" class="textbox1" style="width:258px; height:32px;" validate="{required:true,messages:{required:'Please select Customer Title.'}}">
   		    <OPTION  value="Mr" <?php if($row['customer_title']=='Mr') echo 'selected';?>>Mr</OPTION>
			<OPTION  value="Mrs" <?php if($row['customer_title']=='Mrs') echo 'selected';?>>Mrs</OPTION>
			<OPTION  value="Ms" <?php if($row['customer_title']=='Ms') echo 'selected';?>>Ms</OPTION>
			<OPTION  value="Miss" <?php if($row['customer_title']=='Miss') echo 'selected';?>>Miss</OPTION>
			<OPTION  value="Dr" <?php if($row['customer_title']=='Dr') echo 'selected';?>>Dr</OPTION>
			<OPTION  value="Prof" <?php if($row['customer_title']=='Prof') echo 'selected';?>>Prof</OPTION>
		</select>
          </td>
        </tr>	
		<tr>
          <td>Name </td>
          <td><input type="text" name="customer_name"  class="textbox1" style="width:250px" value="<?php echo $row['customer_name'];?>" validate="{required:true,messages:{required:'Please enter Name.'}}" />
          </td>
        </tr>	
		<tr>
          <td>Address </td>
          <td><input type="text" name="customer_address" class="textbox1" style="width:250px" value="<?php echo $row['customer_address'];?>" validate="{required:true,messages:{required:'Please enter Address.'}}" />
          </td>
        </tr>
		<tr>
          <td>Town/City </td>
          <td><input type="text" name="customer_city"  class="textbox1" style="width:250px" value="<?php echo $row['customer_city'];?>" validate="{required:true,messages:{required:'Please enter Town/City.'}}" />
          </td>
        </tr>
		<tr>
          <td>Postcode </td>
          <td><input type="text" name="customer_pincode"  class="textbox1" style="width:250px" value="<?php echo $row['customer_pincode'];?>" validate="{required:true,messages:{required:'Please enter Postcode.'}}" />
          </td>
        </tr>
		<tr>
          <td>Telephone Number </td>
          <td><input type="text" name="customer_telephone"  class="textbox1" style="width:250px" value="<?php echo $row['customer_telephone'];?>" validate="{required:true,digits:true,messages:{required:'Please enter Telephone Number.'}}" />
          </td>
        </tr>
		<tr>
          <td>Mobile Number </td>
          <td><input type="text" name="customer_mobile"  class="textbox1" style="width:250px" value="<?php echo $row['customer_mobile'];?>" validate="{required:true,digits:true,messages:{required:'Please enter Mobile Number.'}}" />
          </td>
        </tr>
		<tr>
          <td>Email Address </td>
          <td><input type="text" name="customer_email"  class="textbox1" style="width:250px" value="<?php echo $row['customer_email'];?>" validate="{required:true,email:true,messages:{required:'Please enter Email Address.'}}" />
          </td>
        </tr>
		<tr>
          <td>Notes </td>
          <td><textarea name="customer_notes" class="textbox1" rows="10" cols="50"><?php echo $row['customer_notes'];?></textarea>
          </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
          <td>Preferd Contact </td>
          <td>
		   <table class="table table-striped">
			<?php
			$preconArr=array(
			1=>'Mobile',
			2=>'Home Phone',
			3=>'Email',
			4=>'SMS'
			);
						
			for($i=1;$i<count($preconArr);$i=$i+4){ ?>
			<tr>
			  <?php for($j=$i;$j<$i+4;$j++){?>
			  <td><?php if($preconArr[$j]){?>
				<input name="customer_preferd_contact[]" type="checkbox" id="customer_preferd_contact<?php echo $j; ?>" value="<?php echo $j; ?>" <?php if (in_array($j, explode(NAME_VAL_SEP,$row['customer_preferd_contact']))) { echo 'checked';}?> class="user_perm" />
			    <?php echo $preconArr[$j]; ?><?php }else{?>&nbsp;<?php }?>
			  </td>
			  <?php }?>
			</tr>
			<?php }?>
		  </table>
		  
		  </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
          <td>Customer Source </td>
          <td>
		 <select name="customer_source" id="customer_source" class="textbox1" style="width:258px; height:32px;" validate="{required:false,messages:{required:'Please select Customer Source.'}}"> 
		    <OPTION value="Internet" <?php if($row['customer_source']=='Internet') echo 'selected';?>>Internet</OPTION>
			<OPTION  value="Leaflets" <?php if($row['customer_source']=='Leaflets') echo 'selected';?>>Leaflets</OPTION>
			<OPTION  value="Word of mouth" <?php if($row['customer_source']=='Word of mouth') echo 'selected';?>>Word of mouth</OPTION>
			<OPTION  value="Recommendation" <?php if($row['customer_source']=='Recommendation') echo 'selected';?>>Recommendation </OPTION>
			<OPTION  value="Radio" <?php if($row['customer_source']=='Radio') echo 'selected';?>>Radio</OPTION>
		</select>
          </td>
        </tr>	
		
		<tr><td colspan="2">&nbsp;</td></tr>
				
        <?php /*?><tr>
          <td valign="top" style="vertical-align:top!important">Status </td>
          <td><input type="radio" name="customer_status" value="A" <?php if($row['customer_status']=='A' || empty($row['customer_status'])) echo 'checked';?>>Active &nbsp;
		  <input type="radio" name="customer_status" value="I" <?php if($row['customer_status']=='I') echo 'checked';?>>Inactive</td>
        </tr><?php */?>
      </table>
	  <?php if($caption=="Edit"){?>
	  <div style="float:left; margin-right:4px;">
	  
	  <a href="all_history.php?cusId=<?php echo $customer_auto_id; ?>"><input type="button" name="ctk12" value="History"  class="btn btn-lg btn-warning" /></a>
	  
	  <a href="manage_ticket.php?cusId=<?php echo $customer_auto_id; ?>"><input type="button" name="ctk" value="Add Ticket"  class="btn btn-lg btn-info" /></a>
	  
	  <a href="all_ticket.php?cusId=<?php echo $customer_auto_id; ?>"><input type="button" name="vctk" value="View Tickets"  class="btn btn-lg btn-primary" /></a>
	  
	  <a href="manage_booking.php?cusId=<?php echo $customer_auto_id; ?>"><input type="button" name="vctkdd" value="Book Onsite"  class="btn btn-lg btn-danger" /></a>
	  </div>
	  <?php } ?>
	       
	  <div class="button button1"><input type="submit"  class="btn btn-lg btn-success" name="Submit" value="Save" />		   
	  <a href="all_customer.php"><button type="button" class="btn btn-lg btn-primary">Back</button></a>
	  </div>
      
    </form>  
		 </div>
          
        </div>      
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	 <?php include("footer.php"); ?>
	
   
  </body>
</html>

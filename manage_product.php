<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

$product_auto_id=$_REQUEST['product_auto_id'];
$caption="Add New";

/*+++++++++++++++++++++++++++++Auto Generated No+++++++++++++++++++++++++++++*/
	
		$sqlxCount = "SELECT * FROM `booking_product`";
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
	
	if($product_auto_id)
	{		
		$sqlUpdate = "UPDATE `booking_product` SET 
		product_name='".$_POST['product_name']."' ,
		product_desc='".$_POST['product_desc']."' ,
		product_price='".$_POST['product_price']."' ,
		product_status='".$_POST['product_status']."' ,
		product_mddt=NOW()	
		WHERE product_auto_id='".$product_auto_id."' ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
		
		echo '<script>window.location.href="manage_product.php?product_auto_id='.$product_auto_id.'&msg=success"</script>';
				
	}
	else
	{
		$itemID = "P".$autono;
				
		$sqlInsert = "INSERT INTO `booking_product` SET 
		productId='".$itemID."' ,
		product_name='".$_POST['product_name']."' ,
		product_desc='".$_POST['product_desc']."' ,
		product_price='".$_POST['product_price']."' ,
		product_status='".$_POST['product_status']."' ,
		product_crdt=NOW()	
		";
		$queryInsert = mysql_query($sqlInsert) or die(mysql_error());
		
		echo '<script>window.location.href="manage_product.php?msg=success"</script>';
	}		
	
	
}

// Get Record

if($product_auto_id)
{
	$caption="Edit";
	
	$sqlxCoGGunt = "SELECT * FROM `booking_product` WHERE product_auto_id='".$product_auto_id."' ";
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
	                
     <div class="table-responsive">      
	  <form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">   
      <h2><?php echo $caption;?> Product</h2>
      <table class="table table-striped">
        <tr>
          <td>Name </td>
          <td><input type="text" name="product_name" value="<?php echo $row['product_name'];?>" validate="{required:true,messages:{required:'Please enter name.'}}" style="width:250px;"/>
          </td>
        </tr>
		<tr>
          <td>Describtion </td>
          <td><textarea name="product_desc" cols="50" rows="10"><?php echo $row['product_desc'];?></textarea>
          </td>
        </tr>	
		<tr>
          <td>Price </td>
          <td><input type="text" name="product_price" value="<?php echo $row['product_price'];?>" validate="{required:true,number:true,messages:{required:'Please enter Price.'}}" style="width:250px;"/>
          </td>
        </tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
			      		
        <tr>
          <td valign="top" style="vertical-align:top!important">Status </td>
          <td><input type="radio" name="product_status" value="A" <?php if($row['product_status']=='A' || empty($row['product_status'])) echo 'checked';?>>Active &nbsp;
		  <input type="radio" name="product_status" value="I" <?php if($row['product_status']=='I') echo 'checked';?>>Inactive</td>
        </tr>
      </table>
      <div class="button button1"> <input type="submit" name="Submit" value="Submit" class="btn btn-lg btn-success" />
	  <a href="all_product.php"><button type="button" class="btn btn-lg btn-primary">Back</button></a>
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

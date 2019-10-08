<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

// Filter condition

$condition='';

if(isset($_REQUEST['filter_productId']) && !empty($_REQUEST['filter_productId']))
{
	$condition.= " AND productId LIKE '%".$_REQUEST['filter_productId']."%'";
}
if(isset($_REQUEST['filter_product_name']) && !empty($_REQUEST['filter_product_name']))
{
	$condition.= " AND product_name LIKE '%".$_REQUEST['filter_product_name']."%'";
}


// Listing Query

$sql = "SELECT * FROM `booking_product` WHERE product_status!='D' ".$condition." ORDER BY product_auto_id DESC ";
$query = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($query);

// For delete

if($_POST['Delete'])
{
	if(count($_POST['chkDel'])>0) 
	{
		$ids=implode(',',$_POST['chkDel']);
		$getDelId="";
		for($k=0;$k<count($_POST['chkDel']);$k++)
		{
			$getDelId.=",".$_POST['chkDel'][$k];
		}
		$allId=trim($getDelId,",");
		if(!empty($allId))
		{
		$sqlUpdate = "UPDATE `booking_product` SET product_status='D' WHERE product_auto_id IN (".$allId.") ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
				
		echo '<script>window.location.href="all_product.php?msg=success"</script>';
		}
	}	
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
	
    <div class="container-fluid">
      <div class="row">        
        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 main">
          <!--<h1 class="page-header">Dashboard</h1>-->
          
	  <?php if(!empty($_GET['msg']) && $_GET['msg']=="success"){?>
      <div class="alert alert-success">
        <?php echo DELETE; ?>
      </div>
	  <?php } ?>
	  	  
          <h2 class="sub-header">All Product <div style="float:right;"><a href="manage_product.php"><button type="button" class="btn btn-lg btn-success">+ Add</button></a></div></h2>		  
		  		   
          <div class="table-responsive">
		  <form name="form1" id="form1" action="" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Describtion</th>
				  <th>Price</th>
				  <th>Status</th>
                  <th>Edit</th>
                  <th>Delete</th>				  
                </tr>
				
				 <tr>
					<td width="10%" align="left" valign="top"><input type="text" name="filter_productId" id="filter_productId" value="" class="form-control" placeholder="Search..." />
					</td>
					<td width="20%" align="left" valign="top"><input type="text" name="filter_product_name" id="filter_product_name" value="" class="form-control" placeholder="Search..." /></td>								
					<td width="10%" align="left" valign="top" colspan="5" style="padding:4px;"><input type="submit" name="Filter" value="Search" class="btn btn-lg btn-warning"></td>								
				</tr>	
							  
              </thead>
              <tbody>
			  <?php 
			  if($rows>0){
			  while($fetch = mysql_fetch_array($query))
			  {			  
			  ?>
                <tr>
                  <td><?php echo $fetch['productId'];?></td>
                  <td><?php echo $fetch['product_name'];?></td>
				  <td><?php echo $fetch['product_desc'];?></td>
				  <td><?php echo $fetch['product_price'];?></td>				  
                  <td><?php 
				  if($fetch['product_status']=='A')
				  	echo "Active"; 
				  else echo "In Active";				  
				  ?></td>
                  <td><a href="manage_product.php?product_auto_id=<?php echo $fetch['product_auto_id'];?>">Edit</a></td>
                  <td><input type="checkbox" name="chkDel[]" value="<?php echo $fetch['product_auto_id'];?>"></td>				  
                </tr>
              <?php }} ?>  
              </tbody>
			  
			  <?php if($rows>0) { ?>
			  <tfoot>
				<tr>
					<td colspan="7"><input type="submit" name="Delete" value="Delete" class="btn btn-lg btn-danger" onClick="javascript:return confirm('Are you sure want to delete?');"></td>
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

<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

// Listing Query

$sql = "SELECT * FROM `booking_admin` WHERE admin_status!='D' AND admin_type='Engineer' ORDER BY admin_id DESC ";
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
		$sqlUpdate = "UPDATE `booking_admin` SET admin_status='D' WHERE admin_id IN (".$allId.") ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
				
		echo '<script>window.location.href="all_engineer.php?msg=success"</script>';
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
	  	  
          <h2 class="sub-header">All Engineer <div style="float:right;"><a href="manage_engineer.php"><button type="button" class="btn btn-lg btn-success">+ Add</button></a></div></h2>		  
		  		   
          <div class="table-responsive">
		  <form name="form1" id="form1" action="" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
				  <th>User Name</th>
                  <th>Email Address</th>
                  <th>User Type</th>				  
				  <th>Status</th>
                  <th>Edit</th>
                  <th>Delete</th>				  
                </tr>
              </thead>
              <tbody>
			  <?php 
			  if($rows>0){
			  while($fetch = mysql_fetch_array($query))
			  {			  
			  ?>
                <tr>
                  <td><?php echo $fetch['admin_fname']." ".$fetch['admin_lname']; ?></td>
                  <td><?php echo $fetch['admin_login'];?></td>
				  <td><?php echo $fetch['admin_email'];?></td>
				  <td><?php echo $fetch['admin_type'];?></td>				  
                  <td><?php 
				  if($fetch['admin_status']=='A')
				  	echo "Active"; 
				  else echo "In Active";				  
				  ?></td>
                  <td><a href="manage_engineer.php?admin_id=<?php echo $fetch['admin_id'];?>">Edit</a></td>
                  <td><input type="checkbox" name="chkDel[]" value="<?php echo $fetch['admin_id'];?>"></td>				  
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

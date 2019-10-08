<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

$admin_id=$_REQUEST['admin_id'];
$caption="Add New";

// Insert & Update Query 

if($_POST['Submit'])
{	
	$sqlChk = "SELECT * FROM `booking_admin` WHERE admin_email='".$_POST['admin_email']."' OR admin_login='".$_POST['admin_login']."' AND admin_status!='D' ";
	$queryChk =  mysql_query($sqlChk) or die(mysql_error());
	$rowsChk = mysql_num_rows($queryChk);
	
	
	if(count($_POST['user_perm'])>0) 
	{
		$_POST['admin_perm']=implode(NAME_VAL_SEP,$_POST['user_perm']);
	}
		
	if($admin_id)
	{		
		$sqlUpdate = "UPDATE `booking_admin` SET 
		admin_type='".$_POST['admin_type']."' ,
		admin_login='".$_POST['admin_login']."' ,
		admin_pass='".$_POST['admin_pass']."' ,		
		admin_fname='".$_POST['admin_fname']."' ,
		admin_lname='".$_POST['admin_lname']."' ,
		admin_email='".$_POST['admin_email']."' ,
		admin_perm='".$_POST['admin_perm']."' ,		
		admin_status='".$_POST['admin_status']."'		
		WHERE admin_id='".$admin_id."' ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
		
		echo '<script>window.location.href="manage_inhouse_user.php?admin_id='.$admin_id.'&msg=success"</script>';
				
	}
	else
	{	
	
	if($rowsChk!=0)
	{
		echo '<script>window.location.href="manage_inhouse_user.php?msg=error"</script>';
		exit;
	}					
		$sqlInsert = "INSERT INTO `booking_admin` SET 
		admin_type='".$_POST['admin_type']."' ,
		admin_login='".$_POST['admin_login']."' ,
		admin_pass='".$_POST['admin_pass']."' ,		
		admin_fname='".$_POST['admin_fname']."' ,
		admin_lname='".$_POST['admin_lname']."' ,
		admin_email='".$_POST['admin_email']."' ,
		admin_perm='".$_POST['admin_perm']."' ,		
		admin_status='".$_POST['admin_status']."'	
		";
		$queryInsert = mysql_query($sqlInsert) or die(mysql_error());
		
		echo '<script>window.location.href="manage_inhouse_user.php?msg=success"</script>';
	}		
	
	
}

// Get Record

if($admin_id)
{
	$caption="Edit";
	
	$sqlxCoGGunt = "SELECT * FROM `booking_admin` WHERE admin_id='".$admin_id."' ";
	$sqlCQuKKer = mysql_query($sqlxCoGGunt) or die(mysql_error());	
	$row_user = mysql_fetch_array($sqlCQuKKer);	
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
	  <h2><?php echo $caption; ?> User</h2>
	  
		  <table class="table table-striped">		  
			<tr>
			  <td>User Type </td>
			  <td>
			  <select name="admin_type" id="admin_type" class="textbox1" style="width:258px; height:32px;" validate="{required:true,messages:{required:'Please select User Type.'}}">			  	
				<?php /*?><OPTION  value="Engineer" <?php if($row_user['admin_type']=='Engineer') echo 'selected';?>>Engineer</OPTION><?php */?>
				<OPTION  value="User" <?php if($row_user['admin_type']=='User') echo 'selected';?>>User</OPTION>
			  </select>
			  </td>
			</tr>
					
			<tr>
			  <td width="130" >User Name :</td>
			  <td><input name="admin_login" type="text" class="textbox1" id="admin_login" value="<?php echo $row_user['admin_login']; ?>" style="width:250px;" <?php if($admin_id) { ?> readonly="true"<?php } ?> validate="{required:true,messages:{required:'Please enter user name.'}}" /></td>
			</tr>
			<tr>
			  <td width="130" >New Password :</td>
			  <td><input name="admin_pass" type="password" class="textbox1" id="admin_pass" style="width:250px;" validate="{password:true<?php if(!$admin_id) { ?>,required:true,messages:{required:'Please enter password.'}<?php } ?>}" /></td>
			</tr>
			<tr>
			  <td width="130" >Verify Password:</td>
			  <td><input name="admin_retype_password" type="password" class="textbox1" id="admin_retype_password" style="width:250px;" validate="{required:'#admin_pass:filled',equalTo:'#admin_pass',messages:{required:'Please retype password again.'}}" /></td>
			</tr>
			<tr>
			  <td width="130" >First Name  :</td>
			  <td><input name="admin_fname" type="text" class="textbox1" id="admin_fname" value="<?php echo $row_user['admin_fname']; ?>" style="width:250px;" validate="{required:true,messages:{required:'Please enter user first name.'}}" /></td>
			</tr>
			<tr>
			  <td width="130" >Last Name  :</td>
			  <td ><input name="admin_lname" type="text" class="textbox1" id="admin_lname" value="<?php echo $row_user['admin_lname']; ?>" style="width:250px;" validate="{required:true,messages:{required:'Please enter user last name.'}}" /></td>
			</tr>
			<tr>
			  <td width="130" >Email  :</td>
			  <td><input name="admin_email" type="text" class="textbox1" id="admin_email" value="<?php echo $row_user['admin_email']; ?>" style="width:250px;" validate="{required:true,email:true,messages:{required:'Please enter user email address.',email:'Please enter email address correctly.'}}" /></td>
			</tr>
			
			<tr><td colspan="2"><br /></td></tr>
			<tr>
			  <td width="130">User Permission  :</td>
			  <td><table class="table table-striped">
										<?php for($i=1;$i<count($userpermArr);$i=$i+4){ ?>
										<tr>
										  <?php for($j=$i;$j<$i+4;$j++){?>
										  <td><?php if($userpermArr[$j]){?>
											<input name="user_perm[]" type="checkbox" id="user_perm_<?php echo $j; ?>" value="<?php echo $j; ?>" <?php if (in_array($j, explode(NAME_VAL_SEP,$row_user['admin_perm']))) { echo 'checked';}?> class="user_perm" />
										  <?php echo $userpermArr[$j]; ?><? }else{?>&nbsp;<? }?>
										  </td>
										  <?php }?>
										</tr>
										<?php }?>
									  </table></td>
			</tr>
			
			<tr><td colspan="2"><br /></td></tr>
			
			<tr>
			  <td width="130" >Status: </td>
			  <td><input type="radio" name="admin_status" value="A" <?php if($row_user['admin_status']=='A' || empty($row_user['admin_status']))echo 'checked';?>>
		  Active &nbsp;
		  <input type="radio" name="admin_status" value="I" <?php if($row_user['admin_status']=='I')echo 'checked';?>>Inactive</td>
			</tr>
			
		  </table>		     
		  <div class="button button1"><input type="submit"  class="btn btn-lg btn-success" name="Submit" value="Save" />		   
		  <a href="all_inhouse_user.php"><button type="button" class="btn btn-lg btn-primary">Back</button></a>
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

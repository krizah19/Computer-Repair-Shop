<?php 
include("include/manage_config.php");       //For connection to database 

if(isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="dashboard.php"</script>';
}


//  checking login information

if($_POST['Submit'])
{
	$admin_login = mysql_real_escape_string($_POST['admin_login']);
	$admin_pass = mysql_real_escape_string($_POST['admin_pass']);
	
	$sql = "SELECT * FROM `booking_admin` WHERE admin_login='".$admin_login."' AND admin_pass='".$admin_pass."' AND admin_status='A' ";
	$query = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_array($query);
	$rows = mysql_num_rows($query);	
	
	if($rows==0)
	{
		$addMsg = "error";
	}
	else
	{
		$_SESSION['admin_fname']=$fetch['admin_fname'];
        $_SESSION['admin_lname']=$fetch['admin_lname'];
		$_SESSION['admin_full_name']=$fetch['admin_fname']." ".$fetch['admin_lname'];
		$_SESSION['admin_login']=$fetch['admin_login'];
		$_SESSION['admin_id']=$fetch['admin_id'];
		
		echo '<script>window.location.href="dashboard.php"</script>';		
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
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <title>CMS :: Signin</title>   	
	<?php include("script.php"); ?>
	
  </head>

  <body>
  
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Customer Management System</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a><?php echo date("l, F d, Y | h:i A"); ?></a></li>            
          </ul>
        </div>
      </div>
    </div>
	
	
    <div class="container">
	
	  <?php if(!empty($addMsg)){?>
      <div class="alert alert-danger">
        <strong>Oh snap!</strong> Change a few things up and try submitting again.
      </div>
	  <?php } ?>
	  
      <form class="form-signin" role="form" name="form1" id="form1" method="post" action="">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Username" name="admin_login" id="admin_login" validate="{required:true,messages:{required:'Please enter Username.'}}">
        <input type="password" class="form-control" placeholder="Password" name="admin_pass" id="admin_pass" validate="{required:true,messages:{required:'Please enter Password.'}}">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
		<input type="submit" name="Submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
	<div id="footer">
      <div class="container">
        <p class="text-muted">Powered by <a target="_blank" href="http://www.globalitsolutionsgroup.com">Global IT Solutions Group</a></p>
      </div>
    </div>
	
  </body>
</html>

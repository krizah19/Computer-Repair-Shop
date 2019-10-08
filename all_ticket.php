<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

$cusId = $_REQUEST['cusId'];

// Filter condition

$condition='';

if(isset($_REQUEST['cusId']) && !empty($_REQUEST['cusId']))
{
	$condition.= " AND ticket_customer_id='".$_REQUEST['cusId']."'";
}
if(isset($_REQUEST['filter_ticketId']) && !empty($_REQUEST['filter_ticketId']))
{
	$condition.= " AND ticketId LIKE '%".$_REQUEST['filter_ticketId']."%'";
}

if(isset($_POST['filter_ticket_status']) && count($_POST['filter_ticket_status'])>0) 
{
	$ids=implode(',',$_POST['filter_ticket_status']);
	$getDelId="";
	for($k=0;$k<count($_POST['filter_ticket_status']);$k++)
	{
		$getDelId.=",".$_POST['filter_ticket_status'][$k];
	}
	$allId=trim($getDelId,",");
	
	$condition.= " AND ticket_status IN (".$allId.") ";
}


// Listing Query

$sql = "SELECT * FROM `booking_ticket` WHERE ticket_condition!='D' ".$condition." ORDER BY ticket_auto_id DESC ";
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
		$sqlUpdate = "UPDATE `booking_ticket` SET ticket_condition='D' WHERE ticket_auto_id IN (".$allId.") ";
		$queryUpdate = mysql_query($sqlUpdate) or die(mysql_error());
				
		echo '<script>window.location.href="all_ticket.php?msg=success"</script>';
		}
	}	
}


$sql_status = "SELECT * FROM `booking_ticket_status` WHERE status='A' ORDER BY name ";
$query_status = mysql_query($sql_status) or die(mysql_error());
	
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


<script language="javascript" src="js/prefixfree.min.js"></script>
   
<style type="text/css">
dl
{
	margin-bottom:0px !important;
}
#tpspc .dropdown dd, .dropdown dt {
    margin:0px;
    padding:0px;
}
#tpspc .dropdown ul {
    margin: -1px 0 0 0;
}
#tpspc .dropdown dd {
    position:relative;
}
#tpspc .dropdown a, 
#tpspc .dropdown a:visited {
    color:#fff;
    text-decoration:none;
    outline:none;
    font-size: 12px;
}
#tpspc .dropdown dt a {
	color:#fff;
    background-color:#4F6877;
    display:block;
    padding: 8px 20px 5px 10px;
    min-height: 25px;
    line-height: 24px;
    overflow: hidden;
    border:0;
    width:140px;
}
#tpspc .dropdown dt a span, .multiSel span {
    cursor:pointer;
    display:inline-block;
    padding: 0 3px 2px 0;
}
#tpspc .dropdown dd ul {
    background-color: #4F6877;
    border:0;
    color:#fff;
    display:none;
    left:0px;
    padding: 2px 15px 2px 5px;
    position:absolute;
    top:2px;
    width:250px;
    list-style:none;
    height: auto;
    overflow: auto;
}
#tpspc .dropdown span.value {
    display:none;
}
#tpspc .dropdown dd ul li a {
    padding:5px;
    display:block;
}
#tpspc .dropdown dd ul li a:hover {
    background-color:#fff;
}
</style>  

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
	  	  
          <h2 class="sub-header">All Ticket <!--<div style="float:right;"><a href="manage_customer.php"><button type="button" class="btn btn-lg btn-success">+ Add</button></a></div>--></h2>		  
		  		   
          <div class="table-responsive">
		  <form name="form1" id="form1" action="" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
				  <th>Customer Name</th>
                  <th>Postcode</th>
                  <th>Assign Engineer</th>				
				  <th>Status</th>
                  <th>Edit</th>
                  <th>Delete</th>				  
                </tr>
				
				 <tr>
					<td width="14%"><input type="text" name="filter_ticketId" id="filter_customerId" value="" class="form-control" placeholder="Search..." />
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td id="tpspc">
					 <dl class="dropdown">   
						<dt>
						<a href="javascript:void(0)">
						  <span class="hida">Select</span>    
						  <!--<p class="multiSel"></p>-->
						</a>
						</dt>
					  
						<dd>
							<div class="mutliSelect">
								<ul>
									<?php while($ticketStatus = mysql_fetch_array($query_status)){?>
									<li><input type="checkbox" name="filter_ticket_status[]" value="<?php echo $ticketStatus['status_id']; ?>" /><?php echo $ticketStatus['name']; ?></li>
									<?php } ?> 									
								</ul>
							</div>
						</dd>					  
					</dl>
		
					<?php /*?><select name="filter_ticket_status" id="filter_ticket_status" class="textbox1" style="width:80px; height:32px;">
						<option value="">Select</option>
						<?php while($ticketStatus = mysql_fetch_array($query_status)){?>
						<OPTION  value="<?php echo $ticketStatus['status_id']; ?>" <?php if($row['ticket_status']==$ticketStatus['status_id']) echo 'selected';?>><?php echo $ticketStatus['name']; ?></OPTION>
						<?php } ?> 
					</select><?php */?>
					</td>																
					<td width="10%" align="left" valign="top" colspan="2" style="padding:4px;"><input type="submit" name="Filter" value="Search" class="btn btn-lg btn-warning" ></td>								
				  </tr>		
							  
              </thead>
              <tbody>
			  <?php 
			  if($rows>0){
			  while($fetch = mysql_fetch_array($query))
			  {		
			  
			  $sqlCus = "SELECT * FROM `booking_customer` WHERE customer_auto_id='".$fetch['ticket_customer_id']."' ";
			  $queryCus = mysql_query($sqlCus) or die(mysql_error());
	  		  $fetchCus = mysql_fetch_array($queryCus);
			  
			  $sqlTS = "SELECT * FROM `booking_ticket_status` WHERE status_id='".$fetch['ticket_status']."' ";
			  $queryTS = mysql_query($sqlTS) or die(mysql_error());
	  		  $fetchTS = mysql_fetch_array($queryTS);
			  
			  $sqlAE = "SELECT * FROM `booking_admin` WHERE admin_id='".$fetch['ticket_enginner']."' ";
			  $queryAE = mysql_query($sqlAE) or die(mysql_error());
	  		  $fetchAE = mysql_fetch_array($queryAE);
			  			  
			  ?>
                <tr>
                  <td><a href="manage_invoice.php?ticket_auto_id=<?php echo $fetch['ticket_auto_id']; ?>"><?php echo $fetch['ticketId'];?></a></td>                  
				  <td><?php echo $fetchCus['customer_title']." ".$fetchCus['customer_name'];?></td>
				  <td><?php echo $fetchCus['customer_pincode'];?></td>					  
				  <td><?php echo $fetchAE['admin_fname']." ".$fetchAE['admin_lname']; ?></td>	
				  <td style=" <?php if($fetchTS['status_id']==7){?>font-weight:bold; color:#009900;<?php } if($fetchTS['status_id']==11){?> font-weight:bold; color:#FF0000;<?php } ?> "><?php echo $fetchTS['name'];?></td>				 				  			  
                  <td>
				  <a href="manage_ticket.php?ticket_auto_id=<?php echo $fetch['ticket_auto_id'];?>" class="blue_link">Edit</a>
								<br />
								<a href="update_status.php?ticket_auto_id=<?php echo $fetch['ticket_auto_id']; ?>" rel="shadowbox;width=500;height=400;">Update Status</a>
				  </td>
                  <td><input type="checkbox" name="chkDel[]" value="<?php echo $fetch['ticket_auto_id'];?>"></td>				  
                </tr>
              <?php }} ?>  
              </tbody>
			  
			  <?php if($rows>0) { ?>
			  <tfoot>
				<tr>
					<td colspan="9"><input type="submit" name="Delete" value="Delete" class="btn btn-lg btn-danger" onClick="javascript:return confirm('Are you sure want to delete?');"></td>
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

<script type="text/javascript">
$(".dropdown dt a").on('click', function () {
          $(".dropdown dd ul").slideToggle('fast');
      });

      $(".dropdown dd ul li a").on('click', function () {
          $(".dropdown dd ul").hide();
      });

      function getSelectedValue(id) {
           return $("#" + id).find("dt a span.value").html();
      }

      $(document).bind('click', function (e) {
          var $clicked = $(e.target);
          if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
      });


      $('.mutliSelect input[type="checkbox"]').on('click', function () {
        
          var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
              title = $(this).val() + ",";
        
          if ($(this).is(':checked')) {
              var html = '<span title="' + title + '">' + title + '</span>';
              $('.multiSel').append(html);
              /*$(".hida").hide();*/
          } 
          else {
              $('span[title="' + title + '"]').remove();
              var ret = $(".hida");
              $('.dropdown dt a').append(ret);
              
          }
      });
</script>
   
  </body>
</html>

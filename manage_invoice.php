<?php 
include("include/manage_config.php");       //For connection to database 

if(!isset($_SESSION['admin_login'])) {
	echo '<script>window.location.href="admin_login.php"</script>';
}

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

$urlGo = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
//print $urlGo;

$ticket_auto_id=$_REQUEST['ticket_auto_id'];
$caption="Invoice";


$sql_001 = "SELECT * FROM `booking_ticket` WHERE ticket_auto_id='".$ticket_auto_id."' ";
$query_001 = mysql_query($sql_001) or die(mysql_error());
$row = mysql_fetch_array($query_001);

$sql_002 = "SELECT * FROM `booking_customer` WHERE `customer_auto_id`='".$row['ticket_customer_id']."' ";
$query_002 = mysql_query($sql_002) or die(mysql_error());
$rowCustos = mysql_fetch_array($query_002);

$sql_003 = "SELECT * FROM `booking_product` WHERE product_status='A' ORDER BY product_name ";
$rowProduct = mysql_query($sql_003) or die(mysql_error());

$sql_004 = "SELECT * FROM `booking_ticket_product` WHERE tp_status='A' AND `tp_ticket_id`='".$ticket_auto_id."' ORDER BY tp_auto_id ";
$rowTicketPro = mysql_query($sql_004) or die(mysql_error());
$numrowsPro = mysql_num_rows($rowTicketPro);


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// add ticket item

if(isset($_POST['addproitem']) && $_POST['addproitem']=='Add Product')
{	
	$sql_101 = "SELECT * FROM `booking_product` WHERE product_auto_id='".$_POST['tp_product_id']."' ";
	$query_101 = mysql_query($sql_101) or die(mysql_error());
	$rowPro = mysql_fetch_array($query_101);
		
	$_POST['tp_productID']= $rowPro["productId"];	
	$_POST['tp_product_name']= $rowPro["product_name"];	
	$_POST['tp_product_desc']= $rowPro["product_desc"];	
	$_POST['tp_product_price']= $rowPro["product_price"];	
	$_POST['tp_product_qty']= 1;	
	$_POST['tp_status']= 'A';	
			
	$sql_102 = "INSERT INTO `booking_ticket_product` SET 
		tp_ticket_id='".$ticket_auto_id."' ,
		tp_product_id='".$_POST['tp_product_id']."' ,
		tp_productID='".$_POST['tp_productID']."' ,
		tp_product_name='".$_POST['tp_product_name']."' ,
		tp_product_desc='".$_POST['tp_product_desc']."' ,		
		tp_product_price='".$_POST['tp_product_price']."' ,
		tp_product_qty='".$_POST['tp_product_qty']."' ,		
		tp_status='".$_POST['tp_status']."' ,			
		tp_crdate=NOW()		
		";
	$query_102 = mysql_query($sql_102) or die(mysql_error());	
	
	
	$ticketTotal = $row['ticket_total'];
	
	$ticketTotal = $ticketTotal+ $rowPro["product_price"];	
	$ticketVat = ($ticketTotal*VAT)/100;
	$ticketGTotal = $ticketTotal+$ticketVat;
	

	$_POST['ticket_total']=$ticketTotal;
	$_POST['ticket_vat']=$ticketVat;
	$_POST['ticket_grand_total']=$ticketGTotal;		
	
		
	$sql_103 = "UPDATE `booking_ticket` SET 
		ticket_total='".$_POST['ticket_total']."' ,
		ticket_vat='".$_POST['ticket_vat']."' ,
		ticket_grand_total='".$_POST['ticket_grand_total']."' 
		WHERE ticket_auto_id='".$ticket_auto_id."' ";
	$query_103 = mysql_query($sql_103) or die(mysql_error());	
		
	echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$ticket_auto_id.'&msg=success"</script>';			
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/


// add product

if(isset($_REQUEST['Add']) && $_REQUEST['Add']=='on')
{
	if(isset($_REQUEST['tpid']))
	{	
		
		$sql_101 = "SELECT * FROM `booking_ticket_product` WHERE tp_auto_id='".$_REQUEST['tpid']."' ";
		$query_101 = mysql_query($sql_101) or die(mysql_error());
		$rowB = mysql_fetch_array($query_101);
		
		$qty = $rowB['tp_product_qty']+1;
		
		$sql_102 = "UPDATE `booking_ticket_product` SET 			
		tp_product_qty='".$qty."'
		WHERE tp_auto_id='".$_REQUEST['tpid']."' ";
		
		$query_102 = mysql_query($sql_102) or die(mysql_error());
		
		
		$sql_103 = "SELECT * FROM `booking_ticket` WHERE ticket_auto_id='".$ticket_auto_id."' ";
		$query_103 = mysql_query($sql_103) or die(mysql_error());
		$rowTk = mysql_fetch_array($query_103);
		
		$_POST['ticket_total'] = $rowTk['ticket_total']+$rowB['tp_product_price'];
		$_POST['ticket_vat'] = ($_POST['ticket_total']*VAT)/100; 
		$_POST['ticket_discount'] = $rowTk['ticket_discount']; 
		
		$_POST['ticket_grand_total'] = ($_POST['ticket_total']+$_POST['ticket_vat'])-$_POST['ticket_discount'];
		
		
		$sql_104 = "UPDATE `booking_ticket` SET 			
		ticket_total='".$_POST['ticket_total']."' ,
		ticket_vat='".$_POST['ticket_vat']."' ,
		ticket_discount='".$_POST['ticket_discount']."' ,
		ticket_grand_total='".$_POST['ticket_grand_total']."' 		
		WHERE ticket_auto_id='".$ticket_auto_id."' ";
		
		$query_104 = mysql_query($sql_104) or die(mysql_error());					
		
		echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$_REQUEST['ticket_auto_id'].'&msg=success"</script>';
				
	}	
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/


// delete product

if(isset($_REQUEST['Del']) && $_REQUEST['Del']=='on')
{
	if(isset($_REQUEST['tpid']))
	{	
		$sql_101 = "SELECT * FROM `booking_ticket` WHERE ticket_auto_id='".$ticket_auto_id."' ";
		$query_101 = mysql_query($sql_101) or die(mysql_error());
		$rowTk = mysql_fetch_array($query_101);
				
		$sql_102 = "SELECT * FROM `booking_ticket_product` WHERE tp_auto_id='".$_REQUEST['tpid']."' ";
		$query_102 = mysql_query($sql_102) or die(mysql_error());
		$rowTkPro = mysql_fetch_array($query_102);
				
		$_POST['ticket_total'] = $rowTk['ticket_total']-($rowTkPro['tp_product_price']*$rowTkPro['tp_product_qty']);
		$_POST['ticket_vat'] = ($_POST['ticket_total']*VAT)/100; 
		$_POST['ticket_discount'] = $rowTk['ticket_discount']; 
		
		$_POST['ticket_grand_total'] = ($_POST['ticket_total']+$_POST['ticket_vat'])-$_POST['ticket_discount'];
	
	
		$sql_103 = "UPDATE `booking_ticket` SET 			
		ticket_total='".$_POST['ticket_total']."' ,
		ticket_vat='".$_POST['ticket_vat']."' ,
		ticket_discount='".$_POST['ticket_discount']."' ,
		ticket_grand_total='".$_POST['ticket_grand_total']."' 		
		WHERE ticket_auto_id='".$ticket_auto_id."' ";
		$query_103 = mysql_query($sql_103) or die(mysql_error());
		
		
		$sql_103 = "UPDATE `booking_ticket_product` SET 			
		tp_status='D' 
		WHERE tp_auto_id='".$_REQUEST['tpid']."' ";
		$query_103 = mysql_query($sql_103) or die(mysql_error());
		
		echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$_REQUEST['ticket_auto_id'].'&msg=success"</script>';
	}	
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/


// discount

if(isset($_REQUEST['discount']) && $_REQUEST['discount']=='Discount')
{	
	$_POST['ticket_grand_total'] = ($_POST['ticket_total']+$_POST['ticket_vat'])-$_POST['ticket_discount'];
	
	$sql_101 = "UPDATE `booking_ticket` SET 	
		ticket_discount='".$_POST['ticket_discount']."' ,				
		ticket_grand_total='".$_POST['ticket_grand_total']."' 		
		WHERE ticket_auto_id='".$ticket_auto_id."' ";
	$query_101 = mysql_query($sql_101) or die(mysql_error());
		
	echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$ticket_auto_id.'&msg=success"</script>';
		
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if(isset($_POST['TickProSave']) && $_POST['TickProSave']=='SAVE')
{
	/*echo "<pre>";
	print_r($_POST);
	exit;*/
	
	$bmax = $_POST['loopCounter'];
	
	if($bmax>0)
	{	
		for($rt=0;$rt<$bmax;$rt++)
		{
			
			$_POST['tp_product_name'] = $_POST['tp_pro_name'][$rt];
			$_POST['tp_product_desc'] = $_POST['tp_pro_desc'][$rt];
			$_POST['tp_product_price'] = $_POST['tp_pro_price'][$rt];
			$_POST['tp_product_qty'] = $_POST['tp_pro_qty'][$rt];
			
			
			$sql_1011 = "UPDATE `booking_ticket_product` SET 	
				tp_product_name='".$_POST['tp_product_name']."' ,
				tp_product_desc='".$_POST['tp_product_desc']."' ,
				tp_product_price='".$_POST['tp_product_price']."' ,
				tp_product_qty='".$_POST['tp_product_qty']."' 		
				WHERE tp_auto_id='".$_POST['tp_auto'][$rt]."' ";
				
			$query_1011 = mysql_query($sql_1011) or die(mysql_error());	
			
		}
			
			$sql_101 = "UPDATE `booking_ticket` SET 	
				ticket_total='".$_POST['ticket_total']."' ,
				ticket_vat='".$_POST['ticket_vat']."' ,
				ticket_discount='".$_POST['ticket_discount']."' ,
				ticket_grand_total='".$_POST['ticket_grand_total']."' 		
				WHERE ticket_auto_id='".$ticket_auto_id."' ";
			$query_101 = mysql_query($sql_101) or die(mysql_error());	
		
		
					
		echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$ticket_auto_id.'&msg=success"</script>';		
	
	}
	
	
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// create invoice


if(isset($_POST['geninvoice']) && $_POST['geninvoice']=='Generate Invoice')
{						
			$company =  "Dr. Computer Fix";
			$address1 = "43 Fulham High Street";
			$address2 = "Fulham, London";
			$address3 = "SW6 3JJ";			
			$email1 = "info@dr-computerfix.co.uk";			
			$telephone = "020 7371 0581";
			
				
			$sql= "SELECT * FROM `booking_ticket_product` WHERE tp_status='A' AND `tp_ticket_id`='".$ticket_auto_id."' ORDER BY tp_auto_id ";
			$query=mysql_query($sql) or die(mysql_error());
			$norows=mysql_num_rows($query);	
	
	
	
			    require('u/fpdf.php');

				class PDF extends FPDF
				{
				function Header()
				{
				
							
				$logo="images/logo.png";
				$this->Image($logo,10,10,60);
				
				$this->SetFont('Arial','B',12);
				$this->Ln(1);
				}
				/*function Footer()
				{
				$this->SetY(-15);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
				}*/
				function ChapterTitle($num, $label)
				{
				$this->SetFont('Arial','',12);
				$this->SetFillColor(200,220,255);
				$this->Cell(0,6,"$num $label",0,1,'L',true);
				$this->Ln(0);
				}
				function ChapterTitle2($num, $label)
				{
				$this->SetFont('Arial','',12);
				$this->SetFillColor(249,249,249);
				$this->Cell(0,6,"$num $label",0,1,'L',true);
				$this->Ln(0);
				}
				function ChapterTitle3($num, $label)
				{
				$this->SetFont('Arial','',12);
				$this->SetFillColor(224,224,224);
				$this->Cell(0,6,"$num $label",0,1,'C',true);
				$this->Ln(0);
				}
				}
							
				$pdf = new PDF();
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->SetFont('Times','',12);
				$pdf->SetTextColor(32);
				$pdf->Cell(0,5,$company,0,1,'R');
				$pdf->Cell(0,5,$address1,0,1,'R');
				$pdf->Cell(0,5,$address2,0,1,'R');
				$pdf->Cell(0,5,$address3,0,1,'R');
				$pdf->Cell(0,5,$email1,0,1,'R');
				/*$pdf->Cell(0,5,$email2,0,1,'R');*/
				$pdf->Cell(0,5,'Tel: '.$telephone,0,1,'R');

				$pdf->Cell(0,20,'',0,1,'R');
				
				
				$pdf->SetFillColor(200,220,255);
				$pdf->ChapterTitle3('Invoice',"");
				$pdf->ChapterTitle3('Ticket ID: ',$row['ticketId']);
				

				$pdf->SetFillColor(224,235,255);
				$pdf->SetDrawColor(192,192,192);
				$pdf->Cell(95,7,'Customer Name: '.$rowCustos['customer_title'].' '.$rowCustos['customer_name'],1,0,'L');
				$pdf->Cell(95,7,'Customer ID: '.$rowCustos['customerId'],1,1,'R');
				$pdf->Cell(95,7,'Address: '.$rowCustos['customer_address'],1,0,'L',0);
				$pdf->Cell(95,7,'Date: '.date('d-m-Y'),1,1,'R',0);
				
				
				$pdf->Cell(0,20,'',0,1,'R');
				
				
				$pdf->SetFillColor(200,220,255);
				$pdf->SetDrawColor(192,192,192);
				//$pdf->Cell(15,7,'Sl No.',1,0,'L');
				$pdf->Cell(50,7,'Product Name',1,0,'L');
				$pdf->Cell(85,7,'Description',1,0,'L');
				$pdf->Cell(15,7,'Price',1,0,'C');
				$pdf->Cell(15,7,'Qty',1,0,'C');
				$pdf->Cell(25,7,'Total',1,1,'R');
								
				$flug=1;
				
				while($fetch=mysql_fetch_array($query)){
				
				
				$sql_601 = "SELECT * FROM `booking_product` WHERE `product_auto_id`='".$fetch['tp_product_id']."' ";
				$query_601=mysql_query($sql_601) or die(mysql_error());
				$romProduct=mysql_fetch_array($query_601);	
																			
				//$pdf->Cell(15,7,$flug,1,0,'L');
				
				$pdf->Cell(50,7,$fetch['tp_product_name'],1,0,'L');
				
				$pdf->Cell(85,7,substr($fetch['tp_product_desc'],0,43),1,0,'L',0);
				
				$pdf->Cell(15,7,$fetch['tp_product_price'],1,0,'C');
				
				$pdf->Cell(15,7,$fetch['tp_product_qty'],1,0,'C');
	
				$pdf->Cell(25,7,number_format($fetch['tp_product_price']*$fetch['tp_product_qty'],2),1,1,'R');
				
				$flug++;
				
				}
				
				$pdf->Cell(165,7,'Total',1,0,'R');
				$pdf->Cell(25,7,number_format($row['ticket_total'],2),1,1,'R');
			    
				$pdf->Cell(165,7,'VAT ('.VAT.'%)',1,0,'R');
				$pdf->Cell(25,7,number_format($row['ticket_vat'],2),1,1,'R');
				
				$pdf->Cell(165,7,'Discount',1,0,'R');
				$pdf->Cell(25,7,number_format($row['ticket_discount'],2),1,1,'R');
				
				$pdf->Cell(165,7,'Grand Total',1,0,'R');
				$pdf->Cell(25,7,number_format($row['ticket_grand_total'],2),1,1,'R');
				
				
				$pdf->Cell(0,20,'',0,1,'R');
				
								
				$folder="moneyReceipt/";
				$filename="MR-".$row['ticketId'].".pdf";
				
				$fileSave=$folder.$filename;
				$pdf->Output($fileSave,'F');

		echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$ticket_auto_id.'&msg=success"</script>';	
		
		
}


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/


// email invoice

if(isset($_POST['emailinvoice']) && $_POST['emailinvoice']=='Email Invoice')
{			  			  
			  $filename="MR-".$row['ticketId'].".pdf";
			  $file = ABSPATH."moneyReceipt/".$filename; // Path to the file (example)			  
			  
			  if(file_exists($file)){
			  
			  $logo_url=SITE_URL."images/logo.png";				
			  	
			  $to = $rowCustos['customer_email'];
			  $subject = "Invoice: #".$row['ticketId'];
			  $cusname = $rowCustos['customer_title'].' '.$rowCustos['customer_name'];
			  
              $from_name="Dr. COmputer Fix";
              $from_mail="info@dr-computerfix.co.uk";
              $replyto="info@dr-computerfix.co.uk";
              $ccto="";
			  
			  $msg = "<html>
					<head>
					  <title>Dr. Computer Fix Ltd</title>
					</head>
					<body>
					<table width='100%' border='0' cellspacing='2' cellpadding='2'>
					<tr>
						<td colspan='6' align='left'><img src='$logo_url' alt=''></td>
					</tr>			
					<tr>
						<td colspan='6' align='left'>
						<strong style='font-size:20px; color:#272262;'>Dear $cusname,</strong>
						<br>
						<br>
						<span style='font-family:Arial; font-size:14px; color:#666666; font-weight:normal;'>You have received a job Invoice from Dr. Computer Fix</span>
						</td>
					</tr>			
					<tr>
						<td colspan='6' style='padding:10px'>
						Thanks,
						<br>
						<strong>Dr. Computer Fix Team</strong>
						</td>
					</tr>
					</table>
					</body>
				</html>";
			 
            $file_size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
            $uid = md5(uniqid(time()));
            $name = basename($file);
            
            $header = "From: ".$from_name." <".$from_mail.">\r\n";
            $header .= "Reply-To: ".$replyto."\r\n";
			//$header .= "Cc: ".$ccto."\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
            
            $message = "--".$uid."\r\n";            
            $message .= "Content-type:text/html; charset=iso-8859-1\r\n";
            $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";            
            $message .= $msg."\r\n\r\n";   //$msg contains the plain text body of the email
            
            $message .= "--".$uid."\r\n";
            $message .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n"; // use different content types here
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
            $message .= $content."\r\n\r\n";
            $message .= "--".$uid."--\r\n";
            
            if (mail($to, $subject,$message, $header))
            {
                echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$ticket_auto_id.'&msg=success"</script>';				
            }
			}
			else
			{
				echo '<script>window.location.href="manage_invoice.php?ticket_auto_id='.$ticket_auto_id.'&msg=error"</script>';	
			}	
}



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/



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
			<?php echo SUCCESS; ?>
		  </div>
		  <?php } ?>
		  <?php if(!empty($_GET['msg']) && $_GET['msg']=="error"){?>
		  <div class="alert alert-danger">
			<?php echo ERROR; ?>
		  </div>
		  <?php } ?>
						
		  
	<div class="table-responsive">
	
      <h2>Ticket ID: <?php echo $row['ticketId'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Customer ID: <?php echo $rowCustos['customerId'];?></h2>
        
		
		<table class="table table-striped">
		
		<tr>
		  <td colspan="4">
		  <form name="form1" id="form1" method="post" action="">
		  
		  <div style="float:left; margin-top:10px;">Select Product:
		  <select name="tp_product_id" id="tp_product_id" class="textbox1" style="width:258px; height:32px;" validate="{required:true,messages:{required:''}}">
		    <option value="">Select</option>
		  <?php while($products = mysql_fetch_array($rowProduct)){?>
			<OPTION  value="<?php echo $products['product_auto_id']; ?>" >
			<?php echo $products['product_name']; ?>
			</OPTION>
		  <?php } ?> 
		  </select></div>
		  <div style="float:right;">
		  <input type="submit" name="addproitem" value="Add Product" class="btn btn-lg btn-success"/></div>
		  
		  </form>
		  </td>
		</tr>
		
		</table>
		
		<br /><br />
		
		<?php if($numrowsPro>0){?>
		
		<table class="table table-striped">
		
		<tr>
			<th>Item ID</th>
			<th>Product Name</th>
			<th>Description</th>
			<th style="text-align:center;">Quantity</th>
			<th style="text-align:center;">Price</th>
			<th style="text-align:center;">Total Price</th>
			<th style="text-align:center;">Add</th>
			<th style="text-align:center;">Delete</th>
		</tr>
		
		<form name="formEditProtk" id="formEditProtk" method="post" action="">					
		
		<?php 
		//$totalamt = 0.00;
		
		$totalamt = 0.00;
		$amt = 0;
		while($allTP = mysql_fetch_array($rowTicketPro)){
		
		$sql_501 = "SELECT * FROM `booking_product` WHERE product_auto_id='".$allTP['tp_product_id']."' ";
		$query_501 = mysql_query($sql_501) or die(mysql_error());
		$romProduct = mysql_fetch_array($query_501);
		
		$amt++;
		?>
		<tr>
			<td>
			<input type="hidden" name="tp_auto[]" value="<?php echo $allTP['tp_auto_id']; ?>" />
			<input type="hidden" name="tp_tk_id[]" value="<?php echo $allTP['tp_ticket_id']; ?>" />
			<input type="hidden" name="tp_pro_id[]" value="<?php echo $allTP['tp_product_id']; ?>" />
			<input type="hidden" name="tp_proID[]" value="<?php echo $allTP['tp_productID']; ?>" />
			<input type="hidden" name="TickProSave" value="SAVE" />
			<input type="hidden" name="loopCounter" value="<?php echo $amt; ?>" />
			
			<?php echo $allTP['tp_productID']; ?></td>
			<td><input type="text" name="tp_pro_name[]" value="<?php echo $allTP['tp_product_name']; ?>" style="width:100px;" /></td>
			<td><input type="text" name="tp_pro_desc[]" value="<?php echo $allTP['tp_product_desc']; ?>" style="width:150px;" /></td>
			<td style="text-align:center;"><input type="text" name="tp_pro_qty[]" value="<?php echo $allTP['tp_product_qty']; ?>" style="width:50px;" /></td>
			<td style="text-align:center;"><input type="text" name="tp_pro_price[]" value="<?php echo $allTP['tp_product_price']; ?>" style="width:50px;" /></td>
			<td style="text-align:center;"><input type="text" name="tp_pro_price_total[]" value="<?php echo number_format($allTP['tp_product_price']*$allTP['tp_product_qty'],2); ?>" style="width:50px;" readonly="readonly" /></td>
			<td style="text-align:center;"><a href="<?php echo $urlGo; ?>&tpid=<?php echo $allTP['tp_auto_id']; ?>&Add=on" onClick="javascript:return confirm('Are you sure want to Add?');">Add+</a></td>
			<td style="text-align:center;"><a href="<?php echo $urlGo; ?>&tpid=<?php echo $allTP['tp_auto_id']; ?>&Del=on" onClick="javascript:return confirm('Are you sure want to delete?');">Delete</a></td>
		</tr>
		<?php 
		$totalamt = $totalamt+($allTP['tp_product_price']*$allTP['tp_product_qty']);				
		} ?>
		
		<?php 
			$vat = ($totalamt*VAT)/100; 
			//echo number_format($vat,2);
			$grandTotal = ($totalamt+$vat)-$row['ticket_discount'];
		 ?>
		<input type="hidden" name="ticket_total" value="<?php echo $totalamt; ?>" />
		<input type="hidden" name="ticket_vat" value="<?php echo $vat; ?>" />
		<input type="hidden" name="ticket_discount" value="<?php echo $row['ticket_discount']; ?>" />
		<input type="hidden" name="ticket_grand_total" value="<?php echo $grandTotal; ?>" />
		
		</form>
		
		<tr>					
			<th style="text-align:right;" colspan="4">Total</th>
			<th style="text-align:right;">&pound;&nbsp;<?php echo number_format($totalamt,2); ?></th>
			<th colspan="3">&nbsp;</th>										
		</tr>
		
		<tr>					
			<th style="text-align:right;" colspan="4">VAT (<?php echo VAT; ?>%)</th>
			<th style="text-align:right;">			
			&pound;&nbsp;<?php echo number_format($vat,2); ?>					
			</th>
			<th colspan="3">&nbsp;</th>										
		</tr>
		
		<tr>
		<form name="fdiscouunt" id="fdiscouunt" method="post" action="">					
			<th style="text-align:right;" colspan="4">
			<input type="hidden" name="ticket_auto_id" value="<?php echo $ticket_auto_id; ?>"  />
			<input type="hidden" name="ticket_total" value="<?php echo $totalamt; ?>"  />
			<input type="hidden" name="ticket_vat" value="<?php echo $vat; ?>"  />
				
			Discount</th>
			<th style="text-align:right;"><input type="text" name="ticket_discount" value="<?php echo number_format($row['ticket_discount'],2); ?>" class="textbox1" style="width:50px; height:24px;" /></th>
			<th colspan="3">&nbsp;&nbsp;<input type="submit" name="discount" value="Discount"  class="btn btn-lg btn-danger" /></th>
		</form>											
		</tr>
		
		<tr>					
			<th style="text-align:right;" colspan="4">Grand Total</th>
			<th style="text-align:right;">&pound;
			<?php 			
			echo number_format($grandTotal,2); 
			?>
			</th>
			<th colspan="3">&nbsp;</th>										
		</tr>
		
		<tr>					
			<th colspan="4"><input type="button" name="TickProSave45" value="Save"  class="btn btn-lg btn-success" onClick="document.formEditProtk.submit()" />
			<a href="all_ticket.php"><button type="button" class="btn btn-lg btn-primary">Back</button></a>
			</th>
			<th style="text-align:center;"></th>
			<th colspan="3">&nbsp;</th>										
		</tr>
				
		</table>
		
		<br /><br />
		
			  			
		<table width="100%" cellpadding="5" cellspacing="5" class="tablesorter" id="tablesorter" style="font-size:14px;">
		
		<tr>
		  <td colspan="4">
		  <form name="invFrm" id="invFrm" method="post" action="">
		  
		  <input type="submit" name="geninvoice" value="Generate Invoice"  class="btn btn-lg btn-warning"/>
		  
		  <input type="submit" name="emailinvoice" value="Email Invoice"  class="btn btn-lg btn-info"/>
		  
		  <a href="moneyReceipt/MR-<?php echo $row['ticketId']; ?>.pdf" target="_blank"><input type="button" name="printinvoice" value="Print Invoice"  class="btn btn-lg btn-primary"/></a>
		  
		  </form>
		  </td>
		</tr>
		
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

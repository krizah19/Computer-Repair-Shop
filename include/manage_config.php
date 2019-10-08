<?php
	session_start();
	error_reporting(0);	

	$db_name = "prototype";
	$db_host = "localhost";
	$db_user = "root";
	$db_password = "mysql";
		

	/*$db_name = "globalit_cms";
	$db_host = "localhost";
	$db_user = "globalit_cms";
	$db_password = "NWxMvs_^O?m^";*/
		

	$conn = mysql_connect($db_host, $db_user, $db_password) or die("Cannot connect to the Host");
	mysql_select_db($db_name, $conn) or die("Cannot connect to the Database");
		

	define(FAV_ICON,"<link href='ico/favicon.ico' rel='shortcut icon' type='image/x-icon' />");
		
	define(SITE_NAME, "CMS");
	define(SITE_URL, "http://localhost/cms");
	//define(SITE_URL, "http://test.globalitsolutionsgroup.com/cms");
	
	define('ABSPATH', dirname(__FILE__) . '/');
	
	date_default_timezone_set('Asia/Calcutta');
	
	define(UPDATE, "Record Updated!");
	define(INSERT, "Record Inserted!");
	define(DELETE, "Record Deleted!");
	define(ERROR, "Please Try Again!");
	define(SUCCESS, "Operation Done Successfully!");
	
	define(USER_EXIST, "This User Name or Email already used. Please enter another one.");
	
	define(ADMIN_EMAIL, "pinaki.cs@gmail.com");	
	define(NAME_VAL_SEP, "*#*");
	
	
	define(VAT,20);
	
	
	$userpermArr=array(
	1=>'Password Management',
	2=>'Customer Management',
	3=>'Ticket Management',
	4=>'Masters Management'	
	);
	$pagepermArr=array(
	1=>'change_password.php',
	2=>'manage_customer.php,all_customer.php',
	3=>'all_ticket.php,manage_ticket.php,manage_invoice.php',
	4=>'all_engineer.php,manage_engineer.php,all_product.php,manage_product.php,all_item.php,manage_item.php'	
	);

		
?>


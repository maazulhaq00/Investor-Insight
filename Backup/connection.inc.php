<?php
	session_start();
	$con=mysqli_connect("localhost","skylecef_fund","skylecef_fund1","skylecef_fund");
	define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
	define('SITE_PATH','localhost/Investor Insight.com/');
	define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
	define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');
?>
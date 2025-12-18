<?php 
	session_start();
	if(empty($_SESSION['admin_email']))
	{
		header("Location: ../login.php");
		die();
	}
	else
	{
		$admin_email=$_SESSION['admin_email'];
		$shop_name=$_SESSION['shop_name'];
		$premium=$_SESSION['premium'];
	}
?>
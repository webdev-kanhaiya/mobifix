<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		session_start();
		require "../../php/config.php";
		$admin=$_SESSION['admin_email'];
		$name=mysqli_real_escape_string($conn,$_POST['name']);
		$mobile=mysqli_real_escape_string($conn,$_POST['mobile']);
		$address=mysqli_real_escape_string($conn,$_POST['address']);
		$cid=mysqli_real_escape_string($conn,$_POST['cid']);

		$query="UPDATE customer SET name='$name',mobile='$mobile',address='$address' WHERE admin='$admin' AND id='$cid'";
		if(mysqli_query($conn,$query))
		{
			echo "done";
		}
		else
		{
			echo "Query Failed";
		}
	}
	else
	{
		echo "Access Denied";
	}
?>
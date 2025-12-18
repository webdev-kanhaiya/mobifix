<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		$admin=$_SESSION['admin_email'];
		$cid=mysqli_real_escape_string($conn,$_POST['cid']);

		$query="DELETE FROM customer WHERE id='$cid' AND admin='$admin'";
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
		die("Invalid Request : Access Denied");
	}
?>
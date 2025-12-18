<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		$stars=mysqli_real_escape_string($conn,$_POST['stars']);
		$thoughts=mysqli_real_escape_string($conn,$_POST['thoughts']);
		$admin=$_SESSION['admin_email'];

		$query="INSERT INTO feedback(admin,stars,thoughts)VALUES('$admin','$stars','$thoughts')";
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
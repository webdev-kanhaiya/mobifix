<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "config.php";
		$email=mysqli_real_escape_string($conn,$_POST['email']);
		$otp=mysqli_real_escape_string($conn,$_POST['otp']);

		$query="SELECT * FROM userdata WHERE email='$email'";
		$result=mysqli_query($conn,$query) or die("Query Failed");

		if($result->num_rows==1)
		{
			$row=mysqli_fetch_assoc($result);
			if($row['otp']==$otp)
			{
				session_start();
				$_SESSION['admin_email']=$row['email'];
				$_SESSION['shop_name']=$row['shop_name'];
				$_SESSION['premium']=$row['premium'];
				echo "done";
			}
			else
			{
				echo "Invalid OTP";
			}
		}
		else
		{
			die("User Not Found");
		}
	}
	else
	{
		die("Access Denied");
	}
?>
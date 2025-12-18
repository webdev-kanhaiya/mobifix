<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "config.php";
		$email=mysqli_real_escape_string($conn,$_POST['login_email']);
		$password=md5($_POST['login_password']);

		$query="SELECT * FROM userdata WHERE email='$email'";
		$result=mysqli_query($conn,$query) or die("Query Failed");

		if($result->num_rows==1)
		{
			$data=mysqli_fetch_assoc($result);
			if($data['password']==$password)
			{
				session_start();
				$_SESSION['admin_email']=$data['email'];
				$_SESSION['shop_name']=$data['shop_name'];
				$_SESSION['premium']=$data['premium'];
				echo "done";
			}
			else
			{
				echo "Password is Wrong";
			}
		}
		else
		{
			echo "Email is Not Registered";
		}
	}
	else
	{
		die("Invalid Request : Access Denied");
	}
?>
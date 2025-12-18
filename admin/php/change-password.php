<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		$old_password=md5($_POST['old_password']);
		$new_password=md5($_POST['new_password']);
		$admin=$_SESSION['admin_email'];

		$query="SELECT * FROM userdata WHERE email='$admin'";
		$result=mysqli_query($conn,$query) or die("Query Failed");

		if($result->num_rows==1)
		{
			$data=mysqli_fetch_assoc($result);
			if($data['password']==$old_password)
			{
				$update_query="UPDATE userdata SET password='$new_password' WHERE email='$admin'";
				if(mysqli_query($conn,$update_query))
				{
					echo "done";
				}
				else
				{
					echo "Update Query Failed";
				}
			}
			else
			{
				echo "Old Password is Wrong";
			}
		}
		else
		{
			die("Something Went Wrong");
		}
	}
	else
	{
		die("Invalid Request : Access Denied");
	}
?>
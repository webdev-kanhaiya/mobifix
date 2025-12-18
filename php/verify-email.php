<?php
	require "config.php";
	if(empty($_GET['eid']) || empty($_GET['token']))
	{
		die("Invalid Link");
	}
	else
	{
		$email=base64_decode($_GET['eid']);
		$otp=base64_decode($_GET['token']);
	}

	$select_query="SELECT * FROM userdata WHERE email='$email'";
	$select_result=mysqli_query($conn,$select_query) or die("Query Failed");

	if($select_result->num_rows==1)
	{
		$select_data=mysqli_fetch_assoc($select_result);
		if($select_data['otp']==$otp)
		{
			$update_query="UPDATE userdata SET status='active' WHERE email='$email'";
			if(mysqli_query($conn,$update_query))
			{
				echo "Email Verified Successfully <a href='../index.php'>Go to Home</a>";
			}
			else
			{
				die("Update Query Failed");
			}
		}
		else
		{
			die("Invalid Token Number");
		}
	}
	else
	{
		die("Something Went Wrong");
	}
?>
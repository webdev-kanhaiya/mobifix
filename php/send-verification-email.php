<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "config.php";
		require "sendmail.php";
		$email=mysqli_real_escape_string($conn,$_POST['email_id']);
		$for=mysqli_real_escape_string($conn,$_POST['for']);
		
		$data_query="SELECT * FROM userdata WHERE email='$email'";
		$data_result=mysqli_query($conn,$data_query) or die("Data Query Failed");

		if($data_result->num_rows==1)
		{
			$otp=rand(100000,999999);
			$update_query="UPDATE userdata SET otp='$otp' WHERE email='$email'";
			if(mysqli_query($conn,$update_query))
			{
				if($for=="register")
				{
					$encoded_otp=base64_encode($otp);
					$encoded_email=base64_encode($email);
					$subject="Verify Your Email ID : Molexy";
					$body="Please Verify Your Email ID by Clicking This Link <a href='".BASE_URL."php/verify-email.php?eid=".$encoded_email."&token=".$encoded_otp."'>Verify Email</a>";
				}
				else if($for=="forgot")
				{
					$subject="Forgot Password Request : Mobifix";
					$body="Your OTP for Changing Password is $otp";
				}
				else
				{
					die("Something Went Wrong");
				}

				if(smtp_mailer($email,$subject,$body))
				{
					echo "done";
				}
				else
				{
					echo "Can't Send Mail Now!";
				}
			}
			else
			{
				die("Update Query Failed");
			}
		}
		else
		{
			die("User Not Exists");
		}		
	}
	else
	{
		die("Invalid Request : Access Denied");
	}
?>
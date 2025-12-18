<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "config.php";
		$shop_name=mysqli_real_escape_string($conn,$_POST['shop-name']);
		$owner_name=mysqli_real_escape_string($conn,$_POST['owner-name']);
		$mobile_number=mysqli_real_escape_string($conn,$_POST['mobile-number']);
		$address=mysqli_real_escape_string($conn,$_POST['address']);
		$gstin=mysqli_real_escape_string($conn,$_POST['gstin']);
		$email_id=mysqli_real_escape_string($conn,$_POST['email-id']);
		$password=md5($_POST['password']);
		$captcha=$_POST['captcha'];

		$secret_key="6LcTkpMrAAAAAKZ06RiM2l5D8kI0BTqfro721mjM";

		$captcha_verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha");

		$captcha_response=json_decode($captcha_verify);

		if($captcha_response->success)
		{
			$select_query="SELECT * FROM userdata WHERE email='$email_id'";
			$select_result=mysqli_query($conn,$select_query) or die("Select Query Failed");
			if($select_result->num_rows>0)
			{
				echo "Email Already Registered!";
			}
			else
			{
				$image_name=$_FILES['logo-upload']['name'];

				if($image_name!="")
				{
					$tmp_name=$_FILES['logo-upload']['tmp_name'];
					$extension=strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
					
					if($extension=="jpg" || $extension=="jpeg")
					{
						$src=imagecreatefromjpeg($tmp_name);
					}
					else if($extension=="png")
					{
						$src=imagecreatefrompng($tmp_name);
					}
					else if($extension=="webp")
					{
						$src=imagecreatefromwebp($tmp_name);
					}
					else
					{
						die("Only JPG, PNG or GIF file can be converted");
					}

					$desire_image_name=md5($email_id.date("dmyhis")).".webp";
					
					imagewebp($src,"../images/uploads/shop-logos/$desire_image_name",50);
					imagedestroy($src);

					$insert_query="INSERT INTO userdata(shop_name,owner_name,mobile_number,shop_address,gstin,shop_logo,email,password)VALUES('$shop_name','$owner_name','$mobile_number','$address','$gstin','$desire_image_name','$email_id','$password')";
				}
				else
				{
					$insert_query="INSERT INTO userdata(shop_name,owner_name,mobile_number,shop_address,gstin,email,password)VALUES('$shop_name','$owner_name','$mobile_number','$address','$gstin','$email_id','$password')";
				}
				
				if(mysqli_query($conn,$insert_query))
				{
					echo "done";
				}
				else
				{
					echo "Insert Query Failed";
				}
			}
		}
		else
		{
			echo "Captcha Verification Failed";
		}
	}
	else
	{
		die("Error : Access Denied");
	}
?>
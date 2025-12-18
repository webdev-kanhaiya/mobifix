<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();

		$admin=$_SESSION['admin_email'];

		$shop_name=mysqli_real_escape_string($conn,$_POST['shop-name']);
		$owner_name=mysqli_real_escape_string($conn,$_POST['owner-name']);
		$mobile_number=mysqli_real_escape_string($conn,$_POST['mobile-number']);
		$shop_address=mysqli_real_escape_string($conn,$_POST['shop-address']);
		$gstin=mysqli_real_escape_string($conn,$_POST['gstin']);

		$image_name=$_FILES['shop-logo']['name'];
		if($image_name!="")
		{
			$tmp_name=$_FILES['shop-logo']['tmp_name'];
			$userdata_query="SELECT * FROM userdata WHERE email='$admin'";
			$userdata_result=mysqli_query($conn,$userdata_query) or die("Order Query Failed");

			if($userdata_result->num_rows==1)
			{
				$userdata_data=mysqli_fetch_assoc($userdata_result);
				if($userdata_data['shop_logo']!=NULL)
				{
					$ex_image_name=$userdata_data['shop_logo'];
					unlink("../../images/uploads/shop-logos/$ex_image_name");
				}
				
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

				$desire_image_name=md5($admin.date("dmyhis")).".webp";
				imagewebp($src,"../../images/uploads/shop-logos/$desire_image_name",50);
				imagedestroy($src);

				/*move_uploaded_file($tmp_name, "../../images/uploads/shop-logos/$desire_image_name");*/
			}
			else
			{
				die("Something Went Wrong");
			}

			$update_query="UPDATE userdata SET shop_name='$shop_name',owner_name='$owner_name',mobile_number='$mobile_number',shop_address='$shop_address',gstin='$gstin',shop_logo='$desire_image_name' WHERE email='$admin'";
		}
		else
		{
			$update_query="UPDATE userdata SET shop_name='$shop_name',owner_name='$owner_name',mobile_number='$mobile_number',shop_address='$shop_address',gstin='$gstin' WHERE email='$admin'";
		}

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
		die("Invalid Request : Access Denied");
	}
?>
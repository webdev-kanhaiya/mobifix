<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		$order_id=mysqli_real_escape_string($conn,$_POST['order-id']);
		$admin=$_SESSION['admin_email'];
		/*$customer_mobile=mysqli_real_escape_string($conn,$_POST['customer-mobile']);
		$customer_name=mysqli_real_escape_string($conn,$_POST['customer-name']);
		$customer_address=mysqli_real_escape_string($conn,$_POST['customer-address']);*/
		$customer_mobile=$_POST['hidden-mobile'];
		$model=mysqli_real_escape_string($conn,$_POST['model']);
		$problems=mysqli_real_escape_string($conn,$_POST['problems']);
		$final_amount=mysqli_real_escape_string($conn,$_POST['final-amount']);
		$paid_amount=mysqli_real_escape_string($conn,$_POST['paid-amount']);
		$text_password=mysqli_real_escape_string($conn,$_POST['text-password']);
		$additional_details=mysqli_real_escape_string($conn,$_POST['additional-details']);

		$image_name=$_FILES['file-upload']['name'];
		$tmp_name=$_FILES['file-upload']['tmp_name'];

		if($image_name!="")
		{
			$order_query="SELECT * FROM orders WHERE id='$order_id' AND admin='$admin'";
			$order_result=mysqli_query($conn,$order_query) or die("Order Query Failed");

			if($order_result->num_rows==1)
			{
				$order_data=mysqli_fetch_assoc($order_result);
				if($order_data['image']!=NULL)
				{
					$ex_image_name=$order_data['image'];
					unlink("../../images/uploads/mobile-images/$ex_image_name");
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

				$desire_image_name=md5($customer_mobile.date("dmyhis")).".webp";
				imagewebp($src,"../../images/uploads/mobile-images/$desire_image_name",50);
				imagedestroy($src);
				/*move_uploaded_file($tmp_name, "../../images/uploads/mobile-images/$desire_image_name");*/
			}
			else
			{
				die("Something Went Wrong");
			}

			$query="UPDATE orders SET mobile_model='$model',problems='$problems',amount='$final_amount',paid='$paid_amount',text_password='$text_password',addition_details='$additional_details',image='$desire_image_name' WHERE id='$order_id' AND admin='$admin'";
		}
		else
		{
			$query="UPDATE orders SET mobile_model='$model',problems='$problems',amount='$final_amount',paid='$paid_amount',text_password='$text_password',addition_details='$additional_details' WHERE id='$order_id' AND admin='$admin'";
		}

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
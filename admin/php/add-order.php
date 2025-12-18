<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		$admin=$_SESSION['admin_email'];
		$customer_mobile=mysqli_real_escape_string($conn,$_POST['customer-mobile']);
		$customer_name=mysqli_real_escape_string($conn,$_POST['customer-name']);
		$customer_address=mysqli_real_escape_string($conn,$_POST['customer-address']);
		$model=mysqli_real_escape_string($conn,$_POST['model']);
		$problems=mysqli_real_escape_string($conn,$_POST['problems']);
		$final_amount=mysqli_real_escape_string($conn,$_POST['final-amount']);
		$paid_amount=mysqli_real_escape_string($conn,$_POST['paid-amount']);
		$text_password=mysqli_real_escape_string($conn,$_POST['text-password']);
		$additional_details=mysqli_real_escape_string($conn,$_POST['additional-details']);

		$image_name=$_FILES['file-upload']['name'];

		if($image_name!="")
		{
			$tmp_name=$_FILES['file-upload']['tmp_name'];
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
			$query="INSERT INTO orders(customer_name,customer_mobile,customer_address,mobile_model,problems,amount,paid,text_password,image,addition_details,admin)VALUES('$customer_name','$customer_mobile','$customer_address','$model','$problems','$final_amount','$paid_amount','$text_password','$desire_image_name','$additional_details','$admin');";
		}
		else
		{
			$query="INSERT INTO orders(customer_name,customer_mobile,customer_address,mobile_model,problems,amount,paid,text_password,addition_details,admin)VALUES('$customer_name','$customer_mobile','$customer_address','$model','$problems','$final_amount','$paid_amount','$text_password','$additional_details','$admin');";
		}

		

		$select_query="SELECT * FROM customer WHERE mobile='$customer_mobile' AND admin='$admin'";
		$select_result=mysqli_query($conn,$select_query) or die("Select Query failed");

		if($select_result->num_rows==0)
		{
			$query.="INSERT INTO customer(name,mobile,address,admin)VALUES('$customer_name','$customer_mobile','$customer_address','$admin');";
		}

		if(mysqli_multi_query($conn,$query))
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
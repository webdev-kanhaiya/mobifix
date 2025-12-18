<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		session_start();
		require "../../php/config.php";
		$admin=$_SESSION['admin_email'];
		$order_id=$_POST['order_id'];

		$select_query="SELECT * FROM orders WHERE id='$order_id'";
		$select_result=mysqli_query($conn,$select_query) or die("Select Query failed");
		if($select_result->num_rows==1)
		{
			$select_row=mysqli_fetch_assoc($select_result);
			$image=$select_row['image'];
			if($image!="")
			{
				unlink("../../images/uploads/mobile-images/$image");
			}
			$query="DELETE FROM orders WHERE id='$order_id' AND admin='$admin'";
			if(mysqli_query($conn,$query))
			{
				echo "done";
			}
			else
			{
				echo "Can't Delete Data Now!";
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
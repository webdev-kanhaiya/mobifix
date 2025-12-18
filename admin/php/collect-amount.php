<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		$order_id=mysqli_real_escape_string($conn,$_POST['order_id']);
		$remaining_amount=mysqli_real_escape_string($conn,$_POST['remaining_amount']);

		$query="UPDATE orders SET paid=paid+'$remaining_amount' WHERE id='$order_id'";
		if(mysqli_query($conn,$query))
		{
			echo "done";
		}
		else
		{
			echo "Can't Update Amount Now!";
		}
	}
	else
	{
		die("Access Denied");
	}
?>
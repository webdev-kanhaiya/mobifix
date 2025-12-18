<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		
		$order_id=$_POST['order_id'];
		$status=$_POST['status'];
		$admin=$_SESSION['admin_email'];

		$data_query="SELECT * FROM orders WHERE id='$order_id'";
		$data_result=mysqli_query($conn,$data_query) or die("Data Query Failed");
		if($data_result->num_rows==1)
		{
			$data_row=mysqli_fetch_assoc($data_result);
			$remaining_amount=$data_row['amount']-$data_row['paid'];
			$update_query="UPDATE orders SET status='$status' WHERE id='$order_id' AND admin='$admin'";
			if(mysqli_query($conn,$update_query))
			{
				echo json_encode(array("status"=>"success","output"=>$remaining_amount));
			}
			else
			{
				echo json_encode(array("status"=>"failed","output"=>"Update Query Failed"));
			}
		}
		else
		{
			echo json_encode(array("status"=>"failed","output"=>"Invalid Order ID"));
		}
	}
	else
	{
		die("Invalid Request : Access Denied");
	}
?>
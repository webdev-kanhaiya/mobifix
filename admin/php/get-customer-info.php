<?php 
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();
		$mobile=mysqli_real_escape_string($conn,$_POST['mobile']);
		$admin=$_SESSION['admin_email'];

		$query="SELECT * FROM customer WHERE mobile LIKE '$mobile%' and admin='$admin'";
		$result=mysqli_query($conn,$query) or die("Query Failed");

		if($result->num_rows>0)
		{
			for($i=1;$i<=$result->num_rows;$i++)
			{
				$row=mysqli_fetch_assoc($result);
				echo "<li cname='".$row['name']."' cmobile='".$row['mobile']."' caddress='".$row['address']."'><i class='fa fa-user'></i> ".$row['name'].' : '.$row['mobile']."</li>";
			}
		}
		else
		{
			echo "no data found";
		}
	}
	else
	{
		die("Invalid Request : Access Denied");
	}
?>
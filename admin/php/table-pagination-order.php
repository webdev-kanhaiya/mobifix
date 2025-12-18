<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		session_start();
		require "../../php/config.php";
		$admin_email=$_SESSION['admin_email'];
		$page=mysqli_real_escape_string($conn,$_POST['page']);
		$limit=20;
		$offset=($page-1)*$limit;

		$query="SELECT * FROM orders WHERE admin='$admin_email' ORDER BY id DESC LIMIT $offset,$limit";
		$result=mysqli_query($conn,$query) or die("Query Failed");
		if($result->num_rows>0)
		{
			for($i=1;$i<=$result->num_rows;$i++)
			{
				$data=mysqli_fetch_assoc($result);
				if($data['image']==NULL)
				{
					$image='<img src="../images/no-image.png">';
				}
				else
				{
					$image='<a href="../images/uploads/mobile-images/'.$data["image"].'" target="blank"><img src="../images/uploads/mobile-images/'.$data["image"].'"></a>';
				}

				if($data["paid"]=="")
				{
					$paid="-";
				}
				else
				{
					$paid=$data["paid"];
				}

				if($data["text_password"]=="")
				{
					$text_password="-";
				}
				else
				{
					$text_password=$data["text_password"];
				}

				if($data["addition_details"]=="")
				{
					$addition_details="-";
				}
				else
				{
					$addition_details=$data["addition_details"];
				}

				if($data["customer_address"]=="")
				{
					$customer_address="-";
				}
				else
				{
					$customer_address=$data["customer_address"];
				}

				if($data['pattern_password']==NULL)
				{
					$pattern="NA";
				}
				else
				{
					$pattern='<button class="watch" order-id="'.$data['id'].'">Watch</button>';
				}

				echo '<tr>
					<td>'.$image.'</td>
					<td><span class="'.$data["status"].'-label">'.ucfirst($data["status"]).'</span></td>
					<td>'.$data["mobile_model"].'</td>
					<td>'.$data["problems"].'</td>
					<td>'.$data["amount"].'</td>
					<td>'.$paid.'</td>
					<td>'.$text_password.'</td>
					<td>'.$pattern.'</td>
					<td>'.$addition_details.'</td>
					<td>'.$data["customer_mobile"].'</td>
					<td>'.$data["customer_name"].'</td>
					<td>'.$customer_address.'</td>
					<td>'.$data["timing"].'</td>
				</tr>';
			}
		}
		else
		{
			echo "No Orders Found";
		}
	}
	else
	{
		echo "Access Denied";
	}
?>
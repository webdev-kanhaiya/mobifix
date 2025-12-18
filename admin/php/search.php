<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		require "../../php/config.php";
		session_start();

		$search_term=mysqli_real_escape_string($conn,$_POST['search_term']);
		$admin=$_SESSION['admin_email'];
		$oid=ltrim($search_term,"ORD00");

		$query="SELECT * FROM orders WHERE customer_mobile LIKE '%$search_term%' OR customer_name LIKE '%$search_term%' OR customer_address LIKE '%$search_term%' OR id LIKE '$oid' OR mobile_model LIKE '%$search_term%' OR problems LIKE '%$search_term%' OR text_password LIKE '%$search_term%'";
		$result=mysqli_query($conn,$query) or die("Query Failed");

		if($result->num_rows>0)
		{
			for($i=1;$i<=$result->num_rows;$i++)
			{
				$data=mysqli_fetch_assoc($result);
				if($data['image']==NULL)
				{
					$image='<img src="https://imgs.search.brave.com/j9LZDuG7FrWJ2EGgJkCayenFy9EKOyT-8NtNHnS4Jns/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90aHVt/YnMuZHJlYW1zdGlt/ZS5jb20vYi9tb2Jp/bGUtcGhvbmUtc2Fk/LWZhY2Utc2NyZWVu/LWNhcnRvb24tZmxh/dC1pbGx1c3RyYXRp/b24tYnJva2VuLXNt/YXJ0cGhvbmUtcHJv/YmxlbS10ZWNobmlx/dWUtc2hvY2tlZC1z/dXJwcmlzZWQtZXll/cy0yMjY2MDA1MDEu/anBn">';
				}
				else
				{
					$image='<img src="../images/uploads/mobile-images/'.$data["image"].'">';
				}

				$status=$data['status'];

				if($status=="pending")
				{
					$options='<option value="pending" selected disabled>Pending</option>
					<option value="repaired">Repaired</option>
					<option value="delivered">Delivered</option>
					<option value="cancelled">Cancelled</option>';
				}
				else if($status=="repaired")
				{
					$options='<option value="pending">Pending</option>
					<option value="repaired" selected disabled>Repaired</option>
					<option value="delivered">Delivered</option>
					<option value="cancelled">Cancelled</option>';
				}
				else if($status=="delivered")
				{
					$options='<option value="pending">Pending</option>
					<option value="repaired">Repaired</option>
					<option value="delivered" selected disabled>Delivered</option>
					<option value="cancelled">Cancelled</option>';
				}
				else if($status=="cancelled")
				{
					$options='<option value="pending">Pending</option>
					<option value="repaired">Repaired</option>
					<option value="delivered">Delivered</option>
					<option value="cancelled" selected disabled>Cancelled</option>';
				}
				else
				{
					$options='<option value="pending">Pending</option>
					<option value="repaired">Repaired</option>
					<option value="delivered">Delivered</option>
					<option value="cancelled">Cancelled</option>';
				}


				echo '<div class="order" order-id="'.$data["id"].'">
					<div class="upper-order">
						<span class="order-id">#ORD00'.$data["id"].'</span>
						<span class="timing">'.$data["timing"].'</span>
					</div>
					<div class="middle-order">
						<div class="image-box">'.$image.'</div>
						<div class="details">
							<ul>
								<li>Customer : '.$data["customer_name"].'</li>
								<li>Model : '.$data["mobile_model"].'</li>
								<li>Problems : '.$data["problems"].'</li>
								<li>Price : '.$data["amount"].'</li>
							</ul>
						</div>
					</div>
					<div class="lower-order">
						<button class="edit-btn"><i class="fa fa-edit"></i> Edit</button>
						<button class="delete-btn"><i class="fa fa-trash-alt"></i> Delete</button>
						<button class="invoice-btn"><i class="fa fa-book"></i> Bill</button>
						<select class="change-status">
							'.$options.'
						</select>
					</div>
				</div>';
			}
		}
		else
		{
			echo "<div class='no-order-box'><img src='../images/no-orders.webp'><h3>Term ".ucfirst($search_term)." Not Found :(</h3><p>Click on <i class='fa fa-plus-circle'></i> icon at the right bottom corner</p></div>";
		}
	}
	else
	{
		die("Invalid Request : Access Denied");
	}
?>
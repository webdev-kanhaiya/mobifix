<?php session_start(); ?>
<style>
	.orders-data-box{
		margin: 0px auto;
	}

	.orders-data-box h3{
		margin-top: 25px;
		font-weight: 600;
		font-size: 1.7rem;
		color: var(--primary-color);
		font-family: var(--heading-font);
		margin-bottom: 30px;
	}

	.watch{
		background-color: var(--primary-color);
		color: white;
	}

	.orders-data-box h3{
		font-size: 1.5rem;
	}

	.pagination-box{
		margin-top: 32px;
	}

	.pagination{
		margin: 0;
	}
</style>
<div class="orders-data-box">
	<h3>Orders Data</h3>
	<div class="table-box">
		<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Image</th>
					<th>Status</th>
					<th>Model</th>
					<th>Problems</th>
					<th>Amount</th>
					<th>Paid</th>
					<th>Text Password</th>
					<th>Pattern Lock</th>
					<th>Additional</th>
					<th>Mobile</th>
					<th>Name</th>
					<th>Address</th>
					<th>Timing</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					require "../../php/config.php";
					$admin_email=$_SESSION['admin_email'];
					$query="SELECT * FROM orders WHERE admin='$admin_email' ORDER BY id DESC LIMIT 0,20";
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
				?>
				<!-- <tr>
					<td><img src="../images/no-image.png"></td>
					<td><span class="pending-label">Pending</span></td>
					<td>Infinix Hot 30i</td>
					<td>Jack,Mic,Display</td>
					<td>5000</td>
					<td>200</td>
					<td>654879</td>
					<td><button class="watch">Watch</button></td>
					<td>Lorem Ipsum</td>
					<td>8882778758</td>
					<td>Lorem Gali</td>
					<td>Address is Here</td>
					<td>12:00:00 15/08/2025</td>
				</tr> -->
			</tbody>
		</table>
	</div>
	<div class="pagination-box">
		<?php
			$total_query="SELECT COUNT(id) as total_rows FROM orders WHERE admin='$admin_email' AND status='pending'";
			$total_result=mysqli_query($conn,$total_query) or die("Query Failed");
			$total_rows=mysqli_fetch_assoc($total_result)['total_rows'];

			if($total_rows>20)
			{
				$total_pages=ceil($total_rows/20);
				echo "<div class='pagination'>";
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i==1)
					{
						echo "<div class='pagination-link active' page='$i'>$i</div>";
					}
					else
					{
						echo "<div class='pagination-link' page='$i'>$i</div>";
					}
				}
				echo "</div>";
			}
		?>
	</div>
</div>
<script>
	/*$(".watch").click(function(){
		var premium="<?php session_start(); echo $_SESSION['premium']; ?>";
		if(premium=="no")
		{
			errorMsg("This Feature is Coming Soon");
		}
		else
		{
			//Pattern Lock coding Here
		}
	});*/

	$(document).on("click",".pagination-link",function(){
		var page=$(this).attr("page");

		$(".pagination-link").removeClass("active");
		$(this).addClass("active");
		$.ajax({
			url : "php/table-pagination-order.php",
			type : "POST",
			data : {page},
			beforeSend : function()
			{
				showLoader();
			},
			success : function(response)
			{
				$(".orders-data-box table tbody").html(response);
				hideLoader();
			}
		});
	});
</script>
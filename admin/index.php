<?php require "php/login-status.php"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require "commons/head.php"; ?>
</head>
<body>
	<?php require "commons/topbar.php"; ?>
	<style>
		@media(min-width: 1100px)
		{
			.setting{
				padding-top: 10px;
			}
		}
	</style>
	<div class="container">
		<?php
			$admin_email=$_SESSION['admin_email'];

			$shop_query="SELECT * FROM userdata WHERE email='$admin_email'";
			$shop_result=mysqli_query($conn,$shop_query) or die("Shop Query Failed");

			if($shop_result->num_rows==1)
			{
				$shop_data=mysqli_fetch_assoc($shop_result);
			}
			else
			{
				die("Something Went Wrong!");
			}

			if($shop_data['status']=="pending")
			{
				echo '<div class="email-warning">
				<p>We have sent an email to <b>'.$admin_email.'</b> Please verify this email within 7 days</p>
				<button class="resend-email">Resend Email</button>
				</div>';
			}
		?>
		<h1>Welcome, <?php echo $shop_name; ?></h1>
		<div class="search-box">
			<input type="text" id="search" placeholder="Search Repair Order Here...">
			<button class="search-btn"><i class="fa fa-search"></i></button>
		</div>
		<div class="tabs">
			<div class="tab active-tab" tab="pending">Pending</div>
			<div class="tab" tab="repaired">Repaired</div>
			<div class="tab" tab="delivered">Delivered</div>
			<div class="tab" tab="cancelled">Cancelled</div>
		</div>
		<div class="order-box">
			<?php 
				$query="SELECT * FROM orders WHERE admin='$admin_email' AND status='pending' ORDER BY id DESC LIMIT 0,20";
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
									<option value="pending" disabled selected>Pending</option>
									<option value="repaired">Repaired</option>
									<option value="delivered">Delivered</option>
									<option value="cancelled">Cancelled</option>
								</select>
							</div>
						</div>';
					}
				}
				else
				{
					echo "<div class='no-order-box'><img src='../images/no-orders.webp'><h3>There is No Pending order</h3><p>Click on <i class='fa fa-plus-circle'></i> icon at the right bottom corner</p></div>";
				}
			?>
			<!-- <div class="order">
				<div class="upper-order">
					<span class="order-id">#ORD0001</span>
					<span class="timing">23/July/2023 15:53</span>
				</div>
				<div class="middle-order">
					<div class="image-box">
						<img src="https://imgs.search.brave.com/mgs3ksiuezcoJWHMvs8hvLUmYz8h86mH8wMLDWgCvx8/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMucHJpY2VveWUu/cGsvdml2by15MjEt/cGFraXN0YW4tcHJp/Y2VveWUta2J3N2Mu/anBn">
					</div>
					<div class="details">
						<ul>
							<li>Customer : Bhure</li>
							<li>Model : Vivo Y21</li>
							<li>Problems : Jack and Mic</li>
							<li>Price : 5000</li>
						</ul>
					</div>
				</div>
				<div class="lower-order">
					<button class="edit-btn"><i class="fa fa-edit"></i> Edit</button>
					<button class="delete-btn"><i class="fa fa-trash-alt"></i> Delete</button>
					<button class="invoice-btn"><i class="fa fa-book"></i> Bill</button>
					<select id="change-status">
						<option value="pending" disabled selected>Pending</option>
						<option value="repaired">Repaired</option>
						<option value="delivered">Delivered</option>
						<option value="cancelled">Cancelled</option>
					</select>
				</div>
			</div> -->
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
	<a href="add-order.php" id="add-btn"><i class="fa fa-plus"></i></a>
	<?php 
		require "../commons/loader.php";
		require "../commons/message.php";
	?>
	<script>
		$(document).ready(function(){
			$(document).on("click",".edit-btn",function(){
				var order_id=$(this).parents(".order").attr("order-id");
				location.href="edit-order.php?id="+order_id;
			});

			$(document).on("click",".invoice-btn",function(){
				var order_id=$(this).parents(".order").attr("order-id");
				location.href="invoice.php?id="+order_id;
			});

			$(document).on("click",".upper-order,.middle-order",function(){
				var order_id=$(this).parents(".order").attr("order-id");
				location.href="order-details.php?id="+order_id;
			});

			$(document).on("click",".delete-btn",function(e){
				e.stopPropagation();
				if(window.confirm("Do You Really Want to Delete This Order ?"))
				{
					var box=$(this).parents(".order");
					var order_id=$(this).parents(".order").attr("order-id");
					$.ajax({
						url : "php/delete-order.php",
						type : "POST",
						data : {order_id},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							hideLoader();
							if(response.trim()=="done")
							{
								successMsg("Order Deleted Successfully");
								box.fadeOut(400);
							}
							else
							{
								errorMsg(response);
							}
						}
					});
				}
			});

			$(document).on("change",".change-status",function(){
				if(confirm("Do You Really Want to Change The Status ?"))
				{
					var parent=$(this).parents(".order");
					var order_id=$(this).parents(".order").attr("order-id");
					var status=$(this).val();

					$.ajax({
						url : "php/change-status.php",
						type : "POST",
						data : {order_id,status},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							var data=JSON.parse(response);
							if(data.status=="success")
							{
								if(status=="delivered")
								{
									var remaining_amount=data.output;
									if(confirm("Have You Collected ₹"+remaining_amount+" From Customer"))
									{
										$.ajax({
											url : "php/collect-amount.php",
											type : "POST",
											data : {order_id,remaining_amount},
											success : function(response)
											{
												if(response.trim()=="done")
												{
													successMsg("Paid Amount Updated Successfully");
												}
												else
												{
													errorMsg(response);
												}
											}
										});
									}
								}
								parent.fadeOut(200);
							}
							else
							{
								errorMsg(data.output);
							}
							hideLoader();
						}
					});
				}
			});

			$(".tab").click(function(){
				$(".tab").removeClass("active-tab");
				$(this).addClass("active-tab");
				var status=$(this).attr("tab");
				$.ajax({
					url : "php/get-orders.php",
					type : "POST",
					data : {status},
					beforeSend : function()
					{
						showLoader();
					},
					success : function(response)
					{
						history.pushState({},"","index.php?orders="+status);
						$(".pagination-box").empty();
						var object=JSON.parse(response);
						if(object.status.trim()=="success")
						{
							$(".order-box").html(object.orders);
							$(".pagination-box").html(object.pagination);
						}
						else if(object.status=="failed")
						{
							$(".order-box").html(object.message);
						}
						else
						{
							errorMsg(object);
						}
						hideLoader();
					}
				});
			});

			$(".search-btn").click(function(){
				var search_term=$("#search").val();
				if(search_term!="")
				{
					$.ajax({
						url : "php/search.php",
						type : "POST",
						data : {search_term},
						beforeSend : function(){
							showLoader();
						},
						success : function(response)
						{
							hideLoader();
							$(".order-box").html(response);
						}
					});
				}
			});

			$(".resend-email").click(function(){
				var email_id="<?php echo $admin_email; ?>";
				$.ajax({
					url : "../php/send-verification-email.php",
					type : "POST",
					data : {for:"register",email_id},
					beforeSend : function()
					{
						showLoader();
					},
					success : function(response)
					{
						hideLoader();
						if(response.trim()=="done")
						{
							successMsg("Mail Send Successfully");
						}
						else
						{
							errorMsg(response);
						}
					}
				});
			});

			$(document).on("click",".pagination-link",function(){
				var order_object = new URLSearchParams(window.location.search);
				var order_type = order_object.get("orders");
				var page=$(this).attr("page");

				if(order_type==null)
				{
					var order_type="pending";
				}

				if(order_type=="pending" || order_type=="repaired" || order_type=="delivered" || order_type=="cancelled"){
					$(".pagination-link").removeClass("active");
					$(this).addClass("active");
					$.ajax({
						url : "php/pagination-order.php",
						type : "POST",
						data : {page,order_type},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							$(".order-box").html(response);
							hideLoader();
						}
					});
				}
				else
				{
					errorMsg("Something Went Wrong");
				}
			});
		});
	</script>
</body>
</html>
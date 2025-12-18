<?php require "php/login-status.php"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require "commons/head.php"; ?>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
	<?php 
		require "commons/topbar.php";
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
	?>
	
	<div class="container">
		<div class="options-box">
			<div class="header">
				<div class="image-box">
					<?php
						if($shop_data['shop_logo']==NULL)
						{
							$image="../images/no-image.png";
						}
						else
						{
							$logo=$shop_data['shop_logo'];
							$image="../images/uploads/shop-logos/$logo";
						}
					?>
					<img src="<?php echo $image; ?>">
				</div>
				<div class="header-text-box">
					<h2><?php echo $shop_data['shop_name']; ?></h2>
					<p><?php echo $shop_data['email']; ?></p>
				</div>
			</div>
			<h4 class="label">Features & Options</h4>
			<div class="links">
				<div class="link" id="analytics-link" page="analytics">
					<div class="link-icon">
						<i class="fa fa-chart-area"></i>
					</div>
					<div class="link-details">
						<h3>Analytics & Reports</h3>
						<p>To analyse the performance lorem</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="order-data-link" page="orders-data">
					<div class="link-icon">
						<i class="fa fa-box"></i>
					</div>
					<div class="link-details">
						<h3>Orders Data</h3>
						<p>Get Your Orders Information Here</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="customer-data-link" page="customers-data">
					<div class="link-icon">
						<i class="fa fa-user"></i>
					</div>
					<div class="link-details">
						<h3>Customers Data</h3>
						<p>Your Customer Data is Here</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="learn-link" page="video-tutorial">
					<div class="link-icon">
						<i class="fa-brands fa-youtube"></i>
					</div>
					<div class="link-details">
						<h3>How to Use ?</h3>
						<p>Learn through video tutorial</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="change-password-link" page="change-password">
					<div class="link-icon">
						<i class="fa fa-key"></i>
					</div>
					<div class="link-details">
						<h3>Change Password</h3>
						<p>Change your current password</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="update-details-link" page="update-details">
					<div class="link-icon">
						<i class="fa fa-edit"></i>
					</div>
					<div class="link-details">
						<h3>Update Details</h3>
						<p>To update registration details</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="user-management-link">
					<div class="link-icon">
						<i class="fa fa-users"></i>
					</div>
					<div class="link-details">
						<h3>User Management</h3>
						<p>Manage All The Users</p>
					</div>
					<i class="fa fa-lock chevron"></i>
				</div>
				<div class="link" id="feedback-link" page="feedback">
					<div class="link-icon">
						<i class="fa fa-comment-dots"></i>
					</div>
					<div class="link-details">
						<h3>Feedback</h3>
						<p>Give us feedback to enhancement</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
				<div class="link" id="logout-link">
					<div class="link-icon">
						<i class="fa fa-sign-out-alt"></i>
					</div>
					<div class="link-details">
						<h3>Logout</h3>
						<p>Click here to logout</p>
					</div>
					<i class="fa fa-chevron-right chevron"></i>
				</div>
			</div>
			<h6 class="developed-by">Developed by : Kanhaiya Lal Gupta</h6>
		</div>
		<div class="content-box">
			<i class="fa fa-close" id="close-content-box"></i>
			<div class="inner-content-box">

			</div>
		</div>
	</div>
	<?php
		require "../commons/loader.php";
		require "../commons/message.php";
	?>
	<div class="edit-popup">
		<div class="edit-box">
			<h3>Edit Customer</h3>
			<form id="edit-form" autocomplete="off">
				<input type="hidden" name="cid" id="cid">
				<input type="text" name="customer-name" id="username" placeholder="Enter Customer Name">
				<input type="number" name="customer-mobile" id="mobile" placeholder="Enter Customer Mobile Number">
				<textarea name="customer-address" id="address" placeholder="Enter Customer Address"></textarea>
				<button type="submit"><i class="fa fa-edit"></i> Update Details</button>
			</form>	
			<i class="fa fa-close" id="edit-close"></i>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			function generateColorTheme()
			{
				const randomHex = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');

				$(".link").css("border-color",randomHex);
				$(".container").css("background-color",randomHex+"0d");
			}
			generateColorTheme();

			$.ajax({
				url : "components/analytics.php",
				type : "POST",
				contentType : false,
				processData : false,
				beforeSend : function()
				{
					showLoader();
				},
				success : function(data)
				{
					hideLoader();
					$(".inner-content-box").html(data);
				}
			});

			$("#analytics-link,#learn-link,#feedback-link,#change-password-link,#update-details-link,#customer-data-link,#order-data-link").click(function(){
				var page=$(this).attr("page");
				$.ajax({
					url : "components/"+page+".php",
					type : "POST",
					contentType : false,
					processData : false,
					beforeSend : function()
					{
						showLoader();
						$(".content-box").animate({
							"right":"0px"
						},500);
					},
					success : function(data)
					{
						hideLoader();
						$(".inner-content-box").html(data);
					}
				});
			});

			$("#close-content-box").click(function(){
				$(".content-box").animate({
					"right":"-100%"
				},500,function(){
					$(".inner-content-box").html("");
				});
			});

			$("#logout-link").click(function(){
				location.href="php/logout.php";
			});

			$("#user-management-link").click(function(){
				alert("This Feature is Coming Soon!");
			});

			$(document).on("click",".c-edit-btn",function(){
				var cid=$(this).attr("cid");
				var name=$(this).attr("name");
				var mobile=$(this).attr("mobile");
				var address=$(this).attr("address");

				$("#cid").val(cid);
				$("#username").val(name);
				$("#mobile").val(mobile);
				$("#address").val(address);
				$(".edit-popup").fadeIn(400);
			});

			$("#edit-close").click(function(){
				$(".edit-popup").fadeOut(400);
			});

			$("#edit-form").submit(function(e){
				e.preventDefault();
				var name=$("#username").val().trim();
				var mobile=$("#mobile").val().trim();
				var address=$("#address").val().trim();
				var cid=$("#cid").val().trim();

				if(name=="" || mobile=="" || cid=="")
				{
					errorMsg("Name and Address are required");
				}
				else
				{
					$.ajax({
						url : "php/edit-customer.php",
						type : "POST",
						data : {name,mobile,address,cid},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							if(response.trim()=="done")
							{
								var current=$("[cid='"+cid+"']");
								var current_parent=current.parents("tr");
								current_parent.find("td:eq(0)").html(name);
								current_parent.find("td:eq(1)").html(mobile);
								current_parent.find("td:eq(2)").html(address);

								current.attr("name",name);
								current.attr("mobile",mobile);
								current.attr("address",address);


								successMsg("Detail Edited Successfully");
								$(".edit-popup").fadeOut(400);
							}
							else
							{
								errorMsg(response);
							}
							hideLoader();
						}
					});
				}
			});
		});
	</script>
</body>
</html>
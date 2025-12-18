<?php require "php/login-status.php"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require "commons/head.php"; ?>
</head>
<?php
	if(empty($_GET['id']))
	{
		die("No Order ID Found");
	}
	else
	{
		require "../php/config.php";
		$order_id=$_GET['id'];
		
		$select_query="SELECT * FROM orders WHERE id='$order_id' AND admin='$admin_email'";
		$select_result=mysqli_query($conn,$select_query) or die("Select Query failed");

		if($select_result->num_rows==1)
		{
			$data=mysqli_fetch_assoc($select_result);
		}	
		else
		{
			die("Something Went Wrong");
		}
	}
?>
<body>
	<div class="container">
		<div class="topbar">
			<a href="index.php" class="back-btn"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
			<p>#ORD00<?php echo $data['id']; ?></p>
		</div>
		<div class="header-btn-box">
			<button class="edit-btn"><i class="fa fa-edit"></i> Edit Order</button>
			<button class="call-btn"><i class="fa fa-phone"></i> Call Customer</button>
		</div>
		<div class="content-box">
			<h4>Customer Details</h4>
			<ul class="details">
				<li>
					<p class="particular">Customer :</p>
					<p class="value"><?php echo $data['customer_name']; ?></p>
				</li>
				<li>
					<p class="particular">Mobile :</p>
					<p class="value"><?php echo $data['customer_mobile']; ?></p>
				</li>
				<li>
					<p class="particular">Address :</p>
					<p class="value"><?php if($data['customer_address']==""){echo "Not Available";}else{echo $data['customer_address'];} ?></p>
				</li>
			</ul>
			<h4 class="after-heading">Mobile Details</h4>
			<ul class="details">
				<li>
					<p class="particular">Model :</p>
					<p class="value"><?php echo $data['mobile_model']; ?></p>
				</li>
				<li>
					<p class="particular">Total Amount :</p>
					<p class="value">&#8377; <?php echo $data['amount']; ?></p>
				</li>
				<li>
					<p class="particular">Paid Amount :</p>
					<p class="value">&#8377; <?php if($data['paid']==""){echo "0";}else{echo $data['paid'];} ?></p>
				</li>
				<li>
					<p class="particular">Text Password :</p>
					<p class="value"><?php if($data['text_password']==""){echo "Not Available";}else{echo $data['text_password'];} ?></p>
				</li>
				<li>
					<p class="particular">Pattern Lock :</p>
					<p class="value">
					<?php
						if($premium=="no")
						{
							echo "Coming Soon";
						}
						else
						{
							echo '<button id="watch-btn">Watch</button>';
						} 
					?>	
					</p>
				</li>
				<li>
					<p class="particular">Additional Details :</p>
					<p class="value"><?php if($data['addition_details']==""){echo "-";}else{echo $data['addition_details'];} ?></p>
				</li>
				<li>
					<p class="particular">Timestamp :</p>
					<p class="value"><?php echo $data['timing']; ?></p>
				</li>
				<li>
					<p class="particular">Status :</p>
					<p class="value"><span><?php echo ucfirst($data['status']); ?></span></p>
				</li>
				<div class="problems-wrapper">
					<h5>Problems <i class="fa fa-arrow-down"></i></h5>
					<div class="problems">
						<?php
							$problem_array=explode(",",$data['problems']);
							foreach($problem_array as $problem)
							{
								echo "<span>".$problem."</span>";
							}
						?>
					</div>
				</div>
			</ul>
		</div>
		<?php
			$image=$data['image'];
			if($image!=NULL)
			{
				echo "<div class='image-box'>
						<img src='../images/uploads/mobile-images/$image'>
					</div>";
			}
		?>
	</div>
	<script>
		$(document).ready(function(){
			$(".edit-btn").click(function(){
				var order_id="<?php echo $_GET['id']; ?>";
				location.href="edit-order.php?id="+order_id;
			});

			$(".call-btn").click(function(){
				var mobile="<?php echo $data['customer_mobile']; ?>";
				window.open("tel:"+mobile,"_parent");
			});

			$("#watch-btn").click(function(){
				alert("This Feature is Just for Premium Users")
			});
		});
	</script>
</body>
</html>
<?php 
	session_start();
?>
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
		
		$select_query="SELECT * FROM orders WHERE id='$order_id'";
		$select_result=mysqli_query($conn,$select_query) or die("Select Query failed");

		if($select_result->num_rows==1)
		{
			$data=mysqli_fetch_assoc($select_result);
			$admin_email=$data['admin'];
		}	
		else
		{
			die("Something Went Wrong");
		}
	}

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
<body>
	<?php
		// QR code API ka URL
		$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=".BASE_URL."admin/invoice.php?id=".$data['id'];

		// Image ko PHP se fetch karo
		$qr_image = file_get_contents($qr_url);

		// Base64 encode karo
		$qr_base64 = "data:image/png;base64," . base64_encode($qr_image);
	?>
	<div class="invoice-box" id="invoice-box">
		<div class="header">
			<div class="logo-box">
				<?php 
					if($shop_data['shop_logo']==NULL)
					{
						echo "<img src='../images/logos/mobifix-social-logo.png'>";
					}
					else
					{
						$image=$shop_data['shop_logo'];
						echo "<img src='../images/uploads/shop-logos/$image'>";
					}
				?>
			</div>
			<div class="seller-box">
				<h1><?php echo ucwords($shop_data['shop_name']); ?></h1>
				<address id="address"><?php echo $shop_data['shop_address']; ?></address>
				<address id="contact">Mobile : +91 <?php echo $shop_data['mobile_number']; ?> & Email : <?php echo $shop_data['email']; ?></address>
			</div>
			<div class="qr-box">
				<img src="<?php echo $qr_base64; ?>" crossorigin="anonymous">
				<p>Track Status</p>
			</div>
		</div>
		<div class="billing-box">
			<div class="left-billing">
				<h2>Customer : <?php echo $data['customer_name']; ?></h2>
				<p>Mobile No. : +91 <?php echo $data['customer_mobile']; ?></p>
				<address>Address : <?php echo $data['customer_address']; ?></address>
			</div>
			<div class="right-billing">
				<p>Date : <?php echo $data['timing']; ?></p>
				<p>Order No. : #ORD00<?php echo $data['id']; ?></p>
				<p>Seller GSTIN : <?php echo $shop_data['gstin']; ?></p>
			</div>
		</div>
		<div class="content-box">
			<div class="particulars-box">
				<div class="th">Particulars</div>
				<div class="particulars">
					<h4 class="model"><?php echo $data['mobile_model']; ?></h4>
					<?php
						$problem_array=explode(",",$data['problems']);
						foreach($problem_array as $problem)
						{
							echo "<p>- ".$problem."</p>";
						}
					?>
					<!-- <p>Jack Change</p>
					<p>Display Change</p>
					<p>MIC Change</p> -->
				</div>
				<div class="tf border-tf text-right">Grand Total</div>
				<div class="tf text-right">PAID</div>
				<div class="tf border-tf text-right">Due Amount</div>
			</div>
			<div class="rate-box">
				<div class="th">Amount</div>
				<div class="rate">
					<p><?php echo $data['amount'] ?></p>
				</div>
				<div class="tf border-tf"><?php echo $data['amount'] ?></div>
				<div class="tf">-<?php echo $data['paid'] ?></div>
				<div class="tf border-tf">
					<?php
						if($data['paid']=="")
						{
							echo $data['amount'];
						}
						else
						{
							echo $data['amount']-$data['paid'];
						}
					?>		
				</div>
			</div>
		</div>
		<div class="terms-box">
			<div class="terms">
				<ol>
					<li>Please Take Your Mobile Within 15 Days of Repairing. After This We Will Not be Responsible for Your Mobile</li>
					<li>Physical or Water Damage Will Not Be Consider for Warranty</li>
				</ol>
			</div>
			<div class="signature">
				<p>Authorised Signatory</p>
			</div>
		</div>
	</div>
	<div class="btn-box">
		<button class="download-btn"><i class="fa fa-download"></i></button>
		<button class="print-btn"><i class="fa fa-print"></i></button>
		<?php
			if(!empty($_SESSION['admin_email']))
			{
				echo '<button class="whatsapp-btn"><i class="fa-brands fa-whatsapp"></i></button>';
			}
		?>
	</div>
	<?php 
		require "../commons/loader.php";
		require "../commons/message.php";
	?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
	<script>
		$(document).ready(function(){
			var order_id="<?php echo $order_id; ?>";
			$(".print-btn").click(function(){
				window.print();
			});

			$(".whatsapp-btn").click(function(){
				var link="<?php echo BASE_URL."index.php?id="; ?>"+order_id;
				var phone="<?php echo $data['customer_mobile']; ?>";
				var message="Namaste! <?php echo $shop_data['shop_name']; ?> se apna mobile repair karwane ke liye sukriya! Aapka mobile repair ho chuka hai aap iss link par click karke invoice download kar sakte hai - \n "+link;
				location.href="https://api.whatsapp.com/send?phone=+91"+phone+"&text="+message;
			});

			$(".download-btn").click(function(){
				var element=document.getElementById("invoice-box");
				var opt={
					margin: 0,
					filename: "ORD00"+order_id+".pdf",
					image: {type:"jpeg",quality:1},
					html2canvas: {scale: 2},
					jsPDF: {unit:'mm',format:'a4',orientation:'portrait'}
				};

				html2pdf().set(opt).from(element).save();
			});
		});
	</script>
</body>
</html>
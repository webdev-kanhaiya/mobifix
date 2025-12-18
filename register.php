<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require "commons/head.php"; ?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<div class="topbar">
		<img src="images/logos/mobifix-purple.png" class="logo">
		<p class="help"><i class="fa-brands fa-youtube"></i> Need Help ?</p>
	</div>
	<div class="container">
		<h1>Register on Mobifix to Manage Your Shop Smarter !!</h1>
		<div class="form-box">
			<form id="form">
				<h2>Shop Registration</h2>
				<h6>Just Fill The Basic Details to Register</h6>
				<div class="input-row-half">
					<div class="field-box">
						<p>Shop Name</p>
						<input type="text" name="shop-name" id="shop-name" placeholder="Enter Shop Name" mandatory="yes">
					</div>
					<div class="field-box">
						<p>Owner Name</p>
						<input type="text" name="owner-name" id="owner-name" placeholder="Shop Owner Name" mandatory="yes">
					</div>
				</div>
				<div class="input-row">
					<div class="field-box">
						<p>Mobile Number</p>
						<input type="number" name="mobile-number" id="mobile-number" placeholder="Enter Mobile Number" mandatory="yes">
					</div>
				</div>
				<div class="input-row">
					<div class="field-box">
						<p>Shop Address</p>
						<textarea id="address" mandatory="yes" name="address" placeholder="Enter Shop Address"></textarea>
					</div>
				</div>
				<div class="input-row">
					<div class="field-box">
						<p>GST No (Optional)</p>
						<input type="text" name="gstin" id="gstin" placeholder="Enter GST Number">
					</div>
				</div>
				<div class="logo-upload-box">
					<div class="preview-box"></div>
					<input type="file" id="logo-upload" accept=".jpg,.jpeg,.png,.webp" name="logo-upload">
					<i class="fa fa-shop"></i>
					<h4>Upload Shop Logo (Optional)</h4>
					<p>Maximux 2MB & Square Image Recommended</p>
				</div>
				<h3>Account Details --</h3>
				<div class="input-row">
					<div class="field-box">
						<p>Email ID</p>
						<input type="email" name="email-id" id="email-id" placeholder="Enter Email ID" mandatory="yes">
					</div>
				</div>
				<div class="input-row">
					<div class="field-box">
						<p>Choose Password</p>
						<input type="password" name="password" id="password" placeholder="Choose a Password" mandatory="yes">
					</div>
				</div>
				<div class="terms">
					<input type="checkbox" name="checkbox" id="checkbox"> I have read all the <a href="#">Privacy Policy</a> and <a href="#">Terms & Conditions</a>
				</div>
				<div class="captcha-box">
					<div class="g-recaptcha" data-sitekey="6LcTkpMrAAAAAMz2FfbdwZE6bRcavJWmAIBbrult"></div>
				</div>
				<button type="submit" class="register-btn">Register My Shop</button>
				<p class="login-link">Already Registered ? <a href="login.php">Login Here</a></p>
			</form>
			<!-- <div class="email-verification">
				<img src="https://cdn-icons-gif.flaticon.com/14674/14674129.gif">
				<h2>A Confirmation Email Has Been Sent on king@gmail.com ! Please Follow The Following Steps :-</h2>
				<ol>
					<li>Click on 'Verify Email' Button on Your Mail</li>
					<li>Then Click on 'Complete Verification' Button Given Below</li>
				</ol>
				<div class="btn-box">
					<button id="cv">Complete Verification</button>
					<button id="re">Resend Email</button>
				</div>
			</div> -->
		</div>
	</div>
	<div class="video-popup">
		<i class="fa fa-close"></i>
	</div>
	<?php
		require "commons/loader.php";
		require "commons/message.php";
	?>
	<script>
		$(document).ready(function(){
			$(".help").click(function(){
				$(".video-popup").html('<i class="fa fa-close" id="close-video"></i><iframe src="https://www.youtube.com/embed/MpZBIseUUlg?si=AD_S1dxGUD0UfCnZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>').css("display","flex");
			});

			$(document).on("click","#close-video",function(){
				$(".video-popup").fadeOut(200);
			});

			$("#logo-upload").change(function(){
				var file=this.files[0];
				if(file)
				{
					var reader=new FileReader();
					reader.onload=function(e)
					{
						var preview_image="<img src='"+(e.target.result)+"' width='100px'>"
						$(".preview-box").html(preview_image);
						$(".logo-upload-box i").hide();
					}
					reader.readAsDataURL(file);
				}
				else
				{
					$(".logo-upload-box i").show();
					$(".preview-box").html("");
				}
			});

			$("#form").submit(function(e){
				e.preventDefault();
				
				var shop_name=$("#shop_name").val();
				var owner_name=$("#owner_name").val();
				var mobile_number=$("#mobile_number").val();
				var address=$("#address").val();
				var gstin=$("#gstin").val();
				var image=$("#logo-upload").val();
				var email_id=$("#email-id").val();
				var password=$("#password").val();
				var captcha=grecaptcha.getResponse();

				if(shop_name=="" || owner_name=="" || mobile_number=="" || address=="" || email_id=="" || password=="")
				{
					errorMsg("Please Fill All The Required Details");
					var i;
					for(i=0;i<$("[mandatory=yes]").length;i++)
					{
						if($("[mandatory=yes]:eq("+i+")").val()=="")
						{
							$("[mandatory=yes]:eq("+i+")").css("border-color","red");
						}
						else
						{
							$("[mandatory=yes]:eq("+i+")").css("border-color","#ccc");
						}
					}
				}
				else
				{
					$("[mandatory=yes]").css("border-color","#ccc");
					var checkbox=$("#checkbox");
					if(checkbox.prop("checked"))
					{
						if(captcha=="")
						{
							errorMsg("Please Complete The reCaptcha");
						}
						else
						{
							var formData = new FormData(this);
							formData.append("captcha", captcha);
							$.ajax({
								url : "php/register.php",
								type : "POST",
								data : formData,
								contentType : false,
								processData : false,
								beforeSend : function()
								{
									showLoader();
								},
								success : function(response)
								{
									hideLoader();
									if(response=="done")
									{
										
										/*$("#form").slideUp(400,function(){
											$(".email-verification").slideDown(400);
										});*/
										$("#form").trigger('reset');
										successMsg("Shop Registered Successfully! Please Wait...");
										$.ajax({
											url : "php/send-verification-email.php",
											type : "POST",
											data : {email_id,for:"register"},
											success : function(response)
											{
												if(response.trim()=="done")
												{
													successMsg("Mail Sent Successfully");
												}
												else
												{
													errorMsg(response);
												}
											}
										});
										setTimeout(function(){
											location.href="login.php";
										},3000);
									}
									else
									{
										errorMsg(response);
										grecaptcha.reset();
									}
								}
							});
						}
					}
					else
					{
						errorMsg("Please Check The Checkbox");
					}
				}
			});			
		});
	</script>
</body>
</html>
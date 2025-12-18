<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php require "commons/head.php"; ?>
</head>
<body>
	<div class="topbar">
		<img src="images/logos/mobifix-purple.png" class="logo">
		<a href="register.php"><button><i class="fa fa-shop"></i> Register Your Shop</button></a>
	</div>
	<div class="container">
		<div class="login-form-box">
			<h1>Mobifix Login</h1>
			<h6>Login to Access Your Dashboard</h6>
			<form id="login-form">
				<div class="input-row">
					<div class="field-box">
						<p>Email ID</p>
						<input type="email" name="login-email" id="login-email" placeholder="Enter Email ID">
					</div>
				</div>
				<div class="input-row">
					<div class="field-box">
						<p>Password</p>
						<input type="password" name="login-password" id="login-password" placeholder="Enter Password">
					</div>
				</div>
				<button type="submit" class="login-btn"><i class="fa fa-shop"></i> Login to Shop</button>
				<p class="forgot-link">Forgot Password ? <span>Login with OTP</span></p>
			</form>
		</div>
		<div class="forgot-form-box">
			<h1>Login with OTP</h1>
			<h6>Enter Your Email to Receive an OTP</h6>
			<form id="forgot-form">
				<div class="input-row first-step">
					<div class="field-box">
						<p>Email ID</p>
						<input type="email" name="forgot-email" id="forgot-email" placeholder="Enter Email ID">
					</div>
					<button type="button"><i class="fa fa-paper-plane"></i> Get OTP</button>
				</div>
				<div class="input-row second-step">
					<div class="field-box">
						<p>OTP</p>
						<input type="number" name="otp" id="otp" placeholder="Enter OTP Sent on king@gmail.com">
					</div>
					<button type="button"><i class="fa fa-check-circle"></i> Verify OTP</button>
				</div>
				<div class="input-row third-step">
					<div class="field-box">
						<p>Choose Password</p>
						<input type="text" name="new-password" id="new-password" placeholder="Choose a New Password">
					</div>
					<button type="button"><i class="fa fa-check-circle"></i> Change Password</button>
				</div>
			</form>
		</div>
	</div>
	<?php
		require "commons/loader.php";
		require "commons/message.php";
	?>
	<script>
		$(document).ready(function(){
			$("#login-form").submit(function(e){
				e.preventDefault();
				var login_email=$("#login-email").val();
				var login_password=$("#login-password").val();

				if(login_email=="")
				{
					if(login_password=="")
					{
						errorMsg("Enter Email and Password");
					}
					else
					{
						errorMsg("Enter Registered Email ID");
					}
				}
				else
				{
					if(login_password=="")
					{
						errorMsg("Please Enter Password")
					}
					else
					{
						$.ajax({
							url : "php/login.php",
							type : "POST",
							data : {login_email,login_password},
							beforeSend : function()
							{
								showLoader();
							},
							success : function(response)
							{
								if(response.trim()=="done")
								{
									successMsg("Login Success : Please Wait");
									setTimeout(function(){
										location.href="admin/index.php";
									},2000);
								}
								else
								{
									errorMsg(response);
									hideLoader();
								}
							}
						});
					}
				}
			});

			$(".forgot-link span").click(function(){
				$(".login-form-box").slideUp(400,function(){
					$(".forgot-form-box").slideDown(400);
				});
			});

			$(".first-step button").click(function(){
				var email_id=$("#forgot-email").val();
				if(email_id.trim()=="")
				{
					errorMsg("Please Enter Email ID");
				}
				else
				{
					$.ajax({
						url : "php/send-verification-email.php",
						type : "POST",
						data : {email_id,for:"forgot"},
						beforeSend : function(){
							showLoader();
						},
						success : function(response)
						{
							if(response.trim()=="done")
							{
								successMsg("Mail Sent Successfully");
								$("#otp").attr("placeholder","Enter OTP Sent on "+email_id);
								$(".first-step").slideUp(400,function(){
									$(".second-step").slideDown(400);
								});
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

			$(".second-step button").click(function(){
				var otp=$("#otp").val();
				var email=$("#forgot-email").val();

				if(otp=="")
				{
					errorMsg("Please Enter OTP Here");
				}
				else
				{
					$.ajax({
						url : "php/verify-otp.php",
						type : "POST",
						data : {email,otp},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							if(response.trim()=="done")
							{
								successMsg("Login Success : Please Wait");
								setTimeout(function(){
									location.href="admin/index.php";
								},2000);
							}
							else
							{
								errorMsg(response);
								hideLoader();
							}
						}
					});
				}
			});
		});
	</script>
</body>
</html>
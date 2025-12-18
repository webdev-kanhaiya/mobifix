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
		<div class="header">
			<a href="index.php"><i class="fa fa-arrow-left"></i></a>
			<div class="header-content">
				<h1>Edit Repairing Order Details</h1>
				<img src="https://niceillustrations.com/wp-content/uploads/2020/10/hand-holding-phone.png">
			</div>
		</div>
		<form class="form-box" id="form">
			<input type="hidden" name="order-id" value="<?php echo $order_id; ?>" id="order-id">
			<input type="hidden" name="hidden-mobile" value="<?php echo $data['customer_mobile']; ?>">
			<div class="customer-details">
				<h4>Customer Details</h4>
				<div class="field-box">
					<input type="number" disabled="disabled" name="customer-mobile" id="customer-mobile" placeholder="Mobile Number" value="<?php echo $data['customer_mobile']; ?>">
					<ul class="suggestions">
						
					</ul>
				</div>
				<div class="field-box">
					<input type="text" name="customer-name" disabled="disabled" id="customer-name" placeholder="Customer Name" value="<?php echo $data['customer_name']; ?>">
				</div>
				<div class="field-box">
					<input type="text" disabled="disabled" name="customer-address" id="customer-address" placeholder="Customer Address (Optional)" value="<?php echo $data['customer_address']; ?>">
				</div>
			</div>
			<div class="mobile-details">
				<h4 class="mobile-info-heading">Mobile Information</h4>
				<div class="field-box">
					<input type="text" name="model" id="model" placeholder="Mobile Model" value="<?php echo $data['mobile_model']; ?>">
				</div>
				<div class="problems-wrapper">
					<div class="problem-box" style="display: flex;">
						<?php
							$problem_array=explode(",",$data['problems']);
							foreach($problem_array as $problem)
							{
								echo '<p class="problem-label" problem="'.$problem.'"><span>'.$problem.'</span><i class="fa fa-close"></i></p>';
							}
						?>
					</div>
					<div class="problem-input-box">
						<input type="text" name="problem" id="problem-input" placeholder="Enter Problems Here">
						<button type="button" id="add-problem">+</button>
					</div>
				</div>
				<div class="input-row-half">
					<input type="number" name="final-amount" id="final-amount" placeholder="Amount of Order" value="<?php echo $data['amount']; ?>">
					<input type="number" name="paid-amount" id="paid-amount" placeholder="Paid Amount (Optional)" value="<?php echo $data['paid']; ?>">
				</div>
				<div class="input-row-half">
					<input type="text" name="text-password" id="text-password" placeholder="Text Password" value="<?php echo $data['text_password']; ?>">
					<button type="button" id="pattern-btn"><i class="fa fa-key"></i> Pattern Lock</button>
				</div>
				<!-- <button id="picture" type="button">
					<i class="fa fa-camera"></i>
					<p>Take Picture of Mobile's Condition</p>
				</button> -->
				<div class="file-upload-box">
					<input type="file" id="file-upload" accept=".jpg,.jpeg,.png,.webp" name="file-upload">
					<?php
						$image=$data['image'];
						if($image==NULL)
						{
							echo '<i class="fa fa-cloud-upload"></i><div class="preview-box"></div>';
						}
						else
						{
							echo '<div class="preview-box">
									<img src="../images/uploads/mobile-images/'.$image.'">
								</div>';
						}
					?>
					<h3>Upload Mobile Pictures</h3>
					<p>Click Here to Upload Before Image of Mobile</p>
				</div>
				<div class="field-box">
					<textarea name="additional-details" id="additional-details" placeholder="Additional Details (Example : Call The Customer to a Particular Mobile Number)"><?php echo $data['addition_details']; ?></textarea>
				</div>
				<button type="submit" id="submit-btn"><i class="fa fa-edit"></i> Edit This Order</button>
			</div>
		</form>
	</div>
	<?php
		require "../commons/loader.php";
		require "../commons/message.php";
	?>
	<script>
		$(document).ready(function(){
			$("#add-problem").click(function(){
				var problem_input=$("#problem-input");
				if(problem_input.val()=="")
				{
					problem_input.css("border-color","red");
					errorMsg("Field is Empty!");
				}
				else
				{
					problem_input.css("border-color","#ccc");
					$(".problem-box").css("display","flex").prepend('<p class="problem-label" problem="'+problem_input.val()+'"><span>'+problem_input.val()+'</span><i class="fa fa-close"></i></p>');
					problem_input.val("").focus();
				}
			});

			$(document).on("click",".problem-label i",function(){
				$(this).parent().fadeOut(300,function(){
					$(this).remove();
				});
			});

			/*$("#customer-mobile").blur(function(){
				$(".suggestions").slideUp(200);
			});*/

			$("#customer-mobile").on("input",function(){
				var mobile=$(this).val();
				if(mobile=="")
				{
					$(".suggestions").slideUp(200);
				}
				else
				{
					$.ajax({
						url : "php/get-customer-info.php",
						type : "POST",
						data : {mobile:mobile},
						success : function(data)
						{
							if(data.trim()=="no data found")
							{
								$(".suggestions").slideUp(200);
							}
							else
							{
								$(".suggestions").html(data).slideDown(200);
							}
						}
					});
				}
			});

			$(document).on("click",".suggestions li",function(){
				var customer_name=$(this).attr("cname");
				var customer_address=$(this).attr("caddress");
				var customer_mobile=$(this).attr("cmobile");
				$("#customer-mobile").val(customer_mobile);
				$("#customer-name").val(customer_name).attr("readonly","readonly");
				if(customer_address=="")
				{
					$("#customer-address").val(customer_address).removeAttr("readonly");
				}
				else
				{
					$("#customer-address").val(customer_address).attr("readonly","readonly");
				}
				$(".suggestions").slideUp(200);
			});

			$("#pattern-btn").click(function(){
				alert("Feature is Coming Soon");
			});

			$("#file-upload").change(function(){
				var file=this.files[0];
				if(file)
				{
					var reader=new FileReader();
					reader.onload=function(e)
					{
						var preview_image="<img src='"+(e.target.result)+"' width='100px'>"
						$(".preview-box").html(preview_image);
						$(".file-upload-box i").hide();
					}
					reader.readAsDataURL(file);
				}
				else
				{
					$(".file-upload-box i").show();
					$(".preview-box").html("");
				}
			});

			$("#form").submit(function(e){
				e.preventDefault();
				var customer_name=$("#customer-name").val();
				var customer_mobile=$("#customer-mobile").val();
				var customer_address=$("#customer-address").val();
				var model=$("#model").val();
				var final_amount=$("#final_amount").val();
				var paid_amount=$("#paid_amount").val();
				var text_password=$("#text-password").val();
				var additional_details=$("#additional-details").val();

				var problems="";
				var i;
				for(i=0;i<$(".problem-box p").length;i++)
				{
					if(i==($(".problem-box p").length-1))
					{
						problems+=$(".problem-box p:eq("+i+")").attr("problem");	
					}
					else
					{
						problems+=$(".problem-box p:eq("+i+")").attr("problem")+",";
					}
				}

				if(customer_name=="" || customer_mobile=="" || model=="" || final_amount=="")
				{
					errorMsg("Please Fill All The Required Fields");
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
					if(problems=="")
					{
						errorMsg("Please Add Atleast 1 Problem");
					}
					else
					{
						var formData = new FormData(this);
						formData.append("problems", problems);
						$.ajax({
							url : "php/edit-order.php",
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
								if(response.trim()=="done")
								{
									$(".file-upload-box i").show();
									$(".preview-box").html("");
									$(".problem-box").html("");
									$("#form").trigger('reset');
									successMsg("Order Edited Successfully");
								}
								else
								{
									errorMsg(response);
								}
							}
						});
					}
				}
			});
		});
	</script>
</body>
</html>
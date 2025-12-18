<?php
	require "../../php/config.php";
	session_start();

	$admin=$_SESSION['admin_email'];
	$query="SELECT * FROM userdata WHERE email='$admin'";
	$result=mysqli_query($conn,$query) or die("Query Failed");

	if($result->num_rows==1)
	{
		$data=mysqli_fetch_assoc($result);
	}
	else
	{
		die("Something Went Wrong");
	}
?>
<style>
	.details-box{
		width: 100%;
		max-width: 500px;
		margin: 10px auto;
	}

	.details-box h3{
		font-weight: 600;
		font-size: 1.7rem;
		color: var(--primary-color);
		font-family: var(--heading-font);
		margin-bottom: 20px;
		text-align: center;
	}

	.field-box{
		margin-top: 15px;
	}

	.field-box p{
		font-weight: 500;
		font-size: 1rem;
		margin-bottom: 5px;
		margin-left: 10px;
		color: #404040;
	}

	.field-box input{
		width: 100%;
		height: 45px;
		border: 1px solid #ccc;
		padding: 0px 10px;
		font-weight: 500;
		font-size: 0.95rem;
		outline-color: var(--primary-color);
		border-radius: 5px;
	}

	#shop-address{
		height: 100px;
		width: 100%;
		border: 1px solid #ccc;
		outline-color: var(--primary-color);
		border-radius: 5px;
		padding: 10px;
	}

	.upload-box{
		height: 120px;
		width: 120px;
		border: 5px solid #eee;
		border-radius: 50%;
		position: relative;
		margin: 0px auto;
		overflow: hidden;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.upload-box input{
		height: 100%;
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
		cursor: pointer;
		z-index: 1111;
	}

	.upload-box .design-box{
		height: auto;
		width: 100%;
		background-color: rgba(0, 0, 0 , 0.2);
		padding: 5px;
		text-align: center;
		position: absolute;
	}

	.upload-box .design-box i{
		color: white;
		font-size: 1.7rem;
	}

	.upload-box img{
		max-height: 100%;
		max-width: 100%;
	}

	#change-details-form button{
		padding: 15px;
		border: none;
		border-radius: 5px;
		background-color: var(--primary-color);
		color: white;
		font-weight: 600;
		width: 100%;
		margin-top: 25px;
		cursor: pointer;
	}
</style>
<div class="details-box">
	<h3>Update Details</h3>
	<form id="change-details-form">
		<div class="upload-box">
			<?php
				if($data['shop_logo']==NULL)
				{
					$image="../images/no-image.png";
				}
				else
				{
					$uploaded_image=$data['shop_logo'];
					$image="../images/uploads/shop-logos/$uploaded_image";
				}
			?>
			<img src="<?php echo $image; ?>">
			<input type="file" name="shop-logo" id="shop-logo" accept=".jpg,.jpeg,.png,.webp">
			<div class="design-box">
				<i class="fa fa-camera"></i>
			</div>
		</div>
		<div class="field-box">
			<p>Shop Name</p>
			<input type="text" name="shop-name" id="shop-name" placeholder="Your Shop Name" mandate="yes" value="<?php echo $data['shop_name']; ?>">
		</div>
		<div class="field-box">
			<p>Owner Name</p>
			<input type="text" name="owner-name" id="owner-name" placeholder="Shop Owner Name" mandate="yes" value="<?php echo $data['owner_name']; ?>">
		</div>
		<div class="field-box">
			<p>Mobile Number</p>
			<input type="number" name="mobile-number" id="mobile-number" placeholder="Shop Mobile Number" mandate="yes" value="<?php echo $data['mobile_number']; ?>">
		</div>
		<div class="field-box">
			<p>Shop Address</p>
			<textarea id="shop-address" name="shop-address" mandate="yes" placeholder="Your Shop Address"><?php echo $data['shop_address']; ?></textarea>
		</div>
		<div class="field-box">
			<p>GST Number (optional)</p>
			<input type="text" value="<?php echo $data['gstin']; ?>" name="gstin" id="gstin" placeholder="Your GST Number">
		</div>
		<button><i class="fa fa-edit"></i> Update Details</button>
	</form>
</div>
<script>
	$(document).ready(function(){
		var image="<?php echo $image; ?>"
		$("#change-details-form").submit(function(e){
			e.preventDefault();
			var shop_name=$("#shop-name").val();
			var owner_name=$("#owner-name").val();
			var mobile_number=$("#mobile-number").val();
			var shop_address=$("#shop-address").val();
			var gstin=$("#gstin").val();

			if(shop_name=="" || owner_name=="" || mobile_number=="" || shop_address=="")
			{
				var i;
				for(i=0;i<$("[mandate=yes]").length;i++)
				{
					if($("[mandate=yes]:eq("+i+")").val()=="")
					{
						$("[mandate=yes]:eq("+i+")").css("border-color","red");
						errorMsg("Please Fill Mandatory Fields");
					}
					else
					{
						$("[mandate=yes]:eq("+i+")").css("border-color","#ccc");
					}
				}
			}
			else
			{
				$("[mandate=yes]").css("border-color","#ccc");
				var formData=new FormData(this);
				$.ajax({
					url : "php/update-details.php",
					type : "POST",
					data : formData,
					processData : false,
					contentType : false,
					beforeSend : function()
					{
						showLoader();
					},
					success : function(response)
					{
						hideLoader();
						if(response.trim()=="done")
						{
							successMsg("Details Updated Successfully");
							setTimeout(function(){
								location.reload();
							},2000);
						}
						else
						{
							errorMsg(response);
						}
					}
				});
			}
		});

		$("#shop-logo").change(function(){
			var file=this.files[0];
			if(file)
			{
				var reader=new FileReader();
				reader.onload=function(e)
				{
					$(".upload-box img").attr("src",e.target.result);
				}
				reader.readAsDataURL(file);
			}
			else
			{
				$(".upload-box img").attr("src",image);
			}
		});
	});
</script>
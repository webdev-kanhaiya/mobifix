<style>
	.topbar{
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 15px;
		background-color: white;
		border: 1px solid #ccc;
	}

	.logo{
		width: 120px;
		cursor: pointer;
	}

	.right-topbar{
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.profile-img{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		background-color: var(--primary-color);
		display: flex;
		justify-content: center;
		align-items: center;
		cursor: pointer;
		position: relative;
		margin-left: 10px;
		overflow: hidden;
	}

	.letter{
		font-size: 1.3rem;
		color: white;
		font-weight: 600;
	}

	.setting{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		background-color: rgba(69, 0, 183, 0.11);
		text-align: center;
		font-size: 1.3rem;
		padding-top: 12px;
		color: var(--primary-color);
	}

	.profile-img img{
		width: 100%;
		height: 100%;
	}

	.topbar h1{
		font-size: 1.5rem;
		font-weight: 600;
		color: grey;
	}

	@media(min-width:576px)
	{
		.setting{
			padding-top: 12px;
		}
	}

	@media(max-width: 700px)
	{
		.topbar h1{
			font-size: 1.2rem;
		}
	}

	@media(max-width: 576px)
	{
		.topbar h1{
			display: none;
		}
	}
</style>
<?php
	require "../php/config.php";
	$userdata_query="SELECT * FROM userdata WHERE email='$admin_email'";
	$userdata_result=mysqli_query($conn,$userdata_query) or die("Query Failed");

	if($userdata_result->num_rows==1)
	{
		$userdata=mysqli_fetch_assoc($userdata_result);
		if($userdata['shop_logo']=="")
		{
			$logo="no";
		}
		else
		{
			$logo=$userdata['shop_logo'];
		}
	}
	else
	{
		die("Something Went Wrong");
	}
?>
<div class="topbar">
	<img src="../images/logos/mobifix-purple.png" class="logo">
	<h1>Welcome, <?php echo $shop_name; ?></h1>
	<div class="right-topbar">
		<a href="settings.php"><i class="fa fa-cog setting"></i></a>
		<div class="profile-img">
			<?php
				if($logo=="no")
				{
					echo "<p class='letter'>".strtoupper(substr($userdata['shop_name'], 0,1))."</p>";
				}
				else
				{
					echo "<img src='../images/uploads/shop-logos/$logo'>";
				}
			?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".logo").click(function(){
			location.href="index.php";
		});
	});
</script>
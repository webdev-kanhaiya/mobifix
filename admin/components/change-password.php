<style>
	.change-password-box{
		max-width: 500px;
		margin: 10px auto;
	}

	.change-password-box h3{
		font-weight: 600;
		font-size: 1.7rem;
		color: var(--primary-color);
		font-family: var(--heading-font);
		margin-bottom: 30px;
		text-align: center;
	}

	.change-password-box input{
		margin-bottom: 20px;
		height: 45px;
		width: 100%;
		border: 1px solid #ccc;
		padding: 0px 10px;
		font-weight: 500;
		font-size: 0.95rem;
		outline-color: var(--primary-color);
		border-radius: 5px;
	}

	#change-password-btn{
		padding: 15px;
		border: none;
		border-radius: 5px;
		background-color: var(--primary-color);
		color: white;
		font-weight: 600;
		width: 100%;
		margin-top: 10px;
		cursor: pointer;
	}
</style>
<div class="change-password-box">
	<h3>Change Your Password</h3>
	<input type="text" id="old-password" placeholder="Enter Existing Password">
	<input type="text" id="new-password" placeholder="Choose New Password">
	<input type="text" id="confirm-password" placeholder="Confirm New Password">
	<button id="change-password-btn"><i class="fa fa-key"></i> Change Password</button>
</div>
<script>
	$(document).ready(function(){
		$("#change-password-btn").click(function(){
			var old_password=$("#old-password").val();
			var new_password=$("#new-password").val();
			var confirm_password=$("#confirm-password").val();

			if(old_password=="" || new_password=="" || confirm_password=="")
			{
				errorMsg("All Fields are Required");
				var i;
				for(i=0;i<$(".change-password-box input").length;i++)
				{
					if($(".change-password-box input:eq("+i+")").val()=="")
					{
						$(".change-password-box input:eq("+i+")").css("border-color","red");
					}
					else
					{
						$(".change-password-box input:eq("+i+")").css("border-color","#ccc");
					}
				}
			}
			else
			{
				$(".change-password-box input").css("border-color","#ccc");
				if(new_password==confirm_password)
				{
					$.ajax({
						url : "php/change-password.php",
						type : "POST",
						data : {old_password,new_password},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							hideLoader();
							if(response.trim()=="done")
							{
								$("input").val("");
								successMsg("Password Changed Successfully");
							}
							else
							{
								errorMsg(response);
							}
						}
					});
				}
				else
				{
					errorMsg("New Password is Not Matching");
				}
			}
		});
	});
</script>
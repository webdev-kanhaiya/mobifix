<style>
	.feedback-box{
		display: flex;
		justify-content: center;
		align-items: center;
		flex-direction: column;
		width: fit-content;
		margin: 0 auto;
	}

	.feedback-box h3{
		font-weight: 600;
		color: var(--primary-color);
		font-size: 1.5rem;
		margin-bottom: 25px;
		text-align: center;
	}

	.stars i{
		color: #ddd;
		font-size: 3rem;
		cursor: pointer;
	}

	.feedback-box h4{
		font-weight: 500;
		color: grey;
		margin-top: 30px;
		text-align: center;
	}

	.thoughts-box{
		margin-top: 25px;
		width: 100%;
	}

	.thoughts-box textarea{
		width: 100%;
		height: 150px;
		border: 1px solid #ccc;
		border-radius: 5px;
		outline-color: var(--primary-color);
		padding:10px;
	}

	.submit-feedback{
		padding: 15px;
		border: none;
		border-radius: 5px;
		background-color: var(--primary-color);
		color: white;
		font-weight: 600;
		width: 100%;
		margin-top: 15px;
		cursor: pointer;
	}
</style>
<div class="feedback-box">
	<h3>Rate Mobifix or Suggest us New Features</h3>
	<div class="stars">
		<i class="fa fa-star" star="1"></i>
		<i class="fa fa-star" star="2"></i>
		<i class="fa fa-star" star="3"></i>
		<i class="fa fa-star" star="4"></i>
		<i class="fa fa-star" star="5"></i>
	</div>
	<h4>Your feedback is motivation for us to continue the services</h4>
	<div class="thoughts-box">
		<input type="hidden" name="stars-input" id="stars-input">
		<textarea id="thoughts" placeholder="Enter Thoughts or Suggestions"></textarea>
		<button class="submit-feedback"><i class="fa fa-check-circle"></i> Submit</button>
	</div>
</div>
<script>
	$(".fa-star").click(function(){
		var stars=$(this).attr("star");
		$(this).css("color","#F5CC4C");
		$(this).prevAll().css("color","#F5CC4C");
		$(this).nextAll().css("color","#ddd");
		$("#stars-input").val(stars);
	});

	$(".submit-feedback").click(function(){
		var stars=$("#stars-input").val();
		var thoughts=$("#thoughts").val();
		if(stars=="")
		{
			errorMsg("Please Tap on Stars to Rate!");
		}
		else
		{
			$.ajax({
				url : "php/feedback.php",
				type : "POST",
				data : {stars,thoughts},
				beforeSend : function()
				{
					showLoader();
				},
				success : function(response)
				{
					hideLoader();
					if(response.trim()=="done")
					{
						$("#thoughts,#stars-input").val("");
						$(".fa-star").css("color","#ddd");
						successMsg("Feedback Submitted");
					}
					else
					{
						errorMsg(response);
					}
				}
			});
		}
	});
</script>
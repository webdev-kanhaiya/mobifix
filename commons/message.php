<style>
	.message-box{
		position: fixed;
		top: 0px;
		left: 0px;
		display: none;
		justify-content: center;
		align-items: center;
		width: 100%;
		padding: 10px 20px;
		z-index: 1111111;
	}

	.message{
		width: fit-content;
		padding: 10px 20px;
		border-radius: 10px;
		font-size: 0.9rem;
		font-weight: 500;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.message i{
		margin-right: 7px;
		font-size: 1.3rem;
	}

	@media(max-width: 576px)
	{
		.message-box{
			height: auto;
			width: 100%;
			padding: 10px;
		}

		.message{
			width: 100%;
		}
	}
</style>
<div class="message-box">
	<div class="message"> All The Fields Are Mandatory</div>
</div>
<script>
	function hideMsgBox()
	{
		setTimeout(function(){
			$(".message-box").css("display","none");
		},4000);
	}

	function errorMsg(message)
	{
		$(".message").html('<i class="fa fa-warning"></i> '+message).css({
			"background-color":"#FDE4E4",
			"color":"#CA000C",
			"border":"1px solid #CA000C"
		});

		$(".message-box").css("display","flex");

		hideMsgBox();
	}

	function successMsg(message)
	{
		$(".message").html('<i class="fa fa-check-circle"></i> '+message).css({
			"background-color":"#F0FDF4",
			"color":"rgba(22, 101, 52, 1)",
			"border":"1px solid rgba(22, 101, 52, 1)"
		});

		$(".message-box").css("display","flex");

		hideMsgBox();
	}
</script>
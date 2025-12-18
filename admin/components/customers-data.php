<?php session_start(); ?>
<style>
	.customer-data-box{
		margin: 0px auto;
	}

	.customer-data-box h3{
		margin-top: 25px;
		font-weight: 600;
		font-size: 1.7rem;
		color: var(--primary-color);
		font-family: var(--heading-font);
		margin-bottom: 15px;
	}

	.table-box .c-edit-btn{
		background-color: rgba(0, 0, 220, 1.0);
		color: white;
	}

	.table-box .c-delete-btn{
		background-color: rgba(220, 0, 0, 1.0);
		color: white;
	}

	.customer-data-box h3{
		font-size: 1.5rem;
	}

	.pagination-box{
		margin-top: 32px;
	}

	.pagination{
		margin: 0;
	}
</style>
<div class="customer-data-box">
	<h3>Customers Data</h3>
	<div class="table-box">
		<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Name</th>
					<th>Mobile</th>
					<th>Address</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					require "../../php/config.php";

					$admin=$_SESSION['admin_email'];
					$query="SELECT * FROM customer WHERE admin='$admin' ORDER BY id DESC LIMIT 0,20";
					$result=mysqli_query($conn,$query) or die("Query Failed");

					if($result->num_rows==0)
					{
						echo "No Customer Added Yet";
					}
					else
					{
						for($i=1;$i<=$result->num_rows;$i++)
						{
							$data=mysqli_fetch_assoc($result);
							echo '<tr>
								<td>'.$data['name'].'</td>
								<td>'.$data['mobile'].'</td>
								<td>'.$data['address'].'</td>
								<td><button class="c-edit-btn" mobile="'.$data['mobile'].'" name="'.$data['name'].'" address="'.$data['address'].'" cid="'.$data['id'].'"><i class="fa fa-edit"></i> Edit</button></td>
								<td><button class="c-delete-btn" cid="'.$data['id'].'"><i class="fa fa-trash"></i> Delete</button></td>
							</tr>';
						}
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="pagination-box">
		<?php
			$total_query="SELECT COUNT(id) as total_rows FROM customer WHERE admin='$admin'";
			$total_result=mysqli_query($conn,$total_query) or die("Query Failed");
			$total_rows=mysqli_fetch_assoc($total_result)['total_rows'];

			if($total_rows>20)
			{
				$total_pages=ceil($total_rows/20);
				echo "<div class='pagination'>";
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i==1)
					{
						echo "<div class='pagination-link active' page='$i'>$i</div>";
					}
					else
					{
						echo "<div class='pagination-link' page='$i'>$i</div>";
					}
				}
				echo "</div>";
			}
		?>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(document).on("click",".c-delete-btn",function(){
			var cid=$(this).attr("cid");
			var tr=$(this).parents("tr");
			if(cid=="")
			{
				errorMsg("Something Went Wrong");
				location.reload();
			}
			else
			{
				if(confirm("Do you really want to delete this customer ??"))
				{
					$.ajax({
						url : "php/delete-customer.php",
						type : "POST",
						data : {cid},
						beforeSend : function()
						{
							showLoader();
						},
						success : function(response)
						{
							hideLoader();
							if(response.trim()=="done")
							{
								tr.slideUp(400);
								successMsg("Customer Deleted Successfully");
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

		$(document).on("click",".pagination-link",function(){
			var page=$(this).attr("page");

			$(".pagination-link").removeClass("active");
			$(this).addClass("active");
			$.ajax({
				url : "php/table-customer-data.php",
				type : "POST",
				data : {page},
				beforeSend : function()
				{
					showLoader();
				},
				success : function(response)
				{
					$(".customer-data-box table tbody").html(response);
					hideLoader();
				}
			});
		});
	});
</script>
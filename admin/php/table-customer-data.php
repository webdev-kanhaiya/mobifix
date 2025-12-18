<?php
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		session_start();
		require "../../php/config.php";

		$admin=$_SESSION['admin_email'];
		$page=mysqli_real_escape_string($conn,$_POST['page']);
		$limit=20;
		$offset=($page-1)*$limit;
		$query="SELECT * FROM customer WHERE admin='$admin' ORDER BY id DESC LIMIT $offset,$limit";
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
					<td><button class="c-edit-btn" cid="'.$data['id'].'"><i class="fa fa-edit"></i> Edit</button></td>
					<td><button class="c-delete-btn" cid="'.$data['id'].'"><i class="fa fa-trash"></i> Delete</button></td>
				</tr>';
			}
		}
	}
	else
	{
		echo "Access Denied";
	}
?>
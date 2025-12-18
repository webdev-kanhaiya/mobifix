<?php
	require "../../php/config.php";
	session_start();
	$admin=$_SESSION['admin_email'];

	
	$customer_type_query = "SELECT 
        SUM(CASE WHEN total_orders = 1 THEN 1 ELSE 0 END) AS total_new_customers,
        SUM(CASE WHEN total_orders > 1 THEN 1 ELSE 0 END) AS total_repeated_customers
    FROM (
        SELECT customer_mobile, COUNT(*) AS total_orders
        FROM orders
        WHERE admin = '$admin'
        GROUP BY customer_mobile
    ) AS sub";

    $customer_type_result=mysqli_query($conn,$customer_type_query) or die("Query Failed");
    $customer_type_data=mysqli_fetch_assoc($customer_type_result);
    $total_new_customers=$customer_type_data['total_new_customers'];
    $total_repeated_customers=$customer_type_data['total_repeated_customers'];

    $last_orders_query="WITH RECURSIVE date_range AS (
	    SELECT CURDATE() - INTERVAL 6 DAY AS dt
	    UNION ALL
	    SELECT dt + INTERVAL 1 DAY
	    FROM date_range
	    WHERE dt + INTERVAL 1 DAY <= CURDATE()
	)
	SELECT 
	    date_range.dt AS order_date,
	    COALESCE(o.total_orders, 0) AS total_orders
	FROM date_range
	LEFT JOIN (
	    SELECT DATE(timing) AS order_date, COUNT(*) AS total_orders
	    FROM orders
	    WHERE timing >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND admin='$admin'
	    GROUP BY DATE(timing)
	) o 
	ON date_range.dt = o.order_date
	ORDER BY date_range.dt;
	";
    $last_orders_result=mysqli_query($conn,$last_orders_query) or die("Last Orders Query Failed");

    $dates=[];
    $orders=[];
    for($i=1;$i<=$last_orders_result->num_rows;$i++)
    {
    	$last_orders_data=mysqli_fetch_assoc($last_orders_result);
    	$dates[]=$last_orders_data['order_date'];
    	$orders[]=$last_orders_data['total_orders'];
    }

    $js_dates=json_encode($dates);
    $js_orders=json_encode($orders);

    $status_query="SELECT s.status, 
           COALESCE(COUNT(o.id), 0) AS total_orders
    FROM (
        SELECT 'pending'   AS status
        UNION ALL
        SELECT 'repaired'
        UNION ALL
        SELECT 'delivered'
        UNION ALL
        SELECT 'cancelled'
    ) AS s
    LEFT JOIN orders o 
        ON o.status = s.status
       AND admin='$admin'
    GROUP BY s.status";

    $status_result=mysqli_query($conn,$status_query) or die("Status Query Failed");
    $status=[];
    $status_orders=[];
    for($j=1;$j<=$status_result->num_rows;$j++)
    {
 		$status_data=mysqli_fetch_assoc($status_result);
 		$status[]=$status_data['status'];
 		$status_orders[]=$status_data['total_orders'];
    }

    $js_status=json_encode($status);
    $js_status_orders=json_encode($status_orders);
?>
<div class="orders-box chart-box first">
	<h2>Orders Analytics</h2>
	<p>Last 7 Days Range</p>
	<canvas style="margin-top:20px;" id="orders"></canvas>
</div>
<div class="repeated-customer-box chart-box second">
	<h2>Customers Analytics</h2>
	<p>Showing Data as Lifetime</p>
	<canvas style="margin-top:15px;" id="repeated-customer"></canvas>
</div>
<div class="status-box chart-box third">
	<h2>Repairing Status Analytics</h2>
	<p>Showing Data as Lifetime</p>
	<canvas style="margin-top:15px;" id="status"></canvas>
</div>
<script>
	function ordersChart()
	{

		var context=document.getElementById('orders');
		new Chart(context , {
			type : "line",
			data : {
				labels : <?php echo $js_dates; ?>,
				datasets : [{
					label : "Orders Received",
					data : <?php echo $js_orders; ?>,
					backgroundColor : "rgba(69,0,183,1)"
				}],
			},
			options : {
				scales : {
					y : {
						beginAtZero : true
					}
				}
			}
		});
	}
	ordersChart();

	function repeatedCustomer()
	{
		var context=document.getElementById('repeated-customer');

		new Chart(context , {
			type : "doughnut",
			data : {
				labels : ['Repeated Customers','New Customers'],
				datasets : [{
					label : "Total",
					data : [<?php echo $total_new_customers ?>,<?php echo $total_repeated_customers ?>],
					backgroundColor : ["#0078ff","rgba(69,0,183,1)"]
				}],
			},
			options : {
				scales : {
					y : {
						beginAtZero : true
					}
				}
			}
		});
	}
	repeatedCustomer();

	function repairingStatus()
	{
		var context=document.getElementById('status');

		new Chart(context , {
			type : "polarArea",
			data : {
				labels : <?php echo $js_status; ?>,
				datasets : [{
					label : "Total Orders",
					data : <?php echo $js_status_orders; ?>,
					backgroundColor : ["#C9010E","rgba(69,0,183,1)","#F6511D","#00A6ED"]
				}],
			},
			options : {
				scales : {
					y : {
						beginAtZero : true
					}
				}
			}
		});
	}
	repairingStatus();
</script>
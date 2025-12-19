<?php
	if(strtolower(basename($_SERVER['PHP_SELF']))=="index.php")
	{
		$title="Mobifix : A Complete Mobile Repairing Shop Management Portal";
		$stylesheet="style.css";
		$description="Mobifix is a 100% free mobile repair shop management portal designed to simplify your workflow. Effortlessly add customers, track their repair history, manage order statuses, and generate professional invoices—all in one place. Streamline your mobile repair business and save time with Mobifix.";
		$keywords="mobifix, mobifix.store, mobifix store, mobifix mobile shop, mobifix shop, mobile repair shop management, mobile repair software, repair shop management portal, free mobile repair software, customer management for repair shops, track repair history, manage orders status, generate invoices online, mobile repair business tools, mobile shop workflow management, free mobile repair shop management portal, software to manage mobile repair orders, mobile repair customer tracking software, easy invoicing for mobile repair shops, mobile repair shop workflow automation";
	}
	else if(strtolower(basename($_SERVER['PHP_SELF']))=="register.php")
	{
		$title="Register Your Shop";
		$stylesheet="register.css";
		$description="Create your free Mobifix account to manage your mobile repair shop easily. Add customers, track repair orders, manage status, and generate invoices from one dashboard.";
		$keywords="mobifix, mobifix.store, mobifix store, mobifix mobile shop, mobifix shop, mobifix login, mobifix register, mobifix signup, mobile repair software registration, free mobile repair shop account, repair shop management signup, mobile repair portal register, create mobile repair account, repair shop software signup, mobile repair business registration";
	}
	else if(strtolower(basename($_SERVER['PHP_SELF']))=="login.php")
	{
		$title="Login : Mobifix";
		$stylesheet="login.css";
		$description="Securely log in to your Mobifix account and continue managing your work without interruption. Fast, safe, and reliable access to your dashboard.";
		$keywords="mobifix login, mobifix signin, mobifix sign in, mobifix signup, mobile repair software login, repair shop management login, mobile repair portal login, access mobifix account, repair shop dashboard login, mobile repair business login";
	}
?>
<meta charset="utf-8">
<meta name="description" content="<?php echo $description; ?>">
<meta name="keywords" content="<?php echo $keywords; ?>">
<meta name="author" content="Molexy : Kanhaiya Lal Gupta">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="stylesheets/common.css">
<link rel="stylesheet" type="text/css" href="stylesheets/<?php echo $stylesheet; ?>">
<link rel='icon' href="images/favicon.jpg">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
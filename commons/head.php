<?php
	if(strtolower(basename($_SERVER['PHP_SELF']))=="index.php")
	{
		$title="Mobifix : Home";
		$stylesheet="style.css";
		$description="Later";
		$keywords="Later";
	}
	else if(strtolower(basename($_SERVER['PHP_SELF']))=="register.php")
	{
		$title="Register Your Shop";
		$stylesheet="register.css";
		$description="Later";
		$keywords="Later";
	}
	else if(strtolower(basename($_SERVER['PHP_SELF']))=="login.php")
	{
		$title="Login : Mobifix";
		$stylesheet="login.css";
		$description="Later";
		$keywords="Later";
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
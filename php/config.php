<?php
	if($_SERVER['HTTP_HOST']==="localhost")
	{
		define("BASE_URL","http://localhost/server/mobifix/");
		define("DB_HOST","localhost");
		define("DB_USER","root");
		define("DB_PASS","1234");
		define("DB_NAME","molexy");
		define("SMTP_SERVER","smtp.google.com");
		define("EMAIL_ID","webdev.kanhaiya@gmail.com");
		define("EMAIL_PASS","odac pygz wqqz mgdy");

	}
	else
	{
		define("BASE_URL","https://".$_SERVER['HTTP_HOST']."/");
		define("DB_HOST","localhost");
		define("DB_USER","folkawym_kanhaiya");
		define("DB_PASS","Kanhaiya@1234");
		define("DB_NAME","folkawym_mobifix");
		define("SMTP_SERVER","mail.mobifix.store");
		define("EMAIL_ID","no-reply@mobifix.store");
		define("EMAIL_PASS","Kanhaiya@1234");
	}

	$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die("DB Connection Failed");
?>

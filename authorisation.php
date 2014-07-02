<head>
<link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<div id="header">
<?php
include "db.php";  //connecting to data base
session_start();
if (!isset($_SESSION['user']))
{
	if (isset($_POST['submit']))// if we're logging in
	{
	 
		 $stmt = $db->query("SELECT user_name, password FROM users WHERE user_name='".$_POST['login']."'");
		 $user=$stmt->fetch(PDO::FETCH_ASSOC);
		 if(($user['password'] === $_POST['pass']) && ($user['user_name'] === $_POST['login']))
		 {
			$_SESSION['user']=$user['user_name'];
			echo "Welcome, ".$_SESSION['user'];
		 	include "welcome.php";
		 }
		 else
		 {
			 include "check.php";
		 	echo "Wrong user name/password";
	 	 }
	}
	else 
	{
		include "check.php";
	}
}
else
{
	echo "Welcome, ".$_SESSION['user']." ";
	include "welcome.php";
}
?>
</div>

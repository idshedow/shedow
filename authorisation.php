<head>
<link href="shedow_style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
</head>
<div id="header">
<?php
include "db.php";  //connecting to data base
if(!($db)) // if no connect, error and exit()
{
	echo "Unable to connect to data base server";
	exit();
}
session_start();
//  ***********  LANGUAGE CHOOSING  ******************
if (isset($_GET['lang']))
{
	$lang = $_GET['lang'];
	$_SESSION['lang'] = $lang;
}
else if (isset($_SESSION['lang']))
{
	$lang = $_SESSION['lang'];
}
else 
	{
		$lang = 'en';
		$_SESSION['lang'] = $lang;
	}
// including right language file
if ($lang == 'en')
	$lang_file = 'lang_en.php';
else
	$lang_file = 'lang_ua.php';
include_once $lang_file;
?>
<span id='flags'>
<a href='index.php?lang=en'><img src='images/uk.gif'></a> 
&#x00a0; &#x00a0;
<a href='index.php?lang=ua'><img src='images/ua.gif'></a><br>
</span>
<?php
//  **********  AUTHORIZATION  **********************
if (!isset($_SESSION['user'])) // if we're not authorized
{
	if (isset($_POST['submit']))// if we're logging in
	{
	 	// looking the user with the same user_name
		$stmt = $db->query("SELECT user_name, user_password, user_role FROM users WHERE user_name='".$_POST['login']."'");
		$user=$stmt->fetch(PDO::FETCH_ASSOC);
		if(($user['user_password'] === md5($_POST['pass'])) && ($user['user_name'] === $_POST['login']))
		{
			// if success authorization:
			$_SESSION['user']=$user['user_name'];
			$_SESSION['user_role']=$user['user_role'];
			// User roles:
			// 4 - admin
			// 3 - moder
			// 2 - user
			// 1 - banned
			// authorization and updated last visit information:
			$visit=$db->prepare("UPDATE users SET user_last_visit= :visit WHERE user_name='".$_SESSION['user']."'");
			$visit->bindParam(':visit',date("d-m-Y H:i"));
			$visit->execute();
			if ($_SESSION['user_role'] == 1)
			{
				session_destroy();
				header("Location: index.php?ban=true");
			}
			else
			{
				echo "<span id='large_text'>".$language['welcome'].", ".$_SESSION['user']." <a href='profile.php?user=".$_SESSION['user']."'>".$language['profile']."</a></span>";
			 	include "welcome.php";
				if ($_SESSION['user_role'] == 4)
				{
					echo "<span id='admin'><a href='admin.php'>".$language['admin_menu']."</a></span>";
				}
			}
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
	if ($_SESSION['user_role']==1)
	{
		echo "You are banned!";
		include "welcome.php";
	}
	else
	{
		echo "<span id='large_text'>".$language['welcome'].", ".$_SESSION['user']." <a href='profile.php?user=".$_SESSION['user']."'>".$language['profile']."</a><span>";
		include "welcome.php";
		if ($_SESSION['user_role'] == 4)
		{
			echo "<span id='admin'><a href='admin.php'>".$language['admin_menu']."</a></span>";
		}
	}
}
?>
</div>

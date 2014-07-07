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
	$lang = 'en';
// including right language file
if ($lang == 'en')
	$lang_file = 'lang_en.php';
else
	$lang_file = 'lang_ua.php';
include_once $lang_file;
echo "<a href='index.php?lang=en'> ENG </a>"; 
echo "&#x00a0; &#x00a0;";
echo "<a href='index.php?lang=ua'> UA </a><br>";
//  **********  AUTHORIZATION  **********************
if (!isset($_SESSION['user'])) // if we're not authorized
{
	if (isset($_POST['submit']))// if we're logging in
	{
	 	
		$stmt = $db->query("SELECT user_name, user_password, user_role FROM users WHERE user_name='".$_POST['login']."'");
		$user=$stmt->fetch(PDO::FETCH_ASSOC);
		if(($user['user_password'] === $_POST['pass']) && ($user['user_name'] === $_POST['login']))
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
				echo $language['welcome'].", ".$_SESSION['user']." <a href='profile.php?user=".$_SESSION['user']."'>profile</a>";
			 	include "welcome.php";
				if ($_SESSION['user_role'] == 4)
				{
					echo "<a href='admin.php'>Admin menu</a>";
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
		echo $language['welcome'].", ".$_SESSION['user']." <a href='profile.php?user=".$_SESSION['user']."'>profile</a>";
		include "welcome.php";
		if ($_SESSION['user_role'] == 4)
		{
			echo "<a href='admin.php'>Admin menu</a>";
		}
	}
}
?>
</div>

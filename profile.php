<?php
include "authorisation.php";
//include "db.php";

/*if (!isset($_SESSION['user']))
{
	echo "not authorized";
}*/
if(isset($_SESSION['pass_changed']))
	{
		echo $_SESSION['pass_changed'];
		unset($_SESSION['pass_changed']);
	}
if(isset($_SESSION['e_mail_changed']))
	{
		echo $_SESSION['e_mail_changed'];
		unset($_SESSION['e_mail_changed']);
	}
$user_info = $db->query("SELECT * FROM users WHERE user_name='".$_GET['user']."'"); // open the page of user
$profile = $user_info->fetch(PDO::FETCH_ASSOC);
echo $profile['user_name']."<br>";
// user avatar, default if user has not it
if ($profile['user_avatar'])
	echo "<img src=".$profile['user_avatar']." width='150' height='150'><br>";
else
	echo "<img src='images/noavatar.png'><br>";
// user name if he has it
if (($profile['user_first_name']) or ($profile['user_last_name']))
	echo "User Name: ".$profile['user_first_name']." ".$profile['user_last_name'].";<br>";
// other information
if (isset($_SESSION['user']))
{
	echo "User E-mail: ".$profile['user_mail'].";<br>";
}
echo "User Registered: ".$profile['user_reg_date'].";<br>";
echo "Last Visited: ".$profile['user_last_visit'].";<br>";
echo "<br>";
//echo $_SESSION['user_role'];
if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role']>=2))
{
	if ((($_SESSION['user'])==($profile['user_name'])) or (($_SESSION['user_role']) == 4))
	{
		echo "<a href='edit_profile.php?user=".$profile['user_name']."'>Edit the Profile</a><br>";
	}
}
echo "<a href='index.php'>Back to Main Page</a>";
?>


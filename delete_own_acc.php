<?php
include "authorisation.php";
// user's page for deleting own account
if ((isset($_SESSION['user'])) and ($_SESSION['user'] == $_GET['user']))
{
	$user_name = trim($_SESSION['user']);
	echo "Are you sure you want to delete your profile from this site?<br>";
	echo "<form method='post'>";
	echo "<input type='submit' name='delete' value='Yes'>";
	echo "<input type='submit' name='cancel' value='No'>";
	echo "</form>";
	if (isset($_POST['delete']))
	{
		$db->exec("DELETE FROM users WHERE user_name='".$user_name."'");
		session_destroy();
		header("Location: index.php");
	}
	if (isset($_POST['cancel']))
		header("Location: profile.php?user=".$_SESSION['user']);
}
else
	header("Location: index.php");
?>

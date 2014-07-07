<?php
include "authorisation.php";
// admin page for deleting users
if ((isset($_SESSION['user_role'])) and (($_SESSION['user_role']) == 4))
{
	$user_name = trim($_GET['user']);
	echo "Are you sure you want to delete user ".$_GET['user']."?<br>";
	echo "<form method='post'>";
	echo "<input type='submit' name='delete' value='Yes'>";
	echo "<input type='submit' name='cancel' value='No'>";
	echo "</form>";
	if (isset($_POST['delete']))
	{
		$db->exec("DELETE FROM users WHERE user_name='".$user_name."'");
		header("Location: admin.php");
	}
	if (isset($_POST['cancel']))
		header("Location: admin.php");
}
else
	header("Location: index.php");
?>

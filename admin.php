<?php
include "authorisation.php";
if ($_SESSION['user_role'] == 4)
{
	echo "hello, admin<br><br>";
	// list of all registered users
	echo "<table>";
	$list = $db->query("SELECT * FROM users ORDER BY id");
	while ($user_list = $list->fetch(PDO::FETCH_ASSOC))
	{
		$number_in_list[] = $user_list['id'];
		echo "<tr><td>".$user_list['id']."</td><td>".$user_list['user_name']."</td><td><a href='profile.php?user=".$user_list['user_name']."'>Edit </a></td><td><a href=delete.php?user=".$user_list['user_name'].">Delete</a></td></tr>";
	}
	echo "</table><br>";
	echo "<a href='index.php'>Back to main menu</a>";
}
else
{
	echo "You have not administrator permission. You cannot be here.";
}
?>

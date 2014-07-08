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
	// translate editor:
	echo "Translate editor: <br>";
	$list = $db->query("SELECT * FROM translate ORDER BY id");
	echo "<table>";
	while($lang_list = $list->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr><td>{$lang_list['id']}</td><td>".$lang_list['en'].'</td><td>'.$lang_list['ua']."</td><td><a href='edit_translation.php?id=".$lang_list['id']."'>edit translation</a></td></tr>";
	}
	echo "</table>";
	echo "<a href='index.php'>Back to main page</a>";
}
else
{
	echo "You have not administrator permission. You cannot be here.";
}
?>

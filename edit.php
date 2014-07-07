<?php
include "authorisation.php";
if (isset($_SESSION['user']))
{
	if ($_SESSION['user_role'] >= 3)
	{
		echo "<form action=".$_SERVER['REQUEST_URI']." method='post'>";
		echo "<input type='text' name='header' size='40' value=".$_SESSION['article_header']."><br>";
		echo "<textarea name='article' cols='100' rows='20'>";
		echo $_SESSION['article_text']."</textarea><br>";
		echo "<input name='submit' type='submit' value='Save changes'>";
		echo "</form>";
	}
	else
	{
		echo "You have no permission to do this<br>";
		echo "<a href='index.php'>Back to main page</a>";
	}
}
else
	{
		echo "You cannot do it. Please authorize.<br>";
		echo "<a href='index.php'>Back to main page</a>";
	}
if (isset($_POST['submit']))
{
	$_SESSION['article_header']=strip_tags($_POST['header']);
	$_SESSION['article_text']=strip_tags($_POST['article']);
	$max = $db->query("SELECT id FROM link_list ORDER BY id DESC LIMIT 1");
	$max_id=$max->fetch(PDO::FETCH_ASSOC);  // get the max id value from link_list table do edit this record

	$edit = $db->prepare("UPDATE link_list SET list_link_header= :header, list_link_text= :text WHERE id=".$max_id['id']);
	$edit->bindParam(':header',$header);
	$edit->bindParam(':text',$text);
	$header = $_SESSION["article_header"];
	$text = $_SESSION["article_text"];
	$edit->execute();

	header("Location: view.php");
}
?>


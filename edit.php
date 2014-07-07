<?php
include "authorisation.php";
if (isset($_SESSION['user']))
{
	if ($_SESSION['user_role'] >= 3)
	{
		
		echo "<form action=".$_SERVER['REQUEST_URI']." method='post'>";
		echo "<table><tr><td>Here is an English version of article: <br>";
		echo "<input type='text' name='header' size='40' value=".$_SESSION['article_header']."></td><td>Here is a Ukrainian version of article: <br>";
		echo "<input type='text' name='header_ua' size='40' value=".$_SESSION['article_header_ua']."></td>";
		echo "</tr><tr><td>";
		echo "<textarea name='article' cols='100' rows='20'>";
		echo $_SESSION['article_text']."</textarea></td><td>";
		echo "<textarea name='article_ua' cols='100' rows='20'>";
		echo $_SESSION['article_text_ua']."</textarea></td>";
		echo "</tr></table>";
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
	$max = $db->query("SELECT id FROM link_list ORDER BY id DESC LIMIT 1");
	$max_id=$max->fetch(PDO::FETCH_ASSOC);  // get the max id value from link_list table do edit this record
	// english variables
	$_SESSION['article_header']=strip_tags($_POST['header']);
	$_SESSION['article_text']=strip_tags($_POST['article']);
	$header = $_SESSION['article_header'];
	$text = $_SESSION['article_text'];
	// ukrainian variables
	$_SESSION['article_header_ua']=strip_tags($_POST['header_ua']);
	$_SESSION['article_text_ua']=strip_tags($_POST['article_ua	']);
	$header_ua = $_SESSION['article_header_ua'];
	$text_ua = $_SESSION['article_text_ua'];

	$edit = $db->prepare("UPDATE link_list SET list_link_header= :header, list_link_text= :text, list_link_header_ua= :header_ua, list_link_text_ua= :text_ua WHERE id=".$max_id['id']);
	$edit->bindParam(':header',$header);
	$edit->bindParam(':text',$text);
	$edit->bindParam(':header_ua',$header_ua);
	$edit->bindParam(':text_ua',$text_ua);
	$edit->execute();

	header("Location: view.php");
}
?>


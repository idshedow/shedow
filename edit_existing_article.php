<?php
include "authorisation.php";
$article=$db->query("SELECT * FROM link_list WHERE id=".$_GET['id']);
$edit_article=$article->fetch(PDO::FETCH_ASSOC);
if (($_SESSION['user_role']) >= 3)
{
	// only admin can edit any article
	// moders can edit only their articles
	if ((($_SESSION['user'])==($edit_article['list_link_author'])) or (($_SESSION['user_role']) == 4))
	{
		if (($_SESSION['lang']) == 'en')
		{
			$lang_header = $edit_article['list_link_header'];
			$lang_text = $edit_article['list_link_text'];
		}
		else
		{
			$lang_header = $edit_article['list_link_header_ua'];
			$lang_text = $edit_article['list_link_text_ua'];
		}
		echo "<form action=".$_SERVER['REQUEST_URI']." method='post'>";
		echo '<input type="text" name="header" size="40" value="'.$lang_header.'"><br>';
		echo "<textarea name='article' cols='100' rows='20'>";
		echo $lang_text."</textarea><br>";
		echo "<input name='submit' type='submit' value='Save changes'>";
		echo "</form>";
		if (isset($_POST['submit']))
		{
			// edit only english version of article
			if (($_SESSION['lang']) == 'en')
			{
				$_SESSION['article_header']=strip_tags($_POST['header']);
				$_SESSION['article_text']=strip_tags($_POST['article']);
				$header = $_SESSION["article_header"];
				$text = $_SESSION["article_text"];
				$edit = $db->prepare("UPDATE link_list SET list_link_header= :header, list_link_text= :text WHERE id=".$edit_article['id']);
				$edit->bindParam(':header',$header);
				$edit->bindParam(':text',$text);
			}
			else  // edit only ukrainian version of article
			{
				$_SESSION['article_header_ua']=strip_tags($_POST['header']);
				$_SESSION['article_text_ua']=strip_tags($_POST['article']);
				$header = $_SESSION["article_header_ua"];
				$text = $_SESSION["article_text_ua"];
				$edit = $db->prepare("UPDATE link_list SET list_link_header_ua= :header, list_link_text_ua= :text WHERE id=".$edit_article['id']);
				$edit->bindParam(':header',$header);
				$edit->bindParam(':text',$text);
			}
			$edit->execute();

			header("Location: index.php");
		}
	}
	else
	{
		echo "You can edit only your articles.<br>";
		echo "<a href='index.php'>Back to Main Page</a>";
	}
}
else
	echo "You have no permission to do this.";
?>

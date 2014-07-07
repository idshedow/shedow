<?php
// connecting to data base
include "authorisation.php";
//include "db.php";
if ((!isset($_SESSION['user'])) or ($_SESSION['user_role'] >=2)) // all users except banned can view articles
{
	
	$article=$db->query("SELECT * FROM link_list WHERE id=".$_GET['id']);
	$view_article=$article->fetch(PDO::FETCH_ASSOC);
	if (($_SESSION['lang']) == 'en') // view article in English if ENG is chosen
	{
		echo "<h4>".$view_article['list_link_header']."</h4>";
		echo "<p>".$view_article['list_link_text']."<br><br>";
	}
	else  // view article in Ukrainian if UA is chosen
	{
		echo "<h4>".$view_article['list_link_header_ua']."</h4>";
		echo "<p>".$view_article['list_link_text_ua']."<br><br>";
	}
	// link to author's profile page and date
	echo "<a href=profile.php?user=".$view_article['list_link_author'].">".$view_article['list_link_author']."</a>"." ";
	echo $view_article['list_link_date']."<br><br>";
	// if you are autorized and you are moder or admin...
	if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role']>=3))
	{
		// if you are moder and author or you are admin you can edit this article and delete it
		if ((($_SESSION['user'])==($view_article['list_link_author'])) or (($_SESSION['user_role']) == 4))
		{
			echo "<a href='edit_existing_article.php?id=".$view_article['id']."'>Edit</a><br>";
			echo "<form method='post'>";
			echo "<input name='delete' type='submit' value='Delete article'><br>";
			echo "</form>";
			if (isset($_POST['delete']))
			{
				$db->exec('DELETE FROM link_list WHERE id='.$view_article['id']);
				header("Location: index.php");
			}
		}
	}	
	echo "<a href='index.php'>Back to Main Page</a>";
}
elseif ($_SESSION['user_role'] == 1) // banned users cannot
	echo "banned";
else 
	// if the role is not in (1..4) diapasone
	echo "Error. cannot check user's permissions";

?>

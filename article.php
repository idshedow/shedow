<?php
// connecting to data base
include "authorisation.php";
//include "db.php";
if ((!isset($_SESSION['user'])) or ($_SESSION['user_role'] ==1)) // all users except banned can view articles
{
	header("Location: index.php");
}
	$article=$db->query("SELECT * FROM link_list WHERE id=".$_GET['id']);
	$view_article=$article->fetch(PDO::FETCH_ASSOC);
	if (($_SESSION['lang']) == 'en') // view article in English if ENG is chosen
	{
		echo "<h3>{$view_article['list_link_header']}</h3>";
		echo "<p>{$view_article['list_link_text']}<br><br>";
	}
	else  // view article in Ukrainian if UA is chosen
	{
		echo "<h3>{$view_article['list_link_header_ua']}</h3>";
		echo "<p>{$view_article['list_link_text_ua']}<br><br>";
	}
	// link to author's profile page and date
?>
<a href="profile.php?user=<?=$view_article['list_link_author']?>"><?=$view_article['list_link_author']?></a>
<i><?=$view_article['list_link_date']?></i><br><br>

	<?php
	// if you are autorized and you are moder or admin...
	if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role']>=3))
	{
		// if you are moder and author or you are admin you can edit this article and delete it
		if ((($_SESSION['user'])==($view_article['list_link_author'])) or (($_SESSION['user_role']) == 4))
		{?>

		<a href="edit_existing_article.php?id=<?=$view_article['id']?>">Edit</a><br>
		<form method='post'>
		<input name='delete' type='submit' value='Delete article'><br>
		</form>

		<?php
			if (isset($_POST['delete']))
			{
				$db->exec('DELETE FROM link_list WHERE id='.$view_article['id']);
				header("Location: index.php");
			}
		}
	}?>	
<a href='index.php'>Back to Main Page</a>

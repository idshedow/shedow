<?php
//include "db.php";  //CONNECTING TO DATA BASE
include "authorisation.php";
// cheking authorization
if (isset($_SESSION['user']))
{
	// cheking user's permissions
	if ($_SESSION['user_role'] >= 3)
	{
		echo "<form action=".$_SERVER['REQUEST_URI']." method='post'>";
		echo "<input type='text' name='header' size='40' placeholder='header'><br>";
		echo "<textarea name='article' cols='100' rows='20'>";
		echo "</textarea><br>";
		echo "<input type='submit' value='Add new matherial'>";
		echo "</form>";
		// set values to variables
		$time_date=date("d-m-Y H:i");
		$_SESSION['date']=$time_date;
		if (isset($_POST['header']))
		{
			$header = strip_tags($_POST['header']);
			$_SESSION['article_header'] = $header;
			$full_header="<h3>".$header."</h3><br><br>";
		}
		if (isset($_POST['article']))
		{
			$article = trim(strip_tags($_POST['article']));
			$_SESSION['article_text'] = $article;
			$full_article=$article."<br><br>".$time_date;
		}
		// if somehow user wrote text without authorising
		if (isset($_SESSION['user']))
			$author = $_SESSION['user'];
		else
			$author = "unknown author";

		// insert information to data base
		if(isset($_POST['header'])) 
		{
			try
			{
			$stmt = $db->prepare("INSERT INTO link_list (list_link_header, list_link_text, list_link_date, list_link_author) VALUES(?,?,?,?)");
			$stmt->execute(array($header, $article, $time_date, $author));
			}
			catch(PDOException $e)
			{
			echo 'Error: '.$e->getMessage();
			exit();
			}

		}
		if(isset($_POST['header']))
			header("Location:view.php");
	}
	else
	{
		echo "You have no permission to add new matherial.<br>";
		echo "<a href='index.php'>Back to main page</a>";
	}
}
else
	{
		echo "Unauthorized users cannot add new matherials.<br>";
		echo "<a href='index.php'>Back to main page</a>";
	}
?>


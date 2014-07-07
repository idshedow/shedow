<html>
<head>
<link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
include "authorisation.php";
if (isset($_SESSION['user']))
{
	if ($_SESSION['user_role'] >= 3)
	{
		echo "<span id='small_text'>Here is the view of your article:<br></span>";
		echo "<h3>".$_SESSION['article_header']."</h3>";
		echo "<p>".$_SESSION['article_text'];
		echo "<p>".$_SESSION['user']." ".$_SESSION['date'];
		echo "<p><a href='edit.php'>Edit the article</a>";
		echo "<p><a href='index.php'>Back to Main Page</a>";
	}
	else
	{
		echo "You have no permission to do this.<br>";
		echo "<a href='index.php'>Back to main page</a>";
	}
}
else
{
	echo "You cannot do it. Please authorize.<br>";
	echo "<a href='index.php'>Back to main page</a>";
}
?>



</body>
</html>


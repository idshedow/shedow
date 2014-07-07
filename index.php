<!DOCTYPE html>
<html>
<head>
 <link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include "authorisation.php"?>

<?php 
// if user is authorized
if (isset($_SESSION['user']))
{
	// if user have a right to add new matherials
	if ($_SESSION['user_role'] >= 3)
	{
		echo '<a href="form_news.php">Add metherial</a>';
	}
	echo "<br><br>";
	// if user is banned
	if ($_SESSION['user_role']==1)
	{
		echo "You are banned on this site! Please leave it alone.";
	}
	// if user have standart user's rights
	else
	{
		include "link_list.php";
	}
}
elseif ((isset($_GET['ban'])) and (($_GET['ban']) == "true"))
	echo "You are banned!";
// if not authorized, guest can read matherials
else
	{
		echo "<br><br>";
		include "link_list.php";
	}
?>

</body>
</html>


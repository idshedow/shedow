<?php
/**
*  Page where user can view his article just added with "edit" button.
*/
include 'authorisation.php';
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
}
if ($_SESSION['user_role'] < 3) {
  header("Location: index.php");
}
?>

<html>
<head>
  <link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<span id='small_text'>Here is the view of your article in English:<br></span>
<h3><?=$_SESSION['article_header']?></h3>
<p><?=$_SESSION['article_text']?><br><br>
<span id='small_text'>Here is the view of your article in Ukrainian:<br></span>
<h3><?=$_SESSION['article_header_ua']?></h3>
<p><?=$_SESSION['article_text_ua']?><br>
<p><?=$_SESSION['user']?> <i><?=$_SESSION['date']?></i>
<p><a href='edit.php'>Edit the article</a>
<p><a href='index.php'>Back to Main Page</a>
</body>
</html>

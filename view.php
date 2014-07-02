<?php
include "authorisation.php";
?>
<html>
<head>
<link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<span id="small_text">Here is the view of your article:<br></span>
<h3><?=$_SESSION['article_header']?></h3>
<p><?=$_SESSION['article_text'];?>
<p>Shedow<?="\t".$_SESSION['date']?>
<p><a href="edit.php">Edit the article</a>
<p><a href="index.php">Back to Main Page</a>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
 <link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- <div id="header">-->
<?php include "authorisation.php"?>
<!-- </div> -->
<div>
<?php 
//if (isset($_SESSION['user']))
echo '<a href="form_news.php">Add metherial</a>';
?>

<br><br>
<?php include "link_list.php"?>
</div>
</body>
</html>


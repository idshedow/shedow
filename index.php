<?php
/**
 * @file
 * Main page of site. Includes all required files.
 */

$add_math = '';
$header = '';
$list_links = array();
$main_page = array();

include 'authorisation.php';
// if user is authorized
if (isset($_SESSION['user'])) {
  // if user have a right to add new matherials
  if ($_SESSION['user_role'] >= 3) {
    $add_math = '<div id="add_math"><a href="form_news.php">' . $language['add_math'] . '</a></div>';
    // echo '<span id="add_math"><a href="form_news.php">' . $language['add_math'] . '</a></span>';
  }
  // echo '<br><br>';
  // if user is banned
  if ($_SESSION['user_role'] == 1) {
    echo 'You are banned on this site! Please leave it alone.';
  }
  // if user have standart user's rights
  else {
    include 'link_list.php';
  }
}
elseif ((isset($_GET['ban'])) and (($_GET['ban']) == "true")) {
  echo "You are banned!";
}
// if not authorized, guest can read matherials
else {
    // echo '<br><br>';
    include 'link_list.php';
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Shedow site</title>
  <link href="shedow_style.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
</head>
<body>
  <?php print $header; ?>
  <?php print $add_math; ?>
  <div class="main-content">
  <?php foreach($list_links as $item): ?>
  <?php print $item; ?>
  <?php print $main_page['delimiter'] ?>
  <?php endforeach; ?>
  <?php print $main_page['pager']; ?>
  </div>
</body>
</html>

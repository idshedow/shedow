<?php
/**
 * @file
 * This page includes when user is authorized
 * and it has only "logout" button.
 */
$welcome = '';
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: index.php");
}
$welcome = "<form method='post'><input name='logout' type='submit' value='{$language['logout']}'></form>"
?>

<?php
/**
 * @file
 * Admin page for confirmation of deleting users.
 */
include "authorisation.php";
if ((isset($_SESSION['user_role'])) and (($_SESSION['user_role']) == 4)) {
  $user_name = trim($_GET['user']);
  if (isset($_POST['delete'])) {
    $db->exec("DELETE FROM users WHERE user_name ='" . $user_name . "'");
    header("Location: admin.php");
  }
  if (isset($_POST['cancel'])) {
    header("Location: admin.php");
  }
}
else {
  header("Location: index.php");
}
?>

<p>Are you sure you want to delete user <?=$_GET['user']?>?<br>
<form method='post'>
<input type='submit' name='delete' value='Yes'>
<input type='submit' name='cancel' value='No'>
</form>

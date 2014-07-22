<?php
/**
*  User's page for deleting own account.
*/
include "authorisation.php";
if ((isset($_SESSION['user'])) and ($_SESSION['user'] == $_GET['user'])) {
  $user_name = trim($_SESSION['user']);
  if (isset($_POST['delete'])) {
    $db->exec("DELETE FROM users WHERE user_name ='" . $user_name . "'");
    session_destroy();
    header("Location: index.php");
  }
  if (isset($_POST['cancel'])) {
    header("Location: profile.php?user=" . $_SESSION['user']);
  }
}
else {
  header("Location: index.php");
}
?>

<p>Are you sure you want to delete your profile from this site?<br>
<form method='post'>
<input type='submit' name='delete' value='Yes'>
<input type='submit' name='cancel' value='No'>
</form>

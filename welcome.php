<?php
/**
*  This page includes when user is authorized
*  and it has only "logout" button.
*/
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: index.php");
}
?>

<form method="post">
  <input name="logout" type="submit" value="<?=$language['logout']?>">
</form>

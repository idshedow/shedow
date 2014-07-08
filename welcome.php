<?php
 echo '<form method="post">';
 echo '<input name="logout" type="submit" value="'.$language['logout'].'">';
 echo '</form>';
if (isset($_POST['logout']))
{
 session_destroy();
 header("Location: index.php");
}
?>

<?php 
 echo '<form method="POST" action="'.$_SERVER["REQUEST_URI"].'">';
 echo '<input type="text" name="login" size="20" placeholder="login">';
 echo '<input type="password" name="pass" size="20" placeholder="password">';
 echo '<input name="submit" type="submit" value="Log in">';
 echo '</form>';
?>

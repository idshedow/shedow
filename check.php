<?php
$check = "<form method='post' action='{$_SERVER['REQUEST_URI']}'>";
$check .= "<input type='text' name='login' size='20' placeholder='login'>";
$check .= "<input type='password' name='pass' size='20' placeholder='password'>";
$check .= "<input name='submit' type='submit' value='{$language['login']}'><br>";
$check .= "<span id='large_text'><a href='registration.php'>{$language['reg']}</a></span>";
$check .= "</form>";

?>

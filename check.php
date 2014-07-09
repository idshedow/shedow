<head>
	<link href="shedow_style.css" rel="stylesheet" type="text/css">
</head>
<form method="POST" action="<?=$_SERVER['REQUEST_URI']?>">
	<input type="text" name="login" size="20" placeholder="login">
	<input type="password" name="pass" size="20" placeholder="password">
	<input name="submit" type="submit" value="<?=$language['login']?>"><br>
	<span id="large_text"><a href="registration.php"><?=$language['reg']?></a></span>
	<span id="large_text"><a href="reg_js.html"> Reg with JS</a></span>
</form>

<?php
include "db.php";
$language = array();
$translate = $db->query("SELECT * FROM translate");
$row_count = $translate->rowCount();
for ($i=1; $i<=$row_count; $i++)
{
	$translate = $db->query("SELECT ua FROM translate WHERE id='".$i."'");
	$lang = $translate->fetch(PDO::FETCH_ASSOC);
	$lang_array[$i] = $lang['ua'];
}

$language['welcome'] = $lang_array[1];
$language['admin_menu'] = $lang_array[2];
$language['profile'] = $lang_array[3];
$language['logout'] = $lang_array[4];
$language['reg'] = $lang_array[5];
$language['login'] = $lang_array[6];
// main page
$language['add_math'] = "Додати матеріал";
// profile page
$language['user_name'] = "Ім’я користувача";
$language['e-mail'] = "Електронна пошта";
$language['user_reg'] = "Користувач зареєстрований";
$language['last_visit'] = "Останній раз у мережі";
$language['edit_profile'] = "Редагувати профіль";
$language['back_to_main'] = "Назад на Головну Сторінку";


	
?>

<?php
/**
*  File with language variables in English.
*/
include 'db.php';
$language = array();
$translate = $db->query("SELECT * FROM translate");
$row_count = $translate->rowCount();
for ($i = 1; $i <= $row_count; $i++) {
  $translate = $db->query("SELECT en FROM translate WHERE id= '{$i}'");
  $lang = $translate->fetch(PDO::FETCH_ASSOC);
  $lang_array[$i] = $lang['en'];
}

// authorization block
$language['welcome'] = $lang_array[1];
$language['admin_menu'] = $lang_array[2];
$language['profile'] = $lang_array[3];
$language['logout'] = $lang_array[4];
$language['reg'] = $lang_array[5];
$language['login'] = $lang_array[6];
// main page
$language['add_math'] = "Add matherial";
// profile page
$language['user_name'] = "User name";
$language['e-mail'] = "User E-Mail";
$language['user_reg'] = "User registered";
$language['last_visit'] = "Last visited";
$language['edit_profile'] = "Edit the Profile";
$language['back_to_main'] = "Back to Main Page";
?>

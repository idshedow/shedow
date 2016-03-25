<?php
/**
 * @file
 * User's profile page with "edit" link.
 */
include "authorisation.php";
if(isset($_SESSION['pass_changed'])) {
    echo $_SESSION['pass_changed'];
    unset($_SESSION['pass_changed']);
}
if(isset($_SESSION['e_mail_changed'])) {
    echo $_SESSION['e_mail_changed'];
    unset($_SESSION['e_mail_changed']);
}
// open the page of user:
$user_info = $db->query("SELECT * FROM users WHERE user_name='{$_GET['user']}'");
$profile = $user_info->fetch(PDO::FETCH_ASSOC);

$user_profile['username'] = "<div id='user_name'>{$profile['user_name']}</span></div>";

// user avatar, default if user has not it
if ($profile['user_avatar']) {
  $user_profile['avatar'] = "<img src={$profile['user_avatar']} width='150' height='150'><br>";
}
else {
  $user_profile['avatar'] = "<img src='images/noavatar.png'><br>";
}
// user name if he has it
if (($profile['user_first_name']) or ($profile['user_last_name']))
  $user_profile['name'] = $language['user_name'] . ': ' . $profile['user_first_name'] . ' ' . $profile['user_last_name'] . ';<br>';
// other information
if (isset($_SESSION['user'])) {
  $user_profile['email'] = $language['e-mail'] . ': ' . $profile['user_mail'] . ';<br>';
}
$user_profile['user_reg'] = $language['user_reg'] . ': <i>' . $profile['user_reg_date'] . ';</i><br>';
$user_profile['last_visit'] = $language['last_visit'] . ': <i>' . $profile['user_last_visit'] . ';</i><br><br>';
if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role'] >= 2)) {
  if ((($_SESSION['user'])==($profile['user_name'])) or (($_SESSION['user_role']) == 4)) {
    $user_profile['user_edit'] = "<a href='edit_profile.php?user={$profile['user_name']}'>{$language['edit_profile']}</a><br>";
  }
}
$user_profile['back_to_main'] = "<a href='index.php'>{$language['back_to_main']}</a>";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Shedow site</title>
  <link href="shedow_style.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
</head>
<body>
  <?php print $header; ?>
  <?php foreach($user_profile as $item): ?>
  <?php print $item; ?>
  <?php endforeach; ?>
</body>

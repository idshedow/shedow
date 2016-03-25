<?php
/**
 * @file
 * Page for editing user's profile
 */

$edit_profile = array();

include "authorisation.php";
// include "db.php";
$user_info = $db->query("SELECT * FROM users WHERE user_name ='" . $_GET['user'] . "'");
$profile = $user_info->fetch(PDO::FETCH_ASSOC);
// if you are authorized and have permissions to do it
if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role'] >= 2)) {
  if (($_SESSION['user'] == $profile['user_name']) or ($_SESSION['user_role'] == 4)) {
    // ***********   CHANGING E_MAIL  *****************
    if (isset($_POST['changed_e_mail'])) {
      $mail_search = $db->query("SELECT * FROM users WHERE user_mail= '" . $_POST['changed_e_mail'] . "'");
      $find_same_mail = $mail_search->fetch(PDO::FETCH_ASSOC);
      // true if we have already this e-mail in data base:
      if ($find_same_mail) { 
        echo "This e-mail is allready exist. Try to use another e-mail.";
      }
      // we can change user's e-mail:
      else {
        $edit = $db->prepare("UPDATE users SET user_mail = :mail WHERE user_name ='" . $profile['user_name'] . "'");
        $edit->bindParam(':mail',$_POST['changed_e_mail']);
        $edit->execute();
        $_SESSION['e_mail_changed'] = "E-mail succussfully changed!<br>";
        header("Location: profile.php?user=".$profile['user_name']);
      }
    }
    //  ********** CHANGING PASWORD  ******************
    // if we typed anything in the "new password" field:
    if (isset($_POST['changed_pass'])) {
      // if we didn't write old password, we cannot change it
      if(!$_POST['old_pass']) {
        $edit_profile['errors'][] = "You must write your old password to change it";
      }
      // else checking old password
      else {
        $pass_search = $db->query("SELECT * FROM users WHERE user_name ='" . $_GET['user'] . "'");
        $pass_found = $pass_search->fetch(PDO::FETCH_ASSOC);
        // true if we wrote right old password:
        if ((md5($_POST['old_pass'])) === ($pass_found['user_password'])) {
          // password verification
          if (($_POST['changed_pass']) === ($_POST['changed_veri_pass'])) {
            // if all is right we can change password:
            $edit = $db->prepare("UPDATE users SET user_password = :pass WHERE user_name ='" . $_GET['user'] . "'");
            $edit->bindParam(':pass',md5($_POST['changed_pass']));
            $edit->execute();
            // send e message to profile page that we changed the password
            $_SESSION['pass_changed'] = "Password successfully changed!<br>";
            header("Location: profile.php?user=".$profile['user_name']); // open profile page after the task
          }
          else {  
            echo "You wrote different new passwords."; // if new pass != verification pass
          }
        }
        // if old password is incorrect:
        else {
          echo "Incorrect old password!";
        }
      }
    }
    //  ***************  CHANGE NAME  **********************
    if (isset($_POST['first_name'])) {
      $edit = $db->prepare("UPDATE users SET user_first_name = :first_name WHERE user_name ='" . $_GET['user'] . "'");
      $edit->bindParam(':first_name',$_POST['first_name']);
      $edit->execute();
      header("Location: profile.php?user=".$profile['user_name']);
    }
    if (isset($_POST['last_name'])) {
      $edit = $db->prepare("UPDATE users SET user_last_name = :last_name WHERE user_name ='" . $_GET['user'] . "'");
      $edit->bindParam(':last_name',$_POST['last_name']);
      $edit->execute();
      header("Location: profile.php?user=".$profile['user_name']);
    }
      //  *****************  CANCEL BUTTON ******************
    // cancel button - return to profile page:
    if (isset($_POST['cancel'])) {
      header("Location: profile.php?user=".$profile['user_name']);
    }
      // ******************  AVATAR  *************************
    // choosing the avatar:
    if (isset($_POST['upload'])) {
      if ($_FILES['avatar']['name']) {
        // checking type of image (only JPEG or PNG are yet allowable)
        if (((basename($_FILES['avatar']['type'])) == "jpeg") or ((basename($_FILES['avatar']['type'])) == "png")) {
          // new name of avatar image. if avatar is already exists it will replace it with a new image
          $avatar = 'images/' . $_GET['user'] . '.' . basename($_FILES['avatar']['type']);
          $tmp_name = $_FILES['avatar']['tmp_name'];  // tmp name of avatar image
          if (move_uploaded_file($tmp_name, $avatar)) {
            // adding avatar file path to data base
            $edit = $db->prepare("UPDATE users SET user_avatar = :avatar WHERE user_name ='" . $_GET['user'] . "'");
            $edit->bindParam(':avatar', $avatar);
            $edit->execute();
            $_SESSION['avatar'] = $avatar;
            echo 'uploaded: ' . $avatar;
          }
        }
        else {
          echo 'canot load image :(';
        }
      }
    }
    // users can delete their profile
    if ($_SESSION['user'] == $profile['user_name']) {
      $edit_profile['delete'] = "<a href='delete_own_acc.php?user=" . $profile['user_name'] . "'>Delete your profile</a>";
    }
  }
  else {
    header("Location: index.php");
  }
}
else {
  header("Location: index.php");
}
if (!empty($edit_profile['errors'])) {
  print_r($edit_profile['errors']);
  // header("Location: {$_SERVER['REQUEST_URI']}");
}
if (isset($profile['user_avatar'])) {
  $edit_profile['avatar'] = "<p id='small_text'>Your avatar: <br><img src='{$profile['user_avatar']}' width='150' height='150'><br>";
}
if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role'] == 4)) {
  $edit_profile['user_roles'] = "<p>User role:</p>";
  $edit_profile['user_roles'] .= "<select name = 'role' size='1'>";
  $edit_profile['user_roles'] .= "<option value='4'>Administrator</option>";
  $edit_profile['user_roles'] .= "<option value='3'>Moderator</option>";
  $edit_profile['user_roles'] .= "<option value='2'>User</option>";
  $edit_profile['user_roles'] .= "<option value='1'>Banned</option>";
  $edit_profile['user_roles'] .= "</select>";
  $edit_profile['user_roles'] .= "<input type='submit' name='change_role' value='Change role'>";
  if (isset($_POST['change_role'])) {
    $edit = $db->prepare("UPDATE users SET user_role = :role WHERE user_name ='" . $_GET['user'] . "'");
    $edit->bindParam(':role', $_POST['role']);
    $edit->execute();
    header("Location: edit_profile.php?user=" . $profile['user_name']);
  }
}
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
  <?php if (!empty($edit_profile['errors'])): ?>
  <?php foreach($edit_profile['errors'] as $error): ?>
  <?php print $error; ?>
  <?php endforeach; ?>
  <?php endif; ?>
  <?php print $edit_profile['delete']; ?>
  <table cellpadding="5">
  <form method="POST" enctype="multipart/form-data">

  <tr><td align="right"><p> User Name: </td> 
    <td><p id="user_name"><?=$profile['user_name']?></td>
  </tr>
  <tr><td align="right" valign="top"><p> Change Password: </td>
    <td><input type="password" name="old_pass" size="15" maxlength="25"><span id="small_text">Write Your Old Password<br>
    <input type="password" name="changed_pass" size="15" maxlength="25">New Password<br>
    <input type="password" name="changed_veri_pass" size="15" maxlength="25">Verify New Password<br></td>
  </tr>
  <tr><td align="right"> <p id="small_text">Your E-mail:</td>
    <td><p id="small_text"><?=$profile['user_mail']?></td>
  </tr>
  <tr><td align="right"> <p>Change E-mail:</td>
    <td><input type="text" name="changed_e_mail" size="20" maxlength="25"></td>
  </tr>
  <tr><td align="right"><p id="small_text">Current Name: </td>
    <td><p id="small_text"><?=$profile['user_first_name']." ".$profile['user_last_name']?></td>
  </tr>
  <tr><td align="right"><p>First Name: </td>
    <td><input type="text" name="first_name" size="15" maxlength="25"></td>
  </tr>
  <tr><td align="right"><p>Last Name: </td>
    <td><input type="text" name="last_name" size="15" maxlength="25"></td>
  </tr>
  <tr><td align="right"><p>Avatar: </td>
    <td><input type="hidden" name="MAX_FILE_SIZE" value="600000">
    <input type="file" name="avatar">
    <input type="submit" name="upload" value="Upload"></td>
  </tr> 
  </table>

  <?php print $edit_profile['avatar']; ?>
  <?php print $edit_profile['user_roles']; ?>
  <br>
  <div>
    <input name="save_changes" type="submit" value="Save Changes">
    <input name="cancel" type="submit" value="Cancel">
  </div>
</form>
</body>
</html>

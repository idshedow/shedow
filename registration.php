<?php 
include "authorisation.php";
include "db.php";
if (isset($_SESSION['user']))     // if we are authorised, redirecting to main page
	header("Location: index.php");
if (isset($_POST['cancel']))      // cancel button
	header("Location: index.php");
if (isset($_POST['registr']))
{
	$return = $db->query("SELECT * FROM users WHERE user_name='".$_POST['new_user']."'");
	$returned_user_name = $return->fetch(PDO::FETCH_ASSOC);
	if ($returned_user_name)  // true if user name is already exist
	{
		echo "This user name is already exist."; // error message
	}
	else // user name is actually new. checking e-mail
	{
		$mail_return = $db->query("SELECT * FROM users WHERE user_mail='".$_POST['new_user_e_mail']."'");
		$returned_user_mail = $mail_return->fetch(PDO::FETCH_ASSOC);
		if ($returned_user_mail) // true if e-mail exists in data base
		{
			echo "User with this e-mail is already registered. Enter another e-mail";
		}
		else // we have no user with this user name and password
		{
			{
				if (($_POST['new_user_pass']) != ($_POST['new_user_repass'])) // verifying password
					echo "You entered two different passwords. Please enter the same password in both fiels.";
				else // ok. user name is good, e-mail is good, password is good
				{
					if (strlen($_POST['new_user']) >= 15) // checking the lendth of user name (must be < 15)
					{
						echo "Your user name must be shorter then 15 symbols. PLease enter new user name";
					}
					else
					{	
						try // insert new user's data into data base, table 'users'
						{
							$date = date("d-m-Y H:i");
							$reg = $db->prepare("INSERT INTO users (user_name, user_password, user_mail, user_reg_date, user_last_visit, user_role) VALUES (?,?,?,?,?,?)");
							$reg->execute(array($_POST['new_user'], md5($_POST['new_user_pass']), $_POST['new_user_e_mail'], $date, $date, '2'));
						}
						catch(PDOException $e)
						{
							echo "Error: ".$e->getMessage();
							exit();
						}  // authomatic authorisation if success
						$return = $db->query("SELECT * FROM users WHERE user_name='".$_POST['new_user']."'");
						$returned_user_name = $return->fetch(PDO::FETCH_ASSOC);
						$_SESSION['user']=$returned_user_name['user_name'];
						$_SESSION['user_role'] = $returned_user_name['user_role'];
						header("Location: index.php");
					}
				}
			}
		}
	}
}
?>
<p> Registration:
<!-- Registration Table -->
<form method="POST">
<table width="30%" cellpadding="5">
	<tr> 	<td width="50%" align="right"> User Name </td> 
			<td><input type="text" name="new_user" size="20" maxlength="25"></td>
	</tr>
	<tr> 	<td align="right"> Password </td> 
			<td><input type="password" name="new_user_pass" size="20" maxlength="25"></td>
	</tr>
	<tr> 	<td align="right"> Verify Password </td> 
			<td><input type="password" name="new_user_repass" size="20" maxlength="25"></td>
	</tr>
	<tr> 	<td align="right"> E-mail </td> 
			<td><input type="text" name="new_user_e_mail" size="20" maxlength="25"></td>
	</tr>
</table>
<br>
<input name="registr" type="submit" value="Register now">
<input name="cancel" type="submit" value="Cancel">
</form>

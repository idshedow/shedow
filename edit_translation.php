<?php
include "authorisation.php";
if ($_SESSION['user_role'] == 4)
{
	$id = $_GET['id'];
	echo "Edit translation: <br>";
	$words = $db->query("SELECT * FROM translate WHERE id=".$_GET['id']);
	$edit_words = $words->fetch(PDO::FETCH_ASSOC);
	echo "<form method='post'>";
	echo "<input type='text' name='eng' value='".$edit_words['en']."'>";
	echo "<input type='text' name='ukr' value='".$edit_words['ua']."'>";
	echo "<input type='submit' name='save' value='Save Changes'>";
	echo "</form>";
	if (isset($_POST['save']))
	{
		$edit = $db->prepare("UPDATE translate SET en= :en, ua= :ua WHERE id='".$id."'");
		$edit->bindParam(':en', $en);
		$edit->bindParam(':ua', $ua);
		$en = trim(strip_tags($_POST['eng']));
		$ua = trim(strip_tags($_POST['ukr']));
		$edit->execute();
		header("Location: admin.php");
	}
}
else
	header("Location: index.php");
?>

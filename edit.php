<?php
include "authorisation.php";
if (isset($_POST['submit']))
{
$_SESSION['article_header']=strip_tags($_POST['header']);
$_SESSION['article_text']=strip_tags($_POST['article']);
$max = $db->query("SELECT * FROM link_list");
$max_row=$max->rowCount();
$edit = $db->prepare("UPDATE link_list SET list_link_header= :header, list_link_text= :text WHERE id=8");
$edit->bindParam(':header',$header);
$edit->bindParam(':text',$text);
$header = $_SESSION["article_header"];
$text = $_SESSION["article_text"];
$edit->execute();

header("Location: view.php");
}
?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<input type="text" name="header" size="40" value="<?=$_SESSION['article_header']?>"><br>
<textarea name="article" cols="100" rows="20">
<?=$_SESSION['article_text']?>
</textarea>
<br>
<input name="submit" type="submit" value="Save changes">
</form>

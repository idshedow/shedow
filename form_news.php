<?php
include "db.php";  //CONNECTING TO DATA BASE

//session_start();
include "authorisation.php";
// set values to variables
$time_date=date("d-m-Y H:i");
$_SESSION['date']=$time_date;
if (isset($_POST['header']))
{
 $header = trim(strip_tags($_POST['header']));
 $_SESSION['article_header'] = $header;
 $full_header="<h3>".$header."</h3><br><br>";
}
if (isset($_POST['article']))
{
 $article = trim(strip_tags($_POST['article']));
 $_SESSION['article_text'] = $article;
 $full_article=$article."<br><br>".$time_date;
}


// insert information to data base
if(isset($_POST['header'])) 
{
try
{
$stmt = $db->prepare("INSERT INTO link_list (list_link_header, list_link_text, list_link_date) VALUES(?,?,?)");
$stmt->execute(array($header, $article, $time_date));
}
catch(PDOException $e)
{
echo 'Error: '.$e->getMessage();
exit();
}

}
if(isset($_POST['header']))
 header("Location:view.php");
?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
<input type="text" name="header" size="40" placeholder="header"><br>
<textarea name="article" cols="100" rows="20">
</textarea>
<br>
<input type="submit" value="Add new matherial">
</form>

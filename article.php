<?php
// connecting to data base
$user = 'root';
$pass = '123';
try{
$db = new PDO('mysql:host=localhost;dbname=shedow',$user,$pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
echo $e->getMessage();
}
$article=$db->query("SELECT * FROM link_list WHERE id=".$_GET['id']);
$view_article=$article->fetch(PDO::FETCH_ASSOC);
echo "<h4>".$view_article['list_link_header']."</h4>";
echo "<p>".$view_article['list_link_text']."<br>";
echo $view_article['list_link_date'];
?>

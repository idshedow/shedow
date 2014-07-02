<?php
$user='root';
$pass='123';
try{
$db = new PDO('mysql:host=localhost;dbname=shedow',$user,$pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
echo $e->getMessage();
}
?>

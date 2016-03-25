<?php
/**
 * @file
 * Connecting to data base.
 */
$user = 'root';
$pass = '123456';
try {
  $db = new PDO('mysql:host=localhost;dbname=shedow', $user, $pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
  echo $e->getMessage();
}
if(!($db)) { 
  echo "Unable to connect to data base server";
  exit();
}
?>

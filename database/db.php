<?php
require_once "database/config.php";

function setupDB(){
  $db = new PDO(DB_NAME, DB_USER, DB_PASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {
    $query = $db->prepare('SELECT * FROM usuarios');
    $query->execute();
  } 
  catch (Exception $e) {
    $create_script = file_get_contents("database/db_tpe.sql");
    $db->exec($create_script);
  }
  return $db;
}
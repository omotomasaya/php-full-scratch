<?php
session_start();
  require_once 'database/connection.php';
  require_once 'classes/user.php';
  require_once 'classes/tweet.php';
  require_once 'classes/follow.php';

  global $pdo;

  $getFromU = new User($pdo);
  $getFromT = new Tweet($pdo);
  $getFromF = new Follow($pdo);

?>
<?php
  require_once('env.php');

  $host = 'be55cc2f486f93';
  $dbname = 'be55cc2f486f93';
  $user = 'us-cdbr-east-04.cleardb.com';
  $pass = 'd253e777';
  $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

  try {
    $pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  } catch(PDOException $e){
    echo '接続失敗です'. $e->getMessage();
    exit();
  }

?>

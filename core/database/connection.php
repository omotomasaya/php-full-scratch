<?php
  require_once('env.php');

  $dsn = "mysql:host={$db['us-cdbr-east-04.cleardb.com']}; dbname={$db['heroku_dc045a7b9996d70']}";
  $user = $db['be55cc2f486f93'];
  $pass = $db['d253e777'];

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

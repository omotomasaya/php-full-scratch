<?php
  require_once('env.php');

  $db = parse_url($_SERVER['mysql://be55cc2f486f93:d253e777@us-cdbr-east-04.cleardb.com/heroku_dc045a7b9996d70?reconnect=true']);
  $db['heroku_dc045a7b9996d70'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['us-cdbr-east-04.cleardb.com']};dbname={$db['heroku_dc045a7b9996d70']};charset=utf8";
  $user = $db['be55cc2f486f93'];
  $password = $db['d253e777'];

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

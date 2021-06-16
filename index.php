<?php
require_once('core/class.php');

  $getFromU->loggedIn();
  
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="assets/css/index.css">
  <title>ログイン画面</title>
</head>
<body>
  <div class="form">
    <h2>ようこそ</h2>
    <div>
      <a href="public/login_form.php">
        <input type="submit" class="btn-login" value="ログインする">
      </a>
    </div>
    <div>
      <a href="public/signup_form.php">
        <input type="submit" class="btn-signup" value="新規登録はこちら">
      </a>   
    </div>
  </div>
</body>
</html>
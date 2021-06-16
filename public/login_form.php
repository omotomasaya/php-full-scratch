<?php
require_once('../core/class.php');

$getFromU->loggedIn();

if(isset($_POST['login'])){
  $email = $getFromU->checkInput($_POST['email']);
  $password = $getFromU->checkInput($_POST['password']);

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "ログインに失敗しました";
  }else{
    $result = $getFromU->checkEmail($email);

    if(password_verify($password, $result['password'])){
      $_SESSION['user_id'] = $result['user_id'];
      header('Location: ../home.php');
      exit();
    }else{
      $error = "ログインに失敗しました";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/login_form.css">
  <title>ログイン画面</title>
</head>
<body>
  <div class="log-form">
    <h2>ログインフォーム</h2>
    <form method="post">
      <p>
        <input type="test" name="email" placeholder="メールアドレス">
      </p>
      <p>
        <input type="password" name="password" placeholder="パスワード">
      </p>
      <p>
       <input type="submit" class="btn" name="login" value="ログイン">
      </p>
    </form>
    <div>
      <button type="submit" class="btn signup">
        <a href="signup_form.php">新規登録はこちら</a>
      </button>
    </div>
    <?php
      if(isset($error)){
        echo '<div class="error">'.$error.'</div>';
      }
    ?>
  </div>
</body>
</html>
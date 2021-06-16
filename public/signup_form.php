<?php
require_once('../core/class.php');

$getFromU->loggedIn();

if(isset($_POST['signup'])){

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $member = $getFromU->checkEmail($email);

  if(empty($username) or empty($password) or empty($email)){
    $error = '空欄があります';
  }else{
    $username = $getFromU->checkInput($username);
    $email = $getFromU->checkInput($email);
    $password = $getFromU->checkInput($password);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

      $error = 'メールアドレスの形式が不正です。';

    }else if(strlen($username) > 20){

      $error = '名前は20文字以内で入力してください';

    }else if(strlen($password) < 4){

      $error = 'パスワードは4文字以上で入力いてください';

    }else{

      if($getFromU->checkEmail($email) === $email){

        $error = '同じメールアドレスが存在します。';

      }else{

        $getFromU->register($username, $email, $hash);
        header('Location: ../home.php');
        exit();

      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../assets/css/signup_form.css">
  <title>ユーザ登録画面</title>
</head>
<body>
  <div class="log-form">
    <h2>ユーザ登録フォーム</h2>
    <form method="post">
      <p>
        <input type="test" name="username" placeholder="ユーザ名">
      </p>
        <p>
          <input type="test" name="email" placeholder="メールアドレス">
        </p>
      <p>
        <input type="password" name="password" placeholder="パスワード">
      </p>
      <p>
        <input type="submit" name="signup" class="btn" value="新規登録">
      </p>
    </form>
    <div>
      <button type="submit" class="btn signup">
        <a href="login_form.php">ログインする</a>
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
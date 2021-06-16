<?php
require_once('core/class.php');

  $getFromU->unloggedIn();
  
  $user_id = $_GET['user_id'];
  $user = $getFromU->userData($user_id);

  //curEmailはcurrentEmailの略

  if(isset($_POST['change'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password)){

      $email = $getFromU->checkInput($email);
      $password = $getFromU->checkInput($password);

      if(filter_var($email, FILTER_VALIDATE_EMAIL)){

        if($getFromU->checkEmail($email) === false){
          
          if(password_verify($password, $user->password)){

            $getFromU->emailChange($email, $user_id);
            $error = '変更しました。';

          }else{

            $error = 'パスワードに誤りがあります。';

          }

        }else{

          $error = '同じメールアドレスが存在します。';

        }

      }else{

        $error = 'メールアドレスの形式が不正です。';

      }

    }else{

      $error = '空欄があります';

    }

  }

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>twitter clone</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
<body>
<div class="global-nav">
<nav>
  <ul>
    <li><a href="home.php">ホーム</a></li>
    <li><a href="mypage.php?user_id=<?php echo $user->user_id;?>">マイページ</a></li>
    <li id="contextmenu">
      <div>設定</div>
      <span class="inner_line" id="line1">
        <p>
          <a href="password.php?user_id=<?php echo $user->user_id;?>">パスワード変更</a>
        </p>
        <p>
          <a href="email.php?user_id=<?php echo $user->user_id;?>">メールアドレス変更</a>
        </p>
      </span>
    </li>
    <li><a href="public/logout.php">ログアウト</a></li>
  </ul>
</nav> 
</div>
<div class="in-wrapper">
  <form method="post">
    <p>新しいメールアドレス</p>
    <input type="text" name="email" placeholder="新しいメールアドレス">
    <p>パスワード</p>
    <input type="password" name="password" placeholder="パスワード">
    <span>
      <input type="submit" name="change" value="変更" class="btn-password">
    </span>
  </form>
  <?php
    if(isset($error)){
      echo '<div class="error">'.$error.'</div>';
    }
  ?>
  </div>
  <script type="text/javascript" src="assets/js/menubar.js"></script>
</body>
</html>

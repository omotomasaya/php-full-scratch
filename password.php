<?php
require_once('core/class.php');

  $getFromU->loggedIn();
  
  $user_id = $_GET['user_id'];
  $userData = $getFromU->userData($user_id);

  //curPasswordはcurrentPasswordの略
  //conPasswordはconfirmationPasswordの略

  if(isset($_POST['change'])){

    $curPassword = $_POST['curPassword'];
    $newPassword = $_POST['newPassword'];
    $conPassword = $_POST['conPassword'];

    if(!empty($curPassword) && !empty($newPassword) && !empty($conPassword)){

      $curPassword = $getFromU->checkInput($curPassword);
      $newPassword = $getFromU->checkInput($newPassword);
      $conPassword = $getFromU->checkInput($conPassword);

      if(strlen($newPassword) < 4){

        $error = '新しいパスワードは4文字以上で入力いてください';

      }else{

        if($newPassword === $conPassword){
       
          if(password_verify($curPassword, $userData->password)){

            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $getFromU->passwordChange($hash, $user_id);
            $error = '変更しました。'

          }else{

            $error = '誤りがあります。';

          }

        }else{

          $error = '新しいパスワードと確認用パスワードが一致しません。';

        }

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
    <li><a href="password.php?user_id=<?php echo $user->user_id;?>">設定</a></li>
    <li><a href="public/logout.php">ログアウト</a></li>
  </ul>
</nav> 
</div>
<div class="in-wrapper">
  <form method="post" enctype="multipart/form-data">
    <p>現在のパスワード</p>
    <input class="" type="password" name="curPassword" placeholder="現在のパスワード">
    <p>新しいパスワード</p>
    <input class="" type="password" name="newPassword" placeholder="新しいパスワード">
    <p>確認用パスワード</p>
    <input class="" type="password" name="conPassword" placeholder="確認用パスワード">
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
</body>
</html>

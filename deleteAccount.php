<?php
    require_once('core/class.php');

    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    $getFromU->unloggedIn();
    
    if(isset($_POST['delete'])){

        $email = $getFromU->checkInput($_POST['email']);
        $password = $getFromU->checkInput($_POST['password']);
        $passConfirm = $getFromU->checkInput($_POST['passConfirm']);

        if(empty($email) or empty($password) or empty($passConfirm)){

            $error = '空欄があります';

        }else{

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

                $error = 'メールアドレスの形式が不正です。';

            }elseif($password === $passConfirm){

                $result = $getFromU->checkEmail($email);

                if(password_verify($password, $result['password'])){

                    $getFromT->deleteLike($user_id);
                    $getFromT->deleteAllTweet($user_id);
                    $getFromT->deleteAllComments($user_id);
                    $getFromF->deleteFollow($user_id);
                    $getFromU->deleteAccount($user_id);

                }else{

                    $error = "アカウント削除に失敗しました";

                }
            }
        }


    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>delete</title>
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
    <li><a href="deleteAccount.php">アカウント削除</a></li>
  </ul>
</nav> 
</div>
    <p>アカウント削除</p>
    <form method="post">
        <p>
            <input type="test" name="email" placeholder="メールアドレス">
        </p>
        <p>
        　　<input type="password" name="password" placeholder="パスワード">
      　</p>
      　<p>
        　　<input type="password" name="passConfirm" placeholder="パスワード確認">
      　</p>
      　<p>
        　　<input type="submit" class="btn" name="delete" value="削除">
      　</p>
        <?php
            if(isset($error)){
              echo '<div class="error">'.$error.'</div>';
            }
        ?>
    </form>
</body>
<script type="text/javascript" src="assets/js/menubar.js"></script>
</html>
<?php
require_once('core/class.php');

  $user_id = $_SESSION['user_id'];
  $user = $getFromU->userData($user_id);

  $getFromU->unloggedIn();

  if(isset($_POST['username'])){
    if(!empty($_POST['username'])){
      $username = $getFromU->checkInput($_POST['username']);
      $bio = $getFromU->checkInput($_POST['bio']);

      if(strlen($username) > 20){
        $error = "名前は20文字以内で入力してください";
      }else if(strlen($bio) > 140){
        $error = "プロフィールは140文字以内で入力してください";
      }else{
        $getFromU->update($username, $bio, $user_id);
        header('Location: mypage.php?user_id='.$user->user_id.'');
        exit();
      }
    }else{
      $error = "空白です";
    }
  }
if(isset($_FILES['profileImage'])){
  if(!empty($_FILES['profileImage'])){
    $getFromU->uploadprofileImage($_FILES['profileImage'], $user_id);
    header('Location: mypage.php?user_id='.$user->user_id.'');
    exit();
  }
       
}


?>

<!DOCTYPE html>
<html>
<head>
  <title>Profile edit page</title>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="assets/css/mypage_edit.css"/>
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
    <li><a href="deleteAccount.php">アカウント削除</a></li>
  </ul>
</nav> 
</div>
<div class="mypage-wrapper">
  <div class="profile-inner">
    <div class="profile-box">
      <img src="<?php echo $user->profileImage;?>" class="profile-image">
      <div class="img-upload-button-wrapper">
          <form method="post" enctype="multipart/form-data">
            <input id="profileImage" type="file"  name="profileImage">
            <span>
              <input type="submit" class="btn-image" value="変更">
            </span>
            <?php
              if(isset($imageError)){
                echo '<div class="error">'.$imageError.'</div>';
              }
            ?>
          </form>
      </div>
    </div>
    <div class="profile-box">
      <form method="post">
        <div class="profile-name-wrapper">
          <label>名前</label>
          <div class="profile-name">
            <input type="text" name="username" value="<?php echo $user->username;?>">
          </div>
        </div>
        <div class="profile-bio-wrapper">
          <label>プロフィール</label>
          <div class="profile-bio-inner">
            <textarea class="status" name="bio"><?php echo $user->bio;?></textarea>
          </div>
        </div>
        <?php
          if(isset($error)){
            echo '<div class="error">'.$error.'</div>';
          }
        ?>
        <span>
        <input type="submit" class="btn" value="変更">
        </span>
        </form>
      </div>
  </div>
</div>
<script type="text/javascript" src="assets/js/menubar.js"></script>
</body>
</html>
<?php
require_once('core/class.php');


  $getFromU->unloggedIn();

  if (isset($_GET['user_id']) === true && empty($_GET['user_id']) === false) {

    $profileId = $_GET['user_id'];
    $profileData = $getFromU->userData($profileId);
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);

  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>twitter clone</title>
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="assets/css/followList.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.js">
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <meta charset="utf-8">
</head>
<body>
<header>
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
</header>
<div class="main-wrapper">
  <div class="profile-wrapper">
    <div class="profile-box">
      <div class="profile-image-box">
        <img src="<?php echo $profileData->profileImage;?>" class="profile-image">
      </div>
      <div class="profile-information-box">
        <div>
          <div class="profile-name">
            <a href="mypage.php?user_id=<?php echo $profileId?>"><?php echo $profileData->username;?></a>
          </div>
          <div class="follow-number-box">
            <div class="follow-number-head">
              フォロー中
            </div>
            <div class="follow-number-body">
              <span class="follow-count-following"><?php echo $getFromF->countFollow($profileId);?></span>
            </div>
          </div>
          <div class="follow-number-box">
            <div class="follow-number-head">
              フォロワー
            </div>
            <div class="follow-number-body">
              <span class="follow-count-followers"><?php echo $getFromF->countFollower($profileId);?>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="follow-list-wrapper">
  <div class="number-list-box">
    <div class="number-list-head">
      フォロー中
    </div>
    <div class="number-list-body">
      <span class="following">
        <?php echo $getFromF->followList($profileId, $user_id);?>
      </span>
    </div>
  </div>
  <div class="number-list-box">
    <div class="number-list-head">
      フォロワー
    </div>
    <div class="number-list-body">
      <span class="followers">
        <?php echo $getFromF->followerList($profileId, $user_id);?>
      </span>
    </div>
  </div>
</div>
<script type="text/javascript" src="assets/js/follow.js"></script>
<script type="text/javascript" src="assets/js/menubar.js"></script>
</body>
</html>


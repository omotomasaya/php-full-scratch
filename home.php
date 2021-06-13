<?php
require_once('core/class.php');

  $user_id = $_SESSION['user_id'];
  $user = $getFromU->userData($user_id);
  $tweetBy = $user_id;

  $getFromU->loggedIn();

  if(isset($_POST['tweet'])){

    $tweetText = $getFromU->checkInput($_POST['tweetText']);
    $image = '';

    if(!empty($tweetText) && !empty($_FILES['tweetImage']['name'])){

        if(strlen($tweetText) > 140){

          $error = "140文字以内にしてくだざい";

        }

        if(!empty($_FILES['tweetImage']['name'])){

          $tweetImage = $getFromU->uploadTextImage($_FILES['tweetImage'], $tweetBy, $tweetText);

        }
    }elseif(!empty($tweetText) or !empty($_FILES['tweetImage']['name'])){

      if(!empty($_FILES['tweetImage']['name'])){

        $tweetImage = $getFromU->uploadImage($_FILES['tweetImage'], $tweetBy);

      }

      if(!empty($tweetText)){

        if(strlen($tweetText) > 140){

          $error = "140文字以内にしてくだざい";

        }

        $getFromU->uploadText($tweetText, $tweetBy);
        
      }
    }else{

      $error = "画像もしくは文字を入力してください";

    }
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>twitter clone</title>
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="assets/css/tweet.css">
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
    <li><a href="password.php?user_id=<?php echo $user->user_id;?>">設定</a></li>
    <li><a href="public/logout.php">ログアウト</a></li>
  </ul>
</nav> 
</div>
</header>
<div class="main-wrapper">
  <div class="info-wrapper">
    <div class="info-box">
        <div class="info-image">
          <img src="<?php echo $user->profileImage;?>" class="image">
        </div>
      <div class="info-name-box">
        <div class="info-name">
          <div><a href="mypage.php?user_id=<?php echo $user->user_id?>"><?php echo $user->username;?></a></div>
        </div>
      </div>
    </div>
    <div class="number-wrapper">
      <div class="num-box">
        <div class="num-head">
          ツイート
        </div>
        <div class="num-body">
          <?php $getFromT->countTweets($user_id);?>
        </div>
      </div>
        <div class="num-box">
          <div class="num-head">
            フォロー中
          </div>
          <div class="num-body">
            <span class="count-following"><?php echo $getFromF->countFollow($user_id);?></span>
          </div>
        </div>
        <div class="num-box">
          <div class="num-head">
            フォロワー
          </div>
        <div class="num-body">
          <span class="count-followers"><?php echo $getFromF->countFollower($user_id);?>
          </span>
        </div>
      </div>  
    </div>
  </div>

  <div class="tweet-wrapper">
    <div class="tweet-box">
      <div class="tweet-post">
        <form method="post" enctype="multipart/form-data">
          <textarea class="tweet-text" name="tweetText" placeholder="ここに何か書いてみよう！" rows="4" cols="50"></textarea>
          <div class="tweet-footer">
            <div class="tweet-fo-left">
              <ul>
                <input type="file" name="tweetImage" id="tweetImage">
                <li>
                  <span class="tweet-error">
                    <?php if(isset($error)){echo $error;}else if(isset($imageError)){echo $imageError;}?>
                    </span>
                </li>
              </ul>
            </div>
            <div class="tweet-fo-right">
              <span id="count">140</span>
              <input type="submit" name="tweet" value="tweet" class="btn">
            </div>
          </div>
        </form>    
        </div>
      </div>
      <div class="tweets">
        <?php $getFromT->tweets($user_id);?>
      </div>
    </div>
    <input type="text" id="search" name="search" class="form-control" placeholder="検索">
      <div id="search-list"></div>
      <div class="who-user-list"><?php $getFromF->whoToFollow($user_id, $user_id);?></div>
  </div>
</div>
<script type="text/javascript" src="assets/js/search.js"></script>
<script type="text/javascript" src="assets/js/counter.js"></script>
<script type="text/javascript" src="assets/js/like.js"></script>
<script type="text/javascript" src="assets/js/delete.js"></script>
<script type="text/javascript" src="assets/js/follow.js"></script>
</body>
</html>


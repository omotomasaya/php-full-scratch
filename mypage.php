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
<html>
  <head>
    <title>twitter clone</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="assets/css/mypage.css"/>
    <link rel="stylesheet" href="assets/css/tweet.css"/>
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
<div class="mypage-wrapper">
  <div class="profile-mypage-inner">
    <div class="profile-mypage-box">
      <div class="profile-img">
        <img src="<?php echo $profileData->profileImage; ?>"/>
        <div class="profile-count">
          <div class="nember-head">
            TWEETS
          </div>
          <div class="nember-bottom">
            <?php $getFromT->countTweets($profileId); ?>
          </div>
          <li>
          <a href="followList.php?user_id=<?php echo $profileId?>">
            <div class="nember-head">
              FOLLOWING
            </div>
            <div class="nember-bottom">
              <span class="count-following"><?php echo $getFromF->countFollow($profileId);?></span>
            </div>
          </a>
          </li>
          <li>
           <a href="followList.php?user_id=<?php echo $profileId?>">
              <div class="nember-head">
                FOLLOWERS
              </div>
              <div class="nember-bottom">
                <span class="count-followers"><?php echo $getFromF->countFollower($profileId);?></span>
              </div>
            </a>
          </li>
        </div>
      </div>
    </div> 
    <div class="profile-mypage-box">
      <div class="profile-name-wrapper">
        <label>名前</label>
        <div class="profile-name">
          <span><?php echo $profileData->username;?></span>
        </div>
      </div>
      <div class="profile-bio-wrap">
        <label>プロフィール</label>
       <div class="profile-bio-inner">
          <?php echo $profileData->bio; ?>
       </div>
      </div>
    </div>
  </div>
  <div class="edit-button">
    <?php
      if($profileId === $user_id){
        echo '<span><button class="button"><a href="mypage_edit.php">編集</a></button></span>';
      }
      if($profileId != $user_id){
        echo $getFromF->followBtn($profileId, $user_id);
      }
    ?>

  </div>
  <div class="tweets">
    <?php
      $tweets = $getFromT->getUserTweets($profileId);

      foreach ($tweets as $tweet){
        $like = $getFromT->likesCheck($user_id, $tweet->tweetID);
        echo '<div class="all-tweet">
                <div class="tweet-show-wrapper"> 
                  <div class="tweet-show-inner">
                    <div class="tweet-show-head">
                      <div class="tweet-show-head-box">
                        <div class="tweet-show-profileimage">
                          <img src="'.$tweet->profileImage.'"/>
                        </div>
                        <div class="tweet-show-content">
                          <div class="tweet-show-name">
                            <span><a href="mypage.php?user_id='.$tweet->user_id.'">'.$tweet->username.'</a></span>
                            <span>@'.$tweet->username.'</span>
                            <span>'.$tweet->postedAt.'</span>
                          </div>
                        </div>
                      </div>
                    <div class="tweet-show-post">
                      <div class="tweet-show-text">
                        '.$tweet->tweetText.'
                      </div>';
                    echo '<img src="'.$tweet->tweetImage.'">
                      ';
                    if(isset($tweetImage)){
                      echo '<!--tweet show head end-->
                              <div class="tweet-show-body">
                                 <div class="tweet-show-tweetimage">
                                   <img src="'.$tweet->tweetImage.'"/>
                                 </div>
                              </div>
                              <!--tweet show body end-->';
                    }
                    if(isset($like['tweetID'])){
                      echo '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up good"></i><span class="likesCounter">';
                      echo $getFromT->countLikes($tweet->tweetID);
                      echo'</span></button>';
                    }else{
                      echo '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up no-good"></i><span class="likesCounter">';
                      echo $getFromT->countLikes($tweet->tweetID);
                      echo '</span></button>';
                    }
                    
                    echo '</div><div class="tweet-show-footer">';
                          if($tweet->tweetBy === $user_id){
                            echo '<label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">削除</label></li>';
                            }
                    echo '</div>
                        </div>
                      </div>
                    </div>
                </div>';
        }
      ?>
  </div>
<script type="text/javascript" src="assets/js/delete.js"></script>
<script type="text/javascript" src="assets/js/like.js"></script>
<script type="text/javascript" src="assets/js/follow.js"></script>
  </div>
<script type="text/javascript" src="assets/js/menubar.js"></script>
</body>
</html>

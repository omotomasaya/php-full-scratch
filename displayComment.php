<?php
require_once('core/class.php');

  $getFromU->loggedIn();
  
if (isset($_GET['id']) === true && empty($_GET['id']) === false) {
    $tweetID = $_GET['id'];
    $tweet = $getFromT->getTweet($tweetID);
    $user_id = $_SESSION['user_id'];
    $user = $getFromU->userData($user_id);
    $like = $getFromT->likesCheck($user_id, $tweetID);
    $comments = $getFromT->comments($tweetID);
}

?>


<!DOCTYPE html>
<html>
  <head>
    <title>twitter clone</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="assets/css/mypage.css"/>
    <link rel="stylesheet" href="assets/css/tweet.css"/>
    <link rel="stylesheet" href="assets/css/comment.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.js">
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
<!--Helvetica Neue-->
<body>
<div class="global-nav">
<nav>
  <ul>
    <li><a href="home.php">ホーム</a></li>
    <li><a href="mypage.php?user_id=<?php echo $user->user_id;?>">マイページ</a></li>
    <li><a href="public/logout.php">ログアウト</a></li>
  </ul>
</nav> 
</div>
  <div class="tweets">
    <?php
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
                      </div>
                     <img src="'.$tweet->tweetImage.'">
                      ';
                    if(isset($like['tweetID'])){
                      echo '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up good"></i><span class="likesCounter">';
                      echo $getFromT->countLikes($tweet->tweetID);
                      echo'</span></button>';
                    }else{
                      echo '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up no-good"></i><span class="likesCounter">';
                      echo $getFromT->countLikes($tweet->tweetID);
                      echo '</span></button>';
                    }
                    
                    echo '</div><div class="tweet-show-footer">
                        </div>
                        </div>
                      </div>
                    </div>
                </div>'
      ;?>
        <div class="tweet-show-footer-input-wrap">
            <div class="tweet-show-footer-input-inner">
              <div class="tweet-show-footer-input-right">
                <input id="commentField" type="text" name="comment" data-tweet="<?php echo $tweet->tweetID;?>" placeholder="<?php echo $tweet->username;?>へコメント">
              </div>
            </div>
            <div class="tweet-footer">
              <div class="tweet-footer-right">
                <input type="submit" id="postComment" value="送信">
                <script type="text/javascript" src="assets/js/comment.js"></script>
              </div>
             </div>
          </div>
        <div id="comments">
          <?php foreach ($comments as $comment) {
        echo '<div class="tweet-show-comment-box">
              <div class="tweet-show-comment-inner">
                <div class="tweet-show-comment-head">
                  <div class="tweet-show-comment-head-right">
                      <div class="tweet-show-comment-name-wrapper">
                        <div class="tweet-show-comment-name-box">
                          <img src="'.$comment->profileImage.'" class="tweet-show-comment-img">
                        </div>
                        <div class="tweet-show-comment-name-box">
                          <span><a href="mypage.php?user_id='.$comment->commentBy.'">'.$comment->username.'</a></span>
                          <span>@'.$comment->username.'</span>
                          <span>'.$comment->createdOn.'</span>
                       </div>
                     </div>
                     <div class="tweet-show-comment">
                          <p>'.$comment->comment.'</p>
                    </div>
                    <div class="tweet-show-footer-menu">
                      <ul>
                          ';
                          if($comment->commentBy == $user_id){
                            echo '
                            <li><div class="deleteComment" data-tweet="'.$tweet->tweetID.'" data-comment="'.$comment->comment_id.'">削除</div></li>';
                          }
                          echo '
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            ';
      }?>
    </div>
  </div>

  </div>
<script type="text/javascript" src="assets/js/counter.js"></script>
<script type="text/javascript" src="assets/js/like.js"></script>
<script type="text/javascript" src="assets/js/delete.js"></script>
</body>
</html>
<?php 
  require_once '../class.php';
 
  if(isset($_POST['comment']) && !empty($_POST['comment'])){
    $comment = $getFromU->checkInput($_POST['comment']);
    $user_id = $_SESSION['user_id'];
    $tweetID = $_POST['tweet_id'];
    $tweet = $getFromT->getTweet($tweetID);
    $tweet_id = $tweet->tweetBy;

    $getFromT->commentCreate($comment, $user_id ,$tweet_id, $tweetID);
    $comments = $getFromT->comments($tweetID);

    foreach ($comments as $comment) {
        echo '<div class="tweet-show-popup-comment-box">
            <div class="tweet-show-popup-comment-inner">
              <div class="tweet-show-popup-comment-head">
                <div class="tweet-show-popup-comment-head-left">
                   <div class="tweet-show-popup-comment-img">
                    <img src="'.$comment->profileImage.'">
                   </div>
                </div>
                <div class="tweet-show-popup-comment-head-right">
                    <div class="tweet-show-popup-comment-name-box">
                    <div class="tweet-show-popup-comment-name-box-name"> 
                      <a href="'.$comment->username.'">'.$comment->username.'</a>
                    </div>
                    <div class="tweet-show-popup-comment-name-box-tname">
                      <a href="'.$comment->username.'">@'.$comment->username.'</a>
                    </div>
                   </div>
                   <div class="tweet-show-popup-comment-right-tweet">
                      <p><a href="'.$tweet->username.'">@'.$tweet->username.'</a> '.$comment->comment.'</p>
                   </div>
                  <div class="tweet-show-popup-footer-menu">
                        <ul> 
                          <li><label class="deleteComment" data-tweet="'.$tweet->tweetID.'" data-comment="'.$comment->commentID.'">削除</label></li>
                        </ul>
                  </div>
                </div>
              </div>
            </div>
            <!--TWEET SHOW POPUP COMMENT inner END-->
            </div>
            ';
      }
  }
?>
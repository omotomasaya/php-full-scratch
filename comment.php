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
      }
  }else{
    echo 'コメントを入力してください';
  }
?>
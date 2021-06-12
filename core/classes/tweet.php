<?php
  class Tweet extends User {

    public function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function tweets($user_id){
      $stmt = $this->pdo->prepare("SELECT * FROM tweets LEFT JOIN users ON tweetBy = user_id WHERE tweetBy = :user_id OR tweetBy IN(SELECT followed FROM relation WHERE follow = :user_id) ORDER BY tweetID DESC");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $tweets = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach ($tweets as $tweet){
        $like = $this->likesCheck($user_id, $tweet->tweetID);
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
                    if(isset($like['tweetID'])){
                      echo '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up good"></i><span class="likesCounter">';
                      echo $this->countLikes($tweet->tweetID);
                      echo'</span></button>';
                    }else{
                      echo '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-thumbs-up no-good"></i><span class="likesCounter">';
                      echo $this->countLikes($tweet->tweetID);
                      echo '</span></button>';
                    }
                    echo '</div><div class="tweet-show-footer">
                      <a href="displayComment.php?id='.$tweet->tweetID.'">コメント</a><span class="commentCounter">';
                      echo $this->countComment($tweet->tweetID);
                      echo '</span>';
                          if($tweet->tweetBy === $user_id){
                            echo '<label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">削除</label></li>';
                            }

                    echo '</div>
                        </div>
                      </div>
                    </div>
                </div>';
      }
    }

    public function getUserTweets($user_id){
      $stmt = $this->pdo->prepare("SELECT * FROM tweets LEFT JOIN users ON tweetBy = user_id WHERE tweetBy = :user_id ORDER BY tweetID DESC");
      $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteTweet($tweet_id, $user_id){
      $stmt = $this->pdo->prepare('DELETE FROM tweets WHERE tweetID = :tweetID AND tweetBy = :user_id');
      $stmt->bindValue(':tweetID', $tweet_id, PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function deleteComment($tweetID, $user_id, $comment_id){
      $stmt = $this->pdo->prepare('DELETE FROM comments WHERE tweetID = :tweetID AND commentBy = :user_id AND comment_id = :comment_id');
      $stmt->bindValue(':tweetID', $tweetID, PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function countTweets($user_id){
      $stmt = $this->pdo->prepare("SELECT COUNT(tweetID) AS totalTweets FROM tweets WHERE tweetBy = :user_id");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      echo $count->totalTweets;
    }

    public function like($user_id, $tweetBy, $tweetID){
      $stmt = $this->pdo->prepare("INSERT INTO likes(takeLike, getLike, tweetID) VALUES (:user_id, :tweetBy, :tweetID)");
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':tweetBy', $tweetBy, PDO::PARAM_INT);
      $stmt->bindValue(':tweetID', $tweetID, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function unlike($user_id, $tweetBy, $tweetID){
      $stmt = $this->pdo->prepare("DELETE FROM likes WHERE takeLike = :user_id AND getLike = :tweetBy AND tweetID = :tweetID");
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':tweetBy', $tweetBy, PDO::PARAM_INT);
      $stmt->bindValue(':tweetID', $tweetID, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function countLikes($tweetID){
      $stmt = $this->pdo->prepare("SELECT COUNT(like_id) AS totalLikes FROM likes WHERE tweetID = :tweetID");
      $stmt->bindParam(":tweetID", $tweetID, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      return $count->totalLikes;
    }

    public function likesCheck($user_id, $tweetID){
      $stmt = $this->pdo->prepare("SELECT * FROM likes WHERE takeLike = :user_id AND tweetID = :tweetID");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":tweetID", $tweetID, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTweet($tweetID){
      $stmt = $this->pdo->prepare("SELECT * FROM tweets,users WHERE tweetID = :tweetID AND tweetBy = user_id");
      $stmt->bindParam(":tweetID", $tweetID, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function commentCreate($comment, $user_id, $tweet_id, $tweetID){
      $stmt = $this->pdo->prepare("INSERT INTO comments(comment, commentBy, commented, tweetID) VALUES (:comment, :user_id, :tweet_id, :tweetID)");
      $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_INT);
      $stmt->bindValue(':tweetID', $tweetID, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function getComment($tweetID){
      $stmt = $this->pdo->prepare("SELECT * FROM tweets,users WHERE tweetID = :tweetID AND tweetBy = user_id");
      $stmt->bindParam(":tweetID", $tweetID, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function countComment($tweetID){
      $stmt = $this->pdo->prepare("SELECT COUNT(comment_id) AS totalComment FROM comments WHERE tweetID = :tweetID");
      $stmt->bindParam(":tweetID", $tweetID, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      return $count->totalComment;
    }

    public function comments($tweet_id){
      $stmt = $this->pdo->prepare("SELECT * FROM comments LEFT JOIN users ON commentBy = user_id WHERE tweetID = :tweet_id ORDER BY comment_id DESC");
      $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


  }
?>


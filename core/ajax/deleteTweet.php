<?php
  require_once '../class.php';
  if(isset($_POST['deleteTweet']) && !empty($_POST['deleteTweet'])){
    $tweet_id = $_POST['deleteTweet'];
    $user_id = $_SESSION['user_id'];
    $getFromT->deleteTweet($tweet_id, $user_id);
  }

?>
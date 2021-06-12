<?php
require_once('../class.php');

    if(isset($_POST['like']) && !empty($_POST['like'])){
      $user_id  = $_SESSION['user_id'];
      $tweetID = $_POST['like'];
      $tweetBy = $_POST['tweetBy'];
      $getFromT->like($user_id, $tweetBy, $tweetID);
    }
 
    if(isset($_POST['unlike']) && !empty($_POST['unlike'])){
      $user_id  = $_SESSION['user_id'];
      $tweetID = $_POST['unlike'];
      $tweetBy = $_POST['tweetBy'];
      $getFromT->unlike($user_id, $tweetBy, $tweetID);
    }
 

?>
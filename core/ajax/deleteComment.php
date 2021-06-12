<?php
  require_once '../class.php';
  if(isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])){
    $tweetID = $_POST['tweetID'];
    $user_id = $_SESSION['user_id'];
    $comment_id = $_POST['deleteComment'];

    $getFromT->deleteComment($tweetID, $user_id, $comment_id);
  }

?>
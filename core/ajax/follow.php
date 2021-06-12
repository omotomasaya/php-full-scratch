<?php
require_once('../class.php');

  if(isset($_POST['follow']) && !empty($_POST['follow'])){
    $profileId = $_POST['follow'];
    $user_id = $_SESSION['user_id'];
    $getFromF->follow($user_id, $profileId);
  }

  if(isset($_POST['unfollow']) && !empty($_POST['unfollow'])){
    $profileId = $_POST['unfollow'];
    $user_id = $_SESSION['user_id'];
    $getFromF->unfollow($user_id, $profileId);
  }
 

?>
<?php
require_once('../class.php');

  if(isset($_POST["query"]) && !empty($_POST['query'])){
    $search = $getFromU->checkInput($_POST['query']);
    $result = $getFromU->search($search);
    if(!empty($result))
    {
      foreach ($result as $user){
            echo '<a href="mypage.php?user_id='.$user->user_id.'"><li>'.$user->username.'</li></a>';
          }
    }
  }
?>

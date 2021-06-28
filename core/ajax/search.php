<?php
require_once('../class.php');

  if(isset($_POST["query"]) && !empty($_POST['query'])){
    $search = $getFromU->checkInput($_POST['query']);
    $result = $getFromU->search($search);
    if(!empty($result))
    {
      foreach ($result as $user){
        echo '
          <ul class="search-username">
            <li><a href="mypage.php?user_id='.$user->user_id.'">'.$user->username.'</a></li>
            <div class="search-image">
              <img src="'.$user->profileImage.'" >
            </div>
          </ul>';
      }
    }
  }
?>

<?php
  class Follow extends User {

    public function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function checkFollow($profileId, $user_id){
      $stmt = $this->pdo->prepare("SELECT * FROM relation WHERE follow = :user_id AND followed = :profileId");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":profileId", $profileId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function followBtn($profileId, $user_id){
      $data = $this->checkFollow($profileId, $user_id);
      $array = json_decode(json_encode($data), true);
      if($profileId != $user_id){
        if($array == null){
          //フォロー
          return '<span><button class="follow-button" data-profile="'.$profileId.'">フォロー</button></span>';
        }else{
          //フォロー解除
          return '<span><button class="unfollow-button" data-profile="'.$profileId.'">フォロー中</button></span>';
        }
      }
    }

    public function follow($user_id, $profileId){
      $stmt = $this->pdo->prepare("INSERT INTO relation(follow, followed) VALUES (:user_id, :profileId)");
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':profileId', $profileId, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function unfollow($user_id, $profileId){
      $stmt = $this->pdo->prepare("DELETE FROM relation WHERE followed = :profileId AND follow = :user_id");
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':profileId', $profileId, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function countFollow($user_id){
      $stmt = $this->pdo->prepare("SELECT COUNT(follow_id) AS totalFollow FROM relation WHERE follow = :user_id");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      echo $count->totalFollow;
    }

    public function countFollower($user_id){
      $stmt = $this->pdo->prepare("SELECT COUNT(follow_id) AS totalFollow FROM relation WHERE followed = :user_id");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      echo $count->totalFollow;
    }

    public function whoToFollow($user_id, $profileId){
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id != :user_id AND user_id NOT IN (SELECT followed FROM relation WHERE follow = :user_id) ORDER BY rand() LIMIT 3");
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_OBJ);

      echo '<div class="follow-wrap"><div class="follow-inner"><div class="follow-title"><h3>Who to follow</h3></div>';
      foreach ($users as $user){
        echo '<div class="follow-body">
                <div class="follow-img">
                  <img src="'.$user->profileImage.'"/>
                  </div>
                <div class="follow-content">
                  <div class="fo-co-head">
                    <a href="'.$user->username.'">'.$user->username.'</a><span>@'.$user->username.'</span>
                  </div>
                  <!-- FOLLOW BUTTON -->
                  '.$this->followBtn($user->user_id, $user_id).'
                </div>
              </div>';
            }
      echo '</div></div>';

    }
  }
?>

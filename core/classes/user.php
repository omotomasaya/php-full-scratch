<?php 
ini_set('display_errors', 1);
class User {
  protected $pdo;

  public function __construct($pdo){
    $this->pdo = $pdo;
  }

  public function checkInput($data){
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = trim($data);
    $data = stripcslashes($data);
    return $data;
  }

  public function register($username, $email, $hash){
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users(username, email, password, profileImage) VALUES (:username, :email, :password, 'assets/images/icon.png')";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
    $stmt->execute();
    $user_id = $this->pdo->lastInsertId();
    $_SESSION['user_id'] = $user_id;
  }

  public function userData($user_id){
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  public function logout(){
    $_SESSION = array();
    session_destroy();
    header('Location: ../index.php');
    exit;
  }

  public function update($username, $bio ,$user_id){
    $stmt = $this->pdo->prepare("UPDATE users SET username = :username, bio = :bio WHERE user_id = :user_id");
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':bio', $bio, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function checkEmail($email){
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function uploadTextImage($tweetImage, $tweetBy, $tweetText){
    $tweetImage = 'users/' . basename($_FILES['tweetImage']['name']);
    $stmt = $this->pdo->prepare("INSERT INTO tweets(tweetText, tweetBy, tweetImage) VALUES (:tweetText, :tweetBy, :tweetImage)");
    $stmt->bindValue(':tweetText', $tweetText, PDO::PARAM_STR);
    $stmt->bindValue(':tweetBy', $tweetBy, PDO::PARAM_INT);
    $stmt->bindValue(':tweetImage', $tweetImage, PDO::PARAM_STR);
    move_uploaded_file($_FILES['tweetImage']['tmp_name'], $tweetImage);
    $stmt->execute();
  }

  public function uploadImage($tweetImage, $tweetBy){
    $tweetImage = 'users/' . basename($_FILES['tweetImage']['name']);
    $stmt = $this->pdo->prepare("INSERT INTO tweets(tweetBy,tweetImage) VALUES (:tweetBy,:tweetImage)");
    $stmt->bindValue(':tweetBy', $tweetBy, PDO::PARAM_INT);
    $stmt->bindValue(':tweetImage', $tweetImage, PDO::PARAM_STR);
    if(!empty($_FILES['tweetImage']['name'])){
       move_uploaded_file($_FILES['tweetImage']['tmp_name'], $tweetImage);
       $stmt->execute();
    }else{
      $imageError = '画像がありません';
    }
  }

  public function uploadprofileImage($profileImage, $user_id){
    $profileImage = 'users/' . basename($_FILES['profileImage']['name']);
    $stmt = $this->pdo->prepare("UPDATE users SET profileImage = :profileImage WHERE user_id = :user_id");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':profileImage', $profileImage, PDO::PARAM_STR);
    if(!empty($_FILES['profileImage']['name'])){
       move_uploaded_file($_FILES['profileImage']['tmp_name'], $profileImage);
       $stmt->execute();
    }else{
      $imageError = '画像がありません';
    }
  }

  public function uploadText($tweetText, $tweetBy){
    $stmt = $this->pdo->prepare("INSERT INTO tweets(tweetText, tweetBy) VALUES (:tweetText, :tweetBy)");
    $stmt->bindValue(':tweetText', $tweetText, PDO::PARAM_STR);
    $stmt->bindValue(':tweetBy', $tweetBy, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function search($search){
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username LIKE '".$search."%'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function loggedIn(){
    if(!isset($_SESSION['user_id'])) {
      header('Location: http://localhost:8888/portfolio/index.php');
      exit;
    }
  }

  public function unloggedIn(){
    if(isset($_SESSION['user_id'])) {
      header('Location: http://localhost:8888/portfolio/home.php');
      exit;
    }
  }

}
?>
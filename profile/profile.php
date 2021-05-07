<?php
session_start();
require('../db/dbconnect.php');
 
// // DBのmemberに入っているデータを取り出す
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $profiles = $db->prepare('SELECT * FROM profiles WHERE member_id=?');
  $profiles->execute(array($_SESSION['id']));
  $profile = $profiles->fetch();
} else {
  header('Location: ../php_login');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/profile.css">
  <title>Document</title>
</head>
<body>

  <div class="profile-box">
    <div class="profile-title">
      <h1>プロフィール</h1>
    </div>
    <div class="image-box">
      <?php if (!empty($profile['profile_image'])): ?>
      <img class="profile-image" width="100" height="100" src="../member_picture/<?php echo htmlspecialchars($profile['profile_image'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($profile['name'], ENT_QUOTES); ?>">
      <?php else: ?>
        <img src="../default_image/default.jpg" class="profile-image">
      <?php endif; ?>
    </div> 

    <h1 class="profile-name"><?php echo htmlspecialchars($profile['name'], ENT_QUOTES); ?></h1>
    <div class="apexid-box">
      <p>APEXID:</p>
      <p><?php echo htmlspecialchars($profile['apex_id'], ENT_QUOTES); ?></p>
    </div>
  <div class="message-box">
    <p>MESSAGE:</p>
    <p class="message-word"><?php echo htmlspecialchars($profile['message'], ENT_QUOTES); ?></p>
  </div>
  <div class="rank-box">
    <p>RANK:</p>
    <p><?php echo htmlspecialchars($profile['rank'], ENT_QUOTES); ?></p>
  </div>
  <div class="platform-box">
    <p>PLATFORM:</p>
    <p><?php echo htmlspecialchars($profile['platform'], ENT_QUOTES); ?></p>
  </div>
  <h1><a href="make_profile.php">プロフィールを作成する</a></h1>
  </div>
<div>
  <h1><a href="../src/index.php">ホームに戻る</a></h1>
</div>

</body>
</html>
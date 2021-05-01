<?php
session_start();
require('../db/dbconnect.php');
 
// DBのmemberに入っているデータを取り出す
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
  <title>Document</title>
</head>
<body>
  <h1><a href="make_profile.php">プロフィールを作成する</a></h1>
  <h1><?php echo htmlspecialchars($profile['name'], ENT_QUOTES); ?></h1>
  <h1><?php echo htmlspecialchars($profile['apex_id'], ENT_QUOTES); ?></h1>
  <h1><?php echo htmlspecialchars($profile['message'], ENT_QUOTES); ?></h1>
  <h1><?php echo htmlspecialchars($profile['rank'], ENT_QUOTES); ?></h1>
  <h1><?php echo htmlspecialchars($profile['platform'], ENT_QUOTES); ?></h1>
  <img src="../member_picture/<?php echo htmlspecialchars($profile['profile_image'], ENT_QUOTES); ?>" width="100" height="100" alt="<?php echo htmlspecialchars($profile['name'], ENT_QUOTES); ?>">


</body>
</html>
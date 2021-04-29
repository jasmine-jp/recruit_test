<?php
session_start();
require('../db/dbconnect.php');
 
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

  $profiles = $db->prepare('SELECT * FROM profile WHERE id=?');
  $profiles->execute(array($_SESSION['id']));
  $profile = $profiles->fetch();
} else {
  header('Location: login.php');
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
  <h1><?php  print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></h1>
  <h1><?php  print(htmlspecialchars($profile['message'], ENT_QUOTES)); ?></h1>

</body>
</html>
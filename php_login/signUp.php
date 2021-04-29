<?php
  session_start();
  require('../db/dbconnect.php');

  if(!empty($_POST)) {
    if ($_POST['user'] === '') {
      $error['user'] = 'blank';
    } 
    if (strlen($_POST['user']) > 15) {
      $error['user'] = 'length';
    }

    if ($_POST['email'] === '') {
      $error['email'] = 'blank';
    }
    if (strlen($_POST['email']) > 255) {
      $error['email'] == 'length';
    }
    if (strlen($_POST['password']) < 4) {
      $error['password'] = 'length';
    }
    if ($_POST['password'] == '') {
      $error['password'] = 'blank';
    }
    }

    if(!empty($_POST)) {

      if(empty($error)) {
        $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
    
        $member->execute(array($_POST['email']));
        $record = $member->fetch();
        if($record['cnt'] > 0) {
          $error['email'] = 'duplicate';
        }

        $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE name=?');
    
        $member->execute(array($_POST['user']));
        $record = $member->fetch();
        if($record['cnt'] > 0) {
          $error['user'] = 'duplicate';
        }
        
      }

      if(empty($error)) {
        $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, created=NOW()');

        $statement->execute(array(
          $_POST['user'],
          $_POST['email'],
          sha1($_POST['password'])
        ));

        // $_SESSION['join'] = $_POST;
        header('location: thanks.php');
        exit();
      }

      if($_REQUEST['action'] == 'rewrite' &&isset($_SESSION['join'])) {
        $_POST = $SESSION['join'];
      }
    }



?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/sign_up_php.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
  <title>Document</title>
</head>
<body>
<div class="log-form">
<div id="login">
      <form name='form-login' method="post">

        <span class="fontawesome-user"></span>
          <input type="text" name="user" id="user"  maxlength="15" placeholder="Username" value="<?php htmlspecialchars(print($_POST['user']), ENT_QUOTES); ?>">
          <?php if($error['user'] == 'blank'): ?>
            <p class="error">名前を入力してください</p>
          <?php elseif($error['user'] == 'length'): ?>
            <p class="error">名前が長すぎます</p>
          <?php elseif($error['user'] == 'duplicate'): ?>
            <p class="error">その名前はすでに使われています</p>
          
          <?php endif; ?>

        <span class="fontawesome-user"></span>
          <input type="text" name="email" id="email" maxlength="255" placeholder="E-mail" value="<?php htmlspecialchars(print($_POST['email']), ENT_QUOTES); ?>">
          <?php if($error['email'] == 'blank'): ?>
          <p class="error">メールアドレスを入力してください</p>
          <?php elseif($error['email'] == 'length'): ?>
            <p class="error">メールアドレスが長すぎます</p>
          <?php elseif($error['email'] == 'duplicate'): ?>
            <p class="error">そのメールアドレスはすでに使われています</p>
          <?php endif; ?>     

        <span class="fontawesome-lock"></span>
          <input type="password" name="password" id="pass" maxlength="100" placeholder="Password" value="<?php htmlspecialchars(print($_POST['password']), ENT_QUOTES); ?>">
          <?php if($error['password'] == 'blank'): ?>
          <p class="error">パスワードを入力してくださいを入力してください</p>
          <?php elseif($error['password'] == 'length'): ?>
            <p class="error">パスワードが短すぎます</p>
          <?php endif; ?>
        
        <input type="submit" value="Login">

</form>
</body>
</html>
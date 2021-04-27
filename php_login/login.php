
<?php
session_start();
require('../db/dbconnect.php');

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}


if (!empty($_POST)) {
  $email = $_POST['email'];
  
  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
     $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
     $login->execute(array(
       $_POST['email'],
       sha1($_POST['password'])
     ));
     $member = $login->fetch();

     if ($member) {
       $_SESSION['id'] = $member['id'];
       $_SESSION['time'] = time();

      if ($_POST['save'] ===  'on') {
        setcookie('email', $_POST['email'], time() +60*60*24*14);
      }

       header('Location: ../src/index.html');
       exit();
     } else {
       $error['login'] = 'failed';
     }
  } else {
    $error['login'] = 'blank';
  }
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
  <h1>ログインしてください</h1>
  <a href="signUp.php">新規登録画面</a>
  <form action="" method="post">
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" />
          <?php if ($error['login'] === 'blank'): ?>
          <p class="error">＊メールアドレスとパスワードをご記入
          ください</p>
          <?php endif; ?>
          <?php if ($error['login'] === 'failed'): ?>
          <p class="error">ログインに失敗しました。正しくご記入ください。</p>
          <?php endif; ?>
        </dd>
        <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
        </dd>
        <dt>ログイン情報の記録</dt>
        <dd>
          <input id="save" type="checkbox" name="save" value="on">
          <label for="save">次回からは自動的にログインする</label>
        </dd>
      </dl>
      <div>
        <input type="submit" value="ログインする" />
      </div>
    </form>
</body>
</html>
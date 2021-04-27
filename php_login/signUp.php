<?php

if(!empty($_POST)) {
	if ($_POST['user'] === '') {
		$error['user'] = 'blank';
	}
	if ($_POST['email'] === '') {
		$error['email'] = 'blank';
	}
	if (strlen($_POST['password']) < 4) {
		$error['password'] = 'length';
	}
	if ($_POST['password'] === '') {
		$error['password'] = 'blank';
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
          <input type="text" name="user" id="user" maxlength="15" placeholder="Username">

        <span class="fontawesome-user"></span>
          <input type="text" name="email" id="email" maxlength="255" placeholder="E-mail">
       
        <span class="fontawesome-lock"></span>
          <input type="password" name="password" id="pass" maxlength="255" placeholder="Password">
        
        <input type="submit" value="Login">

</form>
</body>
</html>
<?php
session_start();
require('../db/dbconnect.php');
 
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
} else {
  header('Location: ../php_login/login');
  exit();




  
}
// if(!empty($_POST)) {
//   $profile = $db->prepare('INSERT INTO profile SET members_id=?, members_name=?, apex_id=?, profileImage=?, message=?, rank=?, platform=?, created=NOW()');

//   $profile->execute(array(
//     $member['id'],
//     $member['name'],
//     $_POST['apex_id'],
//   ));
// }

if (isset($_POST['add'])) {
  print($_POST['apex_id']);
  print($_POST['platform']);
  print($member['name']);
}
// ①配列にデータを設定
$rank_data = [''=>'選択してください',
             'bronze'=>'ブロンズ',
             'silver'=>'シルバー',
             'gold'=>'ゴールド',
             'platinum'=>'プラチナ',
             'diamond'=>'ダイヤモンド',
             'master'=>'マスター',
             'predator'=>'プレデター'
];
$platform_data = [''=>'選択してください',
                  'ps4'=>'ps4',
                  'xbox'=>'xbox',
                  'pc'=>'pc',
                  'switch'=>'switch'
];
// ②配列のデータをoptionタグに整形
foreach($rank_data as $rank_data_key => $rank_data_val){
    $rank_data .= "<option value='". $rank_data_key;
    $rank_data .= "'>". $rank_data_val. "</option>";
}
foreach($platform_data as $platform_data_key => $platform_data_val) {
  $platform_data .= "<option value='". $platform_data_key; 
  $platform_data .= "'>". $platform_data_val. "</option>";
}

?>

<!-- // // ＊プロフィール
// Id・・・profileのid
// member_id・・・memberのid
// name・・・memberのname
// apex_id・・・apexのid
// profileImage・・・プロフィール画像
// message・・・一言メッセージ
// rank・・・自分のランク
// platform・・・どのプラットフォームでプレイしているか -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form method="post">
    <p>apexのidを設定してください</p>
    <input type="text" name="apex_id" size="35" id="user" maxlength="255"/>
    <p>画像設定をしてください</p>
    <input type="file" name="img" size="35" id="user" maxlength="255"/>
    <p>メッセージを設定してください</p>
    <input type="text" name="message" size="35" id="user" maxlength="255"/>
    <p>ランクを選択してください</p>
    <select name='rank'>
      <?php  echo $rank_data; ?>
    </select>
    <p>プラットフォームを選択てください</p>
    <select name='platform'>
      <?php  echo $platform_data; ?>
    </select>
    <p><?php  print(htmlspecialchars($member['name'], ENT_QUOTES));?></p>
    <input type="submit" value="送信" name="add">
  </form>
</body>
</html>
<?php
session_start();
require('../db/dbconnect.php');


if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
} else {
  header('Location: ../php_login');
  exit();
}


// 画像の処理--------------------------
// 画像の検疫
$fileName = $_FILES['image']['name'];
if (!empty($fileName)) {
  $ext = substr($fileName, -3);
  if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
    $error['image'] = 'type';
  }
}
if (!($error['image'] === 'type')) {
  $image = date('YmdHis') . $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
}
$_SESSION['join']['image']  = $image;
// ----------------------

// データベースへの挿入--------------------------
if (!(empty($_POST['message']))) {
  print($image);
  // INSERT文を変数に格納
  $sql = "INSERT INTO aaa (member_id, apex_id, name, profile_image, message, rank,platform, created) VALUES (:member_id, :apex_id,:name, :profile_image, :message, :rank, :platform, now())";

  // 挿入する値は空のまま、SQL実行の準備をする
  $stmt = $db->prepare($sql);

  // 挿入する値を配列に格納する
  $params = array(':member_id' => $member['id'], ':apex_id' => $_POST['apex_id'], ':name' => $member['name'], ':profile_image' => $_FILES['image'], ':message' => $_POST['message'], ':rank' => $_POST['rank'], ':platform' => $_POST['platform']);

  // 挿入する値が入った変数をexecuteにセットしてSQLを実行
  $stmt->execute($params);

  // 登録完了のメッセージ
  echo '登録完了しました';
}
// --------------------

// セレクトタグ作成------------------
$rank_data = [
  '' => '選択してください',
  'bronze' => 'ブロンズ',
  'silver' => 'シルバー',
  'gold' => 'ゴールド',
  'platinum' => 'プラチナ',
  'diamond' => 'ダイヤモンド',
  'master' => 'マスター',
  'predator' => 'プレデター'
];
$platform_data = [
  '' => '選択してください',
  'ps4' => 'ps4',
  'xbox' => 'xbox',
  'pc' => 'pc',
  'switch' => 'switch'
];
// ②配列のデータをoptionタグに整形
foreach ($rank_data as $rank_data_key => $rank_data_val) {
  $rank_data .= "<option value='" . $rank_data_key;
  $rank_data .= "'>" . $rank_data_val . "</option>";
}
foreach ($platform_data as $platform_data_key => $platform_data_val) {
  $platform_data .= "<option value='" . $platform_data_key;
  $platform_data .= "'>" . $platform_data_val . "</option>";
}
// ------------------------------------------------

?>

<!-- // // ＊プロフィール
// Id・・・profileのid
// member_id・・・memberのid
// apex_id・・・apexのid
// name・・・memberのname
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
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit" />
    <p>apexのidを設定してください</p>
    <input type="text" name="apex_id" size="35" maxlength="255" />
    <p>画像設定をしてください</p>
    <input type="file" name="image" size="35" />
    <p>メッセージを設定してください</p>
    <input type="text" name="message" size="35" maxlength="255" />
    <p>ランクを選択してください</p>
    <select name='rank'>
      <?php echo $rank_data; ?>
    </select>
    <p>プラットフォームを選択てください</p>
    <select name='platform'>
      <?php echo $platform_data; ?>
    </select>
    <p><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></p>
    <input type="submit" value="送信" name="add">
  </form>
  <a href="profile.php">プロフィールをみる</a>
</body>

</html>
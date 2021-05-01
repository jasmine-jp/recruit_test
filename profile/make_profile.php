<?php
session_start();
require('../db/dbconnect.php');

$A = 0;

// DBのmemberに入っているデータを取り出す
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
  $profiles = $db->prepare('SELECT * FROM profiles WHERE member_id=?');
  $profiles->execute(array($_SESSION['id']));
  $profile = $profiles->fetch();
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
  $image = date('YmdHis')  . $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
}
$_SESSION['join']['image']  = $image;
// ----------------------
// print($image);
// データベースへの挿入、更新--------------------------
if ($A == 0) {
  $members = $db->prepare('SELECT COUNT(*) AS cnt FROM profiles WHERE member_id=?');

  $members->execute(array($member['id']));
  $record = $members->fetch();
  if ($record['cnt'] > 0) {
    // ポストの中身が空なら最新しない
    if (!empty($_POST)) {
      // apexIDの最新
      if (!empty($_POST['apex_id'])) {
        $stmt = $db->prepare('UPDATE profiles SET  apex_id = :apex_id WHERE member_id = :member_id ');
        $stmt->execute(array(':apex_id' => $_POST['apex_id'], 'member_id' => $member['id']));
      }
      // imageの最新
      if (!empty($_FILES['image']['name'])) {
        print($profile['profile_image']);
        $filename = $profile['profile_image'];
        unlink($image_file);
        
        $stmt = $db->prepare('UPDATE profiles SET  profile_image = :profile_image  WHERE member_id = :member_id ');
        $stmt->execute(array(':profile_image' => $image, 'member_id' => $member['id']));
      }
      // messageの最新
      if (!empty($_POST['message'])) {
        $stmt = $db->prepare('UPDATE profiles SET  message = :message WHERE member_id = :member_id ');
        $stmt->execute(array(':message' => $_POST['message'], 'member_id' => $member['id']));
      }
      // ランクの最新
      if (!empty($_POST['rank'])) {
        $stmt = $db->prepare('UPDATE profiles SET  rank = :rank WHERE member_id = :member_id ');
        $stmt->execute(array(':rank' => $_POST['rank'], 'member_id' => $member['id']));
      }
      // プラットフォームの最新
      if (!empty($_POST['platform'])) {
        $stmt = $db->prepare('UPDATE profiles SET  platform = :platform WHERE member_id = :member_id ');
        $stmt->execute(array(':platform' => $_POST['platform'], 'member_id' => $member['id']));
      }
    } else {
      $error['profile'] = 'empty';
    }
  } else {
    // 最初のプロフィール設定
    // INSERT文を変数に格納
    $sql = "INSERT INTO profiles (member_id, apex_id, name, profile_image, message, rank,platform, created) VALUES (:member_id, :apex_id,:name, :profile_image, :message, :rank, :platform, now())";

    // 挿入する値は空のまま、SQL実行の準備をする
    $stmt = $db->prepare($sql);

    // 挿入する値を配列に格納する
    $params = array(':member_id' => $member['id'], ':apex_id' => $_POST['apex_id'], ':name' => $member['name'], ':profile_image' => $_FILES['image']['name'], ':message' => $_POST['message'], ':rank' => $_POST['rank'], ':platform' => $_POST['platform']);

    // 挿入する値が入った変数をexecuteにセットしてSQLを実行
    $stmt->execute($params);

    // 登録完了のメッセージ
    echo '登録完了しました';
  }
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
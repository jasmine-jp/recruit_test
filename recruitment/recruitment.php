<?php
session_start();
require('../db/dbconnect.php');

print($_SESSION['id']);
// メンバーのDBを取り出す-------
$members = $db->prepare('SELECT * FROM members WHERE id=?');
$members->execute(array($_SESSION['id']));
$member = $members->fetch();
$profiles = $db->prepare('SELECT * FROM profiles WHERE member_id=? ');
$profiles->execute(array($_SESSION['id']));
$profile = $profiles->fetch();
// --------------------------------


// DBに挿入-----------------変数名かえる
if (isset($_POST['registration'])) {
  $aaa = $db->prepare('SELECT COUNT(*) AS cnt FROM recruit_card WHERE profile_name=?');
    
  $aaa->execute(array($member['name']));
  $record = $aaa->fetch();
   print($member['name']);
  if($record['cnt'] > 0) {
    print("すでに登録されています");
  }else {
    $_SESSION['recruit_time'] = time();


      print("A");
      $recruit = $db->prepare('INSERT INTO recruit_card SET profile_name=?, members_id=?,  member_image=?, mode=?, platform=?, vc=?, ps=?, created=NOW()');
      $recruit->execute(array(
        $member['name'],
        $member['id'],
        $profile['profile_image'],
        $_POST['mode'],
        $_POST['platform'],
        $_POST['vc'],
        $_POST['ps']
      ));
  }
}
// --------------------------------


// セレクトタグ作成 ----------------
$mode_data = [
  '問わない' => '問わない',
  'カジュアル' => 'カジュアル',
  'ブロンズ' => 'ブロンズ',
  'シルバー' => 'シルバー',
  'ゴールド' => 'ゴールド',
  'プラチナ' => 'プラチナ',
  'ダイヤモンド' => 'ダイヤモンド',
  'マスター' => 'マスター',
  'プレデター' => 'プレデター'
];
$platform_data = [
  '問わない' => '問わない',
  'ps4' => 'ps4',
  'xbox' => 'xbox',
  'pc' => 'pc',
  'switch' => 'switch'
];
$vc_data = [
  '問わない' => '問わない',
  'なし' => 'なし',
  'discord' => 'discord',
  'パーティーチャット' => 'パーティーチャット',
  'チャット' => 'チャット'
];
$ps_data = [
  '問わない' => '問わない',
  '問わない' => '問わない',
  'なし' => 'なし',
  '順位' => '順位',
  '漁夫' => '漁夫',
  'キル' => 'キル'
];
foreach ($mode_data as $mode_data_key => $mode_data_val) {
  $mode_data .= "<option value='" . $mode_data_key;
  $mode_data .= "'>" . $mode_data_val . "</option>";
}
foreach ($platform_data as $platform_data_key => $platform_data_val) {
  $platform_data .= "<option value='" . $platform_data_key;
  $platform_data .= "'>" . $platform_data_val . "</option>";
}
foreach ($vc_data as $vc_data_key => $vc_data_val) {
  $vc_data .= "<option value='" . $vc_data_key;
  $vc_data .= "'>" . $vc_data_val . "</option>";
}
foreach ($ps_data as $ps_data_key => $ps_data_val) {
  $ps_data .= "<option value='" . $ps_data_key;
  $ps_data .= "'>" . $ps_data_val . "</option>";
}
// --------------------------------

?>

<!-- 
member_id・・・どの人がやっているかわかるように
MODE（カジュアルなのかどのランクなのか）・・・mode
PF（プラットフォーム）・・・platform
VC（ボイスがあるか）・・・vc
PS（どのようなプレイスタイルか）・・・playstyle 
-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form method="post" action="">
  <p>MODEを選択してください</p>
    <select name='mode'>
      <?php echo $mode_data; ?>
    </select>
  <p>プラットーフォームを選択してください</p>
    <select name='platform'>
      <?php echo $platform_data; ?>
    </select>
  <p>ボイスチャットの有無を選択してださい</p>
    <select name='vc'>
      <?php echo $vc_data; ?>
    </select>
  <p>プレイスタイルを選択してください</p>
    <select name='ps'>
      <?php echo $ps_data; ?>
    </select>
  <input type="submit" value="送信" name="registration">
  </form>
  <a href="../src/index.php">戻る</a>
</body>
</html>
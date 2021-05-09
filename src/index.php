<?php
session_start();
require('../db/dbconnect.php');
 
// 値の取得とジアkん経過によるログイン画面への遷移
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
  $recruits = "SELECT * FROM recruit_card";
  $recruit = $db->query($recruits);
} else {
  header('Location: login.php');
  exit();
}
// -----------------------

// 時間によりrecruit_cardのDBの削除（30分）
if ($_SESSION['recruit_time'] + 1800 > time()) {

} else {
  $recruit_delete = "DELETE FROM recruit_card WHERE profile_name=:profile_name";
  $R_D = $db->prepare($recruit_delete);
  $recruit_param = array(':profile_name' =>$member['name'] );
  $R_D->execute($recruit_param);
  print("削除されました");
}
// ---------------------------
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エペぼ</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <script src="../js/index.js"></script>
</head>
<body>
    <div id="container">
        <header>
        <?php if (!(empty($member['name']))): ?>
        <h1><?php  print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></h1>
        <?php endif; ?>
            <i class="fas fa-bars"></i>
            <form>
                <select class="options">
                    <optgroup label="Mode">
                        <option hidden>Mode</option>
                        <option>問わない</option>
                        <option>カジュアル</option>
                        <option>ブロンズ</option>
                        <option>シルバー</option>
                        <option>ゴールド</option>
                        <option>プラチナ</option>
                        <option>ダイヤ</option>
                        <option>マスター</option>
                        <option>プレデター</option>
                    </optgroup>
                </select>
                <select class="options">
                    <optgroup label="PF">
                        <option hidden>PF</option>
                        <option>問わない</option>
                        <option>PC</option>
                        <option>PS4</option>
                        <option>Xbox</option>
                        <option>Switch</option>
                    </optgroup>
                </select>
                <select class="options">
                    <optgroup label="VC">
                        <option hidden>VC</option>
                        <option>問わない</option>
                        <option>なし</option>
                        <option>Discord</option>
                        <option>Pt</option>
                        <option>Chat</option>
                    </optgroup>
                </select>
                <select class="options">
                    <optgroup label="PS">
                        <option hidden>PS</option>
                        <option>問わない</option>
                        <option>順位</option>
                        <option>漁夫</option>
                        <option>キル</option>
                        <option>安置外</option>
                    </optgroup>
                </select>
            </form>
        </header>
        <div id="main">
            <!-- ここから個々のカード -->
            <!-- <?php foreach($recruit as $card): ?>
            <div class="contents" id="0">
                <div class=content1>
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="detail">
                    <p class="mode"><?php echo($card['profile_name']); ?></p>
                    <div class="detailcontents">
                    <div class="content2">
                            <p>mode:<?php echo($card['mode']); ?></p>
                            <p>PF:<?php echo($card['platform']); ?></p>
                            <p>VC:<?php echo($card['vc']); ?></p>
                            <p>PS:<?php echo($card['ps']); ?></p>
                        </div>
                        <div class="content3">
                            <p>VC:PT</p>
                            <p>PS:順位</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?> -->

            <div class="contents" id="9">
                <div class=content1>
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="detail">
                    <p class="mode">カジュアル</p>
                    <div class="detailcontents">
                        <div class="content2">
                            <p>Lv:500</p>
                            <p>dm:3000</p>
                            <p>kill:10</p>
                        </div>
                        <div class="content3">
                            <p>PF:PS4</p>
                            <p>VC:PT</p>
                            <p>PS:順位</p>
                        </div>
                    </div>
                </div>
        </div>
            <!-- ここまで -->
        </div>
        <footer>
            <p>問い<br>合わせ</p>
            <p><a href="../recruitment/recruitment.php">募集<br>する</a></p>
            <p><a href="../profile/profile.php">設定</a></p>
        </footer>
    </div>
</body>
</html>
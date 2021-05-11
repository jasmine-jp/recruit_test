<?php
session_start();
require('../db/dbconnect.php');
 
// 値の取得とジアkん経過によるログイン画面への遷移
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
//   メンバーのDB取得
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
//   リクルートカードのDB取得
  $recruits = "SELECT * FROM recruit_card";
  $recruit = $db->query($recruits);
} else {
  header('Location: ../php_login/login.php');
  exit();
}
// -----------------------







?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エペぼ</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <!-- <script src="../js/index.js"></script> -->
</head>
<body>
    <div id="container">
        <header>
        <h1><?php  print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></h1>
        <p><a href="../php_login/login.php">ログインする</a></p>
            <i class="fas fa-bars"></i>
            <!-- <form>
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
            </form> -->
        </header>
        <div id="main">
            <!-- ここから個々のカード -->
            <?php foreach($recruit as $card): ?>
            <?php
                // 表示から30分以上経っていたら削除
    $delete_str = array(' ','-',':');
    $created = str_replace($delete_str,'',$card['created']);
    date_default_timezone_set('Asia/Tokyo');
    print(date("YmdHis")-$created);
    if(date("YmdHis")-$created > 3000) {
        $delete = $db->prepare('DELETE FROM recruit_card WHERE members_id=:members_id');
        $delete->execute(array(':members_id' => $card['members_id']));
        header("Location: ../src/index.php");
    }
                
                
                
                ?>
            <div class="contents" id="0">
                <div class=content1>
                    <div calss="card-image"><img class="profile-image" src="../member_picture/<?php echo htmlspecialchars($card['member_image'], ENT_QUOTES); ?>" width="50" height="50" style="border-radius: 50px; margin: 10px;" alt="<?php echo htmlspecialchars($card['name'], ENT_QUOTES); ?>"></div>
                </div>
                <div class="detail">
                    <p class="mode"><?php print(htmlspecialchars($card['mode'], ENT_QUOTES)); ?></p>
                    <div class="detailcontents">
                        <div class="content3">
                            <p>名前: <?php print(htmlspecialchars($card['profile_name'], ENT_QUOTES)); ?></p>
                            <p>PF: <?php print(htmlspecialchars($card['platform'], ENT_QUOTES)); ?></p>
                            <p>VC:  <?php print(htmlspecialchars($card['vc'], ENT_QUOTES)); ?></p>
                            <p>PS:<?php print(htmlspecialchars($card['ps'], ENT_QUOTES)); ?></p>
                            <p>募集人数:</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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
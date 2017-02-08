<?php
session_start();
require('dbconnect.php');
// echo $_SESSION['id'];
// echo '<br>';
// echo $_SESSION['time'];

// ログイン状態のチェック
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // ログイン状態の定義
      // $_SESSION['id']が存在する
      // $_SESSION['time']が現在時刻の1時間 (3600秒) 以内である

    // ユーザーがアクションするごとに (ページがリロードされるごとに) 時間を更新
    $_SESSION['time'] = time();

    // ログインしていればログインユーザー情報をDBから取得
    $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
    $data = array($_SESSION['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $login_member = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // ログインせずにページを訪れた場合はlogin.phpへ遷移
    header('Location: login.php');
    exit();
}

// ツイートボタンが押されたとき
if (!empty($_POST)) {
    if ($_POST['tweet'] != '') {
        // tweetsテーブルに投稿データを登録 : Create - INSERT
        $sql = 'INSERT INTO `tweets` SET `tweet`=?,
                                          `member_id`=?,
                                          `created`=NOW()';
        $data = array($_POST['tweet'], $_SESSION['id']);

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // データ登録後一度画面をリロードしPOST送信をリセットする
        header('Location: index.php');
        exit();
    }
}

// ツイートデータをデータベースから取得
$sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t, `members` AS m WHERE m.member_id = t.member_id ORDER BY t.created DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php echo $login_member['nick_name']; ?><br>
  <img src="member_picture/<?php echo $login_member['picture_path']; ?>" width="100"><br>

  <br>

  <form method="POST" action="index.php">
    <div>
      <textarea name="tweet" placeholder="つぶやき" cols="50" rows="5"></textarea>
    </div>
    <input type="submit" value="ツイート">
  </form>

  <?php while($tweet = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    id : <?php echo $tweet['tweet_id']; ?> - <img src="member_picture/<?php echo $tweet['picture_path']; ?>" style="width: 16px;"><?php echo $tweet['tweet']; ?> <span style="font-size: 14px; color: #808080;"><?php echo $tweet['created']; ?> (<?php echo $tweet['nick_name']; ?>)</span><br>
  <?php endwhile; ?>

</body>
</html>












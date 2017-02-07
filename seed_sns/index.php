<?php
session_start();
require('dbconnect.php');
echo $_SESSION['id'];
echo '<br>';
echo $_SESSION['time'];

// ログイン状態のチェック
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // ログイン状態の定義
      // $_SESSION['id']が存在する
      // $_SESSION['time']が現在時刻の1時間 (3600秒) 以内である

    // ログインしていればログインユーザー情報をDBから取得
    $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
    $data = array($_SESSION['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $login_member = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // ログインせずにページを訪れた場合はlogin.phpへ遷移
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php echo $login_member['nick_name']; ?>
  <img src="member_picture/<?php echo $login_member['picture_path']; ?>" width="100">

</body>
</html>

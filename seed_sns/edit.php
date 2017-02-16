<?php
session_start();
require('dbconnect.php');

if (empty($_REQUEST['tweet_id'])) {
    header('Location: index.php');
    exit();
}

$sql = 'SELECT m.nick_name, m.picture_path, t.* FROM `tweets` t, `members` m WHERE m.member_id = t.member_id AND t.tweet_id = ?';
$data = array($_REQUEST['tweet_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// 更新ボタンが押されたとき
if (!empty($_POST)) {
    if ($_POST['tweet'] != '') {
        $sql = 'UPDATE `tweets` SET `tweet`=? WHERE `tweet_id`=?';
        // $dataには何が入るのか？
        $data = array($_POST['tweet'], $_REQUEST['tweet_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php if($tweet = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <form action="" method="POST">
      <!-- ログインユーザー名表示 -->
      <p>投稿者 : <?php echo $tweet['nick_name']; ?></p>
      <!-- ログインユーザー画像表示 -->
      <img src="member_picture/<?php echo $tweet['picture_path']; ?>" width="200"><br>
      <!-- つぶやき内容をテキストエリアを使って表示 -->
      つぶやき : <br>
      <!-- $_POST['tweet'] -->
      <textarea name="tweet" cols="50" rows="5"><?php echo $tweet['tweet']; ?></textarea><br>
      <!-- 投稿日表示 -->
      投稿日 : <?php echo $tweet['created']; ?>
      <!-- 更新ボタン設置 -->
      <input type="submit" value="更新">
    </form>
  <?php else: ?>
    <p>その投稿は削除されたか、URLが間違っています。</p>
  <?php endif; ?>
  <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
</body>
</html>








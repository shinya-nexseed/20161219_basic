<?php
session_start();
require('dbconnect.php');

// ページ閲覧制限
if (empty($_REQUEST['tweet_id'])) {
    // パラメータにtweet_idが存在しなければindex.phpへ遷移
    header('Location: index.php');
    exit();
}

$tweet_id = $_REQUEST['tweet_id'];
echo $tweet_id;

// 投稿データ一件取得
$sql = 'SELECT m.nick_name, m.picture_path, t.* FROM `tweets` t, `members` m WHERE m.member_id=t.member_id AND t.tweet_id=?';
$data = array($tweet_id);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php if($tweet = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <!-- データが存在する場合の表示 -->
    <p>投稿者 : <?php echo $tweet['nick_name']; ?></p>
    <img src="member_picture/<?php echo $tweet['picture_path']; ?>" width="200"><br>
    つぶやき : <br>
    <?php echo $tweet['tweet']; ?><br>
    投稿日 : <?php echo $tweet['created']; ?><br>
  <?php else: ?>
    <!-- データが存在しない場合の表示 -->
    <p>その投稿は削除されたか、URLが間違っています。</p>
  <?php endif; ?>
  <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
</body>
</html>






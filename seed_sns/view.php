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

// いいね!のロジック実装
if (!empty($_POST)) {
    if ($_POST['like'] === 'like') {
        // いいね!データの登録
        $sql = 'INSERT INTO `likes` SET member_id=?, tweet_id=?, created=NOW()';
        $data = array($_SESSION['id'],$tweet_id);
        $like_stmt = $dbh->prepare($sql);
        $like_stmt->execute($data);
        header('Location: view.php?tweet_id='.$tweet_id);
        exit();
    } else {
        // いいね!データの削除
        $sql = 'DELETE FROM `likes` WHERE member_id=? AND tweet_id=?';
        $data = array($_SESSION['id'],$tweet_id);
        $like_stmt = $dbh->prepare($sql);
        $like_stmt->execute($data);
        header('Location: view.php?tweet_id='.$tweet_id);
        exit();
    }
}

// いいね!済みかどうかの判定
$sql = 'SELECT * FROM `likes` WHERE member_id=? AND tweet_id=?';
// $likes変数には、いいね!データがあれば1件、なければ0件のデータが入る
$data = array($_SESSION['id'],$tweet_id);
$like_stmt = $dbh->prepare($sql);
$like_stmt->execute($data);

// いいね!数カウント
$sql = 'SELECT COUNT(*) AS like_count FROM `likes` WHERE tweet_id=?';
// $likes変数には、いいね!データがあれば1件、なければ0件のデータが入る
$data = array($tweet_id);
$like_count_stmt = $dbh->prepare($sql);
$like_count_stmt->execute($data);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
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

    <form action="" method="post">
      <?php if ($like_count = $like_count_stmt->fetch(PDO::FETCH_ASSOC)): ?>
        いいね！数 : <?php echo $like_count['like_count']; ?>
      <?php endif; ?>
      <?php if ($like = $like_stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <!-- $_POSTの内容を作る -->
        <input type="hidden" name="like" value="unlike">
        <!-- $_POST['like'] = 'like' -->
        <input type="submit" value="いいね!取り消し" class="btn btn-danger btn-xs">
      <?php else: ?>
        <!-- $_POSTの内容を作る -->
        <input type="hidden" name="like" value="like">
        <!-- $_POST['like'] = 'like' -->
        <input type="submit" value="いいね!" class="btn btn-primary btn-xs">
      <?php endif; ?>
    </form>
  <?php else: ?>
    <!-- データが存在しない場合の表示 -->
    <p>その投稿は削除されたか、URLが間違っています。</p>
  <?php endif; ?>
  <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
</body>
</html>






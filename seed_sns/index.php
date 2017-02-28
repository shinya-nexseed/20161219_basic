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
                                          `reply_tweet_id`=?,
                                          `created`=NOW()';
        $data = array($_POST['tweet'], $_SESSION['id'], $_POST['reply_tweet_id']);

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // データ登録後一度画面をリロードしPOST送信をリセットする
        header('Location: index.php');
        exit();
    }
}

// 検索された場合
$search_word = '';
if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
    // 検索ワードに一致するツイートデータをデータベースから取得
    $search_word = $_GET['search_word'];
    $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t, `members` AS m WHERE m.member_id = t.member_id AND t.tweet LIKE ? ORDER BY t.created DESC';
    $w = '%' . $_GET['search_word'] . '%';
    $data = array($w);
    // LIKE句 + %を使ったあいまい検索
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
} else {
    // ツイートデータをデータベースから取得
    $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t, `members` AS m WHERE m.member_id = t.member_id ORDER BY t.created DESC';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
}

// 返信機能
$re_tweet ='';
if (isset($_REQUEST['res'])) {
    $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t LEFT JOIN `members` AS m ON m.member_id = t.member_id WHERE t.tweet_id = ?';
    $data = array($_REQUEST['res']);
    $re_stmt = $dbh->prepare($sql);
    $re_stmt->execute($data);

    $tweet = $re_stmt->fetch(PDO::FETCH_ASSOC);
    $re_tweet = '@' . $tweet['nick_name'] . ' - ' . $tweet['tweet'];
}

// いいね!のロジック実装
if (!empty($_POST)) {
    if ($_POST['like'] === 'like') {
        // いいね!データの登録
        $sql = 'INSERT INTO `likes` SET member_id=?, tweet_id=?, created=NOW()';
        $data = array($_SESSION['id'],$_POST['tweet_id']);
        $like_stmt = $dbh->prepare($sql);
        $like_stmt->execute($data);
        header('Location: index.php');
        exit();
    } else {
        // いいね!データの削除
        $sql = 'DELETE FROM `likes` WHERE member_id=? AND tweet_id=?';
        $data = array($_SESSION['id'],$_POST['tweet_id']);
        $like_stmt = $dbh->prepare($sql);
        $like_stmt->execute($data);
        header('Location: index.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="assets/css/form.css" rel="stylesheet">
  <link href="assets/css/timeline.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <title></title>
</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="user_edit.php">プロフィール編集</a></li>
                <li><a href="logout.php">ログアウト</a></li>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>ようこそ<?php echo $login_member['nick_name']; ?>さん！</legend>
        <form method="POST" action="index.php" class="form-horizontal" role="form">
            <!-- つぶやき -->
            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"><?php echo $re_tweet; ?></textarea>
                <?php if(isset($_REQUEST['res'])): ?>
                  <input type="hidden" name="reply_tweet_id" value="<?php echo $_REQUEST['res']; ?>">
                <?php endif; ?>
              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <li><a href="index.html" class="btn btn-default">前</a></li>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <li><a href="index.html" class="btn btn-default">次</a></li>
          </ul>
        </form>
      </div>

      <div class="col-md-8 content-margin-top">
        <!-- 検索ボックス -->
        <form method="GET" action="index.php" class="form-horizontal" role="form">
          <input type="text" name="search_word" value="<?php echo $search_word; ?>">
          <input type="submit" value="検索" class="btn btn-success btn-xs">
        </form>

        <?php while($tweet = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
          <?php
            // いいね!済みかどうかの判定
            $sql = 'SELECT * FROM `likes` WHERE member_id=? AND tweet_id=?';
            // $likes変数には、いいね!データがあれば1件、なければ0件のデータが入る
            $data = array($_SESSION['id'],$tweet['tweet_id']);
            $like_stmt = $dbh->prepare($sql);
            $like_stmt->execute($data);

            // いいね!数カウント
            $sql = 'SELECT COUNT(*) AS like_count FROM `likes` WHERE tweet_id=?';
            // $likes変数には、いいね!データがあれば1件、なければ0件のデータが入る
            $data = array($tweet['tweet_id']);
            $like_count_stmt = $dbh->prepare($sql);
            $like_count_stmt->execute($data);
            $like_count = $like_count_stmt->fetch(PDO::FETCH_ASSOC);
           ?>
          <div class="msg">
            <img src="member_picture/<?php echo $tweet['picture_path']; ?>" width="48" height="48">
            <p>
              <?php echo $tweet['tweet']; ?><span class="name"> (<?php echo $tweet['nick_name']; ?>) </span>
              [<a href="index.php?res=<?php echo $tweet['tweet_id']; ?>">Re</a>]
            </p>
            <p class="day">
              <a href="view.php?tweet_id=<?php echo $tweet['tweet_id']; ?>">
                <?php echo $tweet['created']; ?>
              </a>
              <?php if($tweet['member_id'] == $_SESSION['id']): ?>
                [<a href="edit.php?tweet_id=<?php echo $tweet['tweet_id']; ?>" style="color: #00994C;">編集</a>]
                [<a href="delete.php?tweet_id=<?php echo $tweet['tweet_id']; ?>" style="color: #F33;">削除</a>]
              <?php endif; ?>
            </p>
            <form action="" method="post">
              いいね！数 : <?php echo $like_count['like_count']; ?>
              <?php if ($like = $like_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <!-- $_POSTの内容を作る -->
                <input type="hidden" name="like" value="unlike">
                <input type="hidden" name="tweet_id" value="<?php echo $tweet['tweet_id']; ?>">
                <!-- $_POST['like'] = 'like' -->
                <input type="submit" value="いいね!取り消し" class="btn btn-danger btn-xs">
              <?php else: ?>
                <!-- $_POSTの内容を作る -->
                <input type="hidden" name="like" value="like">
                <input type="hidden" name="tweet_id" value="<?php echo $tweet['tweet_id']; ?>">
                <!-- $_POST['like'] = 'like' -->
                <input type="submit" value="いいね!" class="btn btn-primary btn-xs">
              <?php endif; ?>
            </form>
          </div>
        <?php endwhile; ?>
      </div>

    </div>
  </div>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>












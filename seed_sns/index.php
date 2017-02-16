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

// ツイートデータをデータベースから取得
$sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t, `members` AS m WHERE m.member_id = t.member_id ORDER BY t.created DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();

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
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!">"><?php echo $re_tweet; ?></textarea>
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
        <?php while($tweet = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
          <div class="msg">
            <img src="http://c85c7a.medialib.glogster.com/taniaarca/media/71/71c8671f98761a43f6f50a282e20f0b82bdb1f8c/blog-images-1349202732-fondo-steve-jobs-ipad.jpg" width="48" height="48">
            <p>
              つぶやき１<span class="name"> (Seed kun) </span>
              [<a href="#">Re</a>]
            </p>
            <p class="day">
              <a href="view.html">
                2016-01-28 18:01
              </a>
              [<a href="#" style="color: #00994C;">編集</a>]
              [<a href="#" style="color: #F33;">削除</a>]
            </p>
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












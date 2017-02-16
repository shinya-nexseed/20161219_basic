<?php
    session_start(); // セッション使用の条件
    // データベース接続ファイルを読み込み
    require('../dbconnect.php');
    // require()は指定したファイルの内容を読み込む

    // $_SESSION = array();
    // unset($_SESSION['join']);
    // session_destroy();

    // もしセッションがなかったらindex.phpへ遷移
    if (!isset($_SESSION['join'])) {
        header('Location: index.php');
        exit();
    }

    // var_dump($_SESSION['join']);

    // 登録ボタンが押されたとき (POST送信されたとき)
    if (!empty($_POST)) {
        // データベースのmembersテーブルに情報を登録
        echo 'POST送信されました。' . '<br>';

        try{
            // Create : INSERT
            // $sql = 'INSERT INTO `members`
            // (`nick_name`, `email` `password`, `picture_path`, `created`) VALUES
            // ("Shinya", "shinya@gmail.com", "hogehoge", "shinya.jpg", NOW())';

            $sql = 'INSERT INTO `members` SET `nick_name`=?,
                                              `email`=?,
                                              `password`=?,
                                              `picture_path`=?,
                                              `created`=NOW()';

            $data = array($_SESSION['join']['nick_name'],
                          $_SESSION['join']['email'],
                          sha1($_SESSION['join']['password']),
                          $_SESSION['join']['picture_path']
                          );
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            header('Location: thanks.php');
            exit();
        }catch(PDOException $e){
            echo 'SQL実行時エラー: '. $e->getMessage();
            exit();
        }

    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/css/main.css" rel="stylesheet">
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
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <form method="POST" action="check.php" class="form-horizontal" role="form">
          <input type="hidden" name="action" value="submit">
          <div class="well">ご登録内容をご確認ください。</div>
            <table class="table table-striped table-condensed">
              <tbody>
                <!-- 登録内容を表示 -->
                <tr>
                  <td><div class="text-center">ニックネーム</div></td>
                  <td><div class="text-center"><?php echo htmlspecialchars($_SESSION['join']['nick_name']); ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">メールアドレス</div></td>
                  <td><div class="text-center"><?php echo htmlspecialchars($_SESSION['join']['email']); ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">パスワード</div></td>
                  <td><div class="text-center">●●●●●●●●</div></td>
                </tr>
                <tr>
                  <td><div class="text-center">プロフィール画像</div></td>
                  <td><div class="text-center"><img src="../member_picture/<?php echo htmlspecialchars($_SESSION['join']['picture_path']); ?>" width="100"></div></td>
                </tr>
              </tbody>
            </table>

            <a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> |
            <input type="submit" class="btn btn-default" value="会員登録">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>














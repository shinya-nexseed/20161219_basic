<?php
    // $_SESSIONを使用可能にするための関数
    session_start();
    require('../dbconnect.php');

    // SESSIONとは、サーバー内に用意された簡易データベースのようなもの
    // Key Value Store (KVS) の形式で、データを保存しておける
    // ブラウザとサーバーの接続が切れるまでそのデータを保存し続ける
    // 一度保存したデータは、存在する限りどのファイル上でも使用が可能


    // 各入力値を保持する変数を用意
    $nick_name = '';
    $email = '';
    $password = '';

    // フォームからデータがPOST送信されたとき
    if (!empty($_POST)) {
        var_dump($_POST);
        $nick_name = $_POST['nick_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // フォームのバリデーション
        $error = array();

        // ニックネームの入力チェック
        if ($_POST['nick_name'] == '') {
            $error['nick_name'] = 'blank';
        }

        // メールアドレスの入力チェック
        if ($_POST['email'] == '') {
            $error['email'] = 'blank';
        }

        // パスワードの入力チェック
        if ($_POST['password'] == '') {
            $error['password'] = 'blank';
        } elseif (strlen($_POST['password']) < 4) {
            $error['password'] = 'length';
        }

        // 画像の入力チェック
        // if ($_FILES['picture_path']['name'] == '') {
        //     $error['picture_path'] = 'blank';
        // }

        // プロフィール画像の拡張子チェック
        $fileName = $_FILES['picture_path']['name'];
        // $_FILESは、fileタイプのinputタグが送信したデータを受け取るスーパーグローバル変数
        // 一つ目のキーにはinputタグのnameオプションの値をセットする。
        // 二つ目には予め定義されているキーをセットし情報を取得する。
        // 今回の場合、選択された画像の名前を取得したいので、二つ目のキーにはnameをセットした (PHPが予め決めているキー)
        if (!empty($fileName)) {
            $ext = substr($fileName, -3);
            // substrは指定した文字列から指定した箇所から後の文字のみ取得する
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
                $error['picture_path'] = 'type';
            }
        }

        // メール重複チェック (DBとの比較)
        if (empty($error)) {
            $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email`=?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($record['cnt'] > 0) {
                // メール重複
                $error['email'] = 'duplicate';
            }
        }

        // エラーがなかったとき
        if (empty($error)) {
            // 画像をサーバー (CentOS) へアップロードする
            $picture_path = date('YmdHis') . $_FILES['picture_path']['name'];
            move_uploaded_file($_FILES['picture_path']['tmp_name'], '../member_picture/' . $picture_path);
            // move_uploaded_fileはブラウザからサーバーへファイルデータをアップロードするためのPHPの関数 (機能)
            // ()の中には、一つ目にファイルデータを、二つ目に保存先と保存する際のファイル名を指定する

            // Unixコマンドでフォルダの権限を変更する
            // chown ユーザー:グループ パス
            // chown apache:apache member_picture


            // セッションに値を保存する (check.phpにPOST送信データを引き継ぐ)
            $_SESSION['join'] = $_POST;
            $_SESSION['join']['picture_path'] = $picture_path;
            // $_SESSION['join'] = array('nick_name' => 'hoge',
            //                           'email' => 'hoge@gmail.com',
            //                           'password' => 'hogehoge',
            //                           'picture_path' => '201702031010shinya.jpg');

            // 確認画面へ遷移
            header('Location: check.php');
            exit();
        }
    }

    // 書き直し処理
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
        $nick_name = $_SESSION['join']['nick_name'];
        $email = $_SESSION['join']['email'];
        $error['rewrite'] = 'rewrite';
    }
    // $_REQUESTスーパーグローバル変数
    // $_GET、$_POST、$_COOKIEの情報を含むスーパーグローバル変数
    // $_REQUEST == $_GET
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <!-- Bootstrapレスポンシブ対応 -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Seed SNS</title>
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
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>会員登録</legend>
        <form method="POST" action="index.php" class="form-horizontal" role="form" enctype="multipart/form-data">
          <!-- ニックネーム -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun" value="<?php echo $nick_name; ?>">
              <?php if(isset($error['nick_name']) && $error['nick_name'] == 'blank'): ?>
                <p style="color: red;">ニックネームを入力してください</p>
              <?php endif; ?>
            </div>
          </div>
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com" value="<?php echo $email; ?>">
              <?php if(isset($error['email']) && $error['email'] == 'blank'): ?>
                <p style="color: red;">メールアドレスを入力してください</p>
              <?php endif; ?>

              <?php if(isset($error['email']) && $error['email'] == 'duplicate'): ?>
                <p style="color: red;">指定したメールアドレスは既に登録されています</p>
              <?php endif; ?>
            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
                <p style="color: red;">パスワードを入力してください</p>
              <?php endif; ?>
              <?php if(isset($error['password']) && $error['password'] == 'length'): ?>
                <p style="color: red;">パスワードは4文字以上で入力してください</p>
              <?php endif; ?>
            </div>
          </div>
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <input type="file" name="picture_path" class="form-control">
              <?php if(isset($error['picture_path']) && $error['picture_path'] == 'type'): ?>
                <p style="color: red;">プロフィール画像の拡張子は「jpg」「png」「gif」のデータを指定してください</p>
              <?php endif; ?>
              <?php if(!empty($error)): ?>
                <p style="color: red;">画像を再度指定してください</p>
              <?php endif; ?>
            </div>
          </div>

          <input type="submit" class="btn btn-default" value="確認画面へ">
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





